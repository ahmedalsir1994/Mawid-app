import { Router, Request, Response } from 'express';
import db from '../db/database';
import { authenticate } from '../middleware/auth';

const router = Router();

// Create booking
router.post('/', authenticate, (req: Request, res: Response): void => {
  if (req.user!.role !== 'client') {
    res.status(403).json({ error: 'Only clients can create bookings' });
    return;
  }
  const { service_id, business_id, appointment_date, appointment_time, notes } = req.body;
  if (!service_id || !business_id || !appointment_date || !appointment_time) {
    res.status(400).json({ error: 'service_id, business_id, appointment_date, and appointment_time are required' });
    return;
  }
  // Check for conflict
  const conflict = db.prepare(
    "SELECT id FROM bookings WHERE business_id = ? AND appointment_date = ? AND appointment_time = ? AND status != 'cancelled'"
  ).get(business_id, appointment_date, appointment_time);
  if (conflict) {
    res.status(409).json({ error: 'This time slot is already booked' });
    return;
  }
  const result = db.prepare(
    'INSERT INTO bookings (client_id, service_id, business_id, appointment_date, appointment_time, notes) VALUES (?, ?, ?, ?, ?, ?)'
  ).run(req.user!.id, service_id, business_id, appointment_date, appointment_time, notes || null);
  const booking = db.prepare('SELECT * FROM bookings WHERE id = ?').get(result.lastInsertRowid);
  res.status(201).json(booking);
});

// Get client's bookings
router.get('/my', authenticate, (req: Request, res: Response): void => {
  const bookings = db.prepare(`
    SELECT b.*, s.name as service_name, s.duration_minutes, s.price, bus.name as business_name
    FROM bookings b
    JOIN services s ON b.service_id = s.id
    JOIN businesses bus ON b.business_id = bus.id
    WHERE b.client_id = ?
    ORDER BY b.appointment_date DESC, b.appointment_time DESC
  `).all(req.user!.id);
  res.json(bookings);
});

// Get business's bookings
router.get('/business', authenticate, (req: Request, res: Response): void => {
  if (req.user!.role !== 'business') {
    res.status(403).json({ error: 'Not authorized' });
    return;
  }
  const business = db.prepare('SELECT id FROM businesses WHERE owner_id = ?').get(req.user!.id) as any;
  if (!business) {
    res.json([]);
    return;
  }
  const bookings = db.prepare(`
    SELECT b.*, s.name as service_name, s.duration_minutes, s.price, u.name as client_name, u.email as client_email
    FROM bookings b
    JOIN services s ON b.service_id = s.id
    JOIN users u ON b.client_id = u.id
    WHERE b.business_id = ?
    ORDER BY b.appointment_date DESC, b.appointment_time DESC
  `).all(business.id);
  res.json(bookings);
});

// Update booking status
router.patch('/:id', authenticate, (req: Request, res: Response): void => {
  const booking = db.prepare('SELECT * FROM bookings WHERE id = ?').get(req.params.id) as any;
  if (!booking) {
    res.status(404).json({ error: 'Booking not found' });
    return;
  }
  // Client can cancel their own booking, business owner can confirm/cancel
  const business = db.prepare('SELECT owner_id FROM businesses WHERE id = ?').get(booking.business_id) as any;
  const isClient = booking.client_id === req.user!.id;
  const isOwner = business && business.owner_id === req.user!.id;
  if (!isClient && !isOwner) {
    res.status(403).json({ error: 'Not authorized' });
    return;
  }
  const { status } = req.body;
  if (!['pending', 'confirmed', 'cancelled'].includes(status)) {
    res.status(400).json({ error: 'Invalid status' });
    return;
  }
  db.prepare('UPDATE bookings SET status = ? WHERE id = ?').run(status, req.params.id);
  const updated = db.prepare('SELECT * FROM bookings WHERE id = ?').get(req.params.id);
  res.json(updated);
});

export default router;
