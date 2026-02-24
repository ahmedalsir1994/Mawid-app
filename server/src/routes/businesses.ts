import { Router, Request, Response } from 'express';
import db from '../db/database';
import { authenticate } from '../middleware/auth';

const router = Router();

// List all businesses
router.get('/', (req: Request, res: Response): void => {
  const { category, search } = req.query;
  let query = 'SELECT * FROM businesses WHERE 1=1';
  const params: any[] = [];
  if (category) {
    query += ' AND category = ?';
    params.push(category);
  }
  if (search) {
    query += ' AND (name LIKE ? OR description LIKE ?)';
    params.push(`%${search}%`, `%${search}%`);
  }
  const businesses = db.prepare(query).all(...params);
  res.json(businesses);
});

// Get business by id with services
router.get('/:id', (req: Request, res: Response): void => {
  const business = db.prepare('SELECT * FROM businesses WHERE id = ?').get(req.params.id) as any;
  if (!business) {
    res.status(404).json({ error: 'Business not found' });
    return;
  }
  const services = db.prepare('SELECT * FROM services WHERE business_id = ?').all(req.params.id);
  res.json({ ...business, services });
});

// Create business
router.post('/', authenticate, (req: Request, res: Response): void => {
  if (req.user!.role !== 'business') {
    res.status(403).json({ error: 'Only business accounts can create businesses' });
    return;
  }
  const { name, description, category, address, phone } = req.body;
  if (!name || !category) {
    res.status(400).json({ error: 'Name and category are required' });
    return;
  }
  const result = db.prepare('INSERT INTO businesses (owner_id, name, description, category, address, phone) VALUES (?, ?, ?, ?, ?, ?)').run(req.user!.id, name, description || null, category, address || null, phone || null);
  const business = db.prepare('SELECT * FROM businesses WHERE id = ?').get(result.lastInsertRowid);
  res.status(201).json(business);
});

// Update business
router.put('/:id', authenticate, (req: Request, res: Response): void => {
  const business = db.prepare('SELECT * FROM businesses WHERE id = ?').get(req.params.id) as any;
  if (!business) {
    res.status(404).json({ error: 'Business not found' });
    return;
  }
  if (business.owner_id !== req.user!.id) {
    res.status(403).json({ error: 'Not authorized' });
    return;
  }
  const { name, description, category, address, phone } = req.body;
  db.prepare('UPDATE businesses SET name=?, description=?, category=?, address=?, phone=? WHERE id=?').run(name || business.name, description ?? business.description, category || business.category, address ?? business.address, phone ?? business.phone, req.params.id);
  const updated = db.prepare('SELECT * FROM businesses WHERE id = ?').get(req.params.id);
  res.json(updated);
});

// List services for a business
router.get('/:id/services', (req: Request, res: Response): void => {
  const services = db.prepare('SELECT * FROM services WHERE business_id = ?').all(req.params.id);
  res.json(services);
});

// Add service
router.post('/:id/services', authenticate, (req: Request, res: Response): void => {
  const business = db.prepare('SELECT * FROM businesses WHERE id = ?').get(req.params.id) as any;
  if (!business) {
    res.status(404).json({ error: 'Business not found' });
    return;
  }
  if (business.owner_id !== req.user!.id) {
    res.status(403).json({ error: 'Not authorized' });
    return;
  }
  const { name, description, duration_minutes, price } = req.body;
  if (!name || !duration_minutes || price === undefined) {
    res.status(400).json({ error: 'Name, duration_minutes, and price are required' });
    return;
  }
  const result = db.prepare('INSERT INTO services (business_id, name, description, duration_minutes, price) VALUES (?, ?, ?, ?, ?)').run(req.params.id, name, description || null, duration_minutes, price);
  const service = db.prepare('SELECT * FROM services WHERE id = ?').get(result.lastInsertRowid);
  res.status(201).json(service);
});

// Update service
router.put('/:id/services/:serviceId', authenticate, (req: Request, res: Response): void => {
  const business = db.prepare('SELECT * FROM businesses WHERE id = ?').get(req.params.id) as any;
  if (!business || business.owner_id !== req.user!.id) {
    res.status(403).json({ error: 'Not authorized' });
    return;
  }
  const service = db.prepare('SELECT * FROM services WHERE id = ? AND business_id = ?').get(req.params.serviceId, req.params.id) as any;
  if (!service) {
    res.status(404).json({ error: 'Service not found' });
    return;
  }
  const { name, description, duration_minutes, price } = req.body;
  db.prepare('UPDATE services SET name=?, description=?, duration_minutes=?, price=? WHERE id=?').run(name || service.name, description ?? service.description, duration_minutes || service.duration_minutes, price ?? service.price, req.params.serviceId);
  const updated = db.prepare('SELECT * FROM services WHERE id = ?').get(req.params.serviceId);
  res.json(updated);
});

// Delete service
router.delete('/:id/services/:serviceId', authenticate, (req: Request, res: Response): void => {
  const business = db.prepare('SELECT * FROM businesses WHERE id = ?').get(req.params.id) as any;
  if (!business || business.owner_id !== req.user!.id) {
    res.status(403).json({ error: 'Not authorized' });
    return;
  }
  db.prepare('DELETE FROM services WHERE id = ? AND business_id = ?').run(req.params.serviceId, req.params.id);
  res.json({ success: true });
});

// Get availability
router.get('/:id/availability', (req: Request, res: Response): void => {
  const { date, serviceId } = req.query;
  if (!date || !serviceId) {
    res.status(400).json({ error: 'date and serviceId are required' });
    return;
  }
  const service = db.prepare('SELECT * FROM services WHERE id = ? AND business_id = ?').get(serviceId as string, req.params.id) as any;
  if (!service) {
    res.status(404).json({ error: 'Service not found' });
    return;
  }

  // Validate date format (YYYY-MM-DD)
  if (!/^\d{4}-\d{2}-\d{2}$/.test(date as string)) {
    res.status(400).json({ error: 'Invalid date format. Use YYYY-MM-DD' });
    return;
  }

  // Businesses are closed on Sundays (day 0); no slots available
  const [year, month, day] = (date as string).split('-').map(Number);
  const dateObj = new Date(year, month - 1, day);
  if (isNaN(dateObj.getTime()) || dateObj.getDay() === 0) {
    res.json({ slots: [] });
    return;
  }

  const duration = service.duration_minutes as number;
  const slots: string[] = [];
  const startHour = 9;
  const endHour = 18;

  let current = startHour * 60;
  const end = endHour * 60;
  while (current + duration <= end) {
    const h = Math.floor(current / 60);
    const m = current % 60;
    slots.push(`${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`);
    current += duration;
  }

  const booked = db.prepare(
    "SELECT appointment_time FROM bookings WHERE business_id = ? AND appointment_date = ? AND status != 'cancelled'"
  ).all(req.params.id, date as string).map((b: any) => b.appointment_time);

  const available = slots.filter(s => !booked.includes(s));
  res.json({ slots: available });
});

export default router;
