"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const database_1 = __importDefault(require("../db/database"));
const auth_1 = require("../middleware/auth");
const router = (0, express_1.Router)();
// Create booking
router.post('/', auth_1.authenticate, (req, res) => {
    if (req.user.role !== 'client') {
        res.status(403).json({ error: 'Only clients can create bookings' });
        return;
    }
    const { service_id, business_id, appointment_date, appointment_time, notes } = req.body;
    if (!service_id || !business_id || !appointment_date || !appointment_time) {
        res.status(400).json({ error: 'service_id, business_id, appointment_date, and appointment_time are required' });
        return;
    }
    // Check for conflict
    const conflict = database_1.default.prepare("SELECT id FROM bookings WHERE business_id = ? AND appointment_date = ? AND appointment_time = ? AND status != 'cancelled'").get(business_id, appointment_date, appointment_time);
    if (conflict) {
        res.status(409).json({ error: 'This time slot is already booked' });
        return;
    }
    const result = database_1.default.prepare('INSERT INTO bookings (client_id, service_id, business_id, appointment_date, appointment_time, notes) VALUES (?, ?, ?, ?, ?, ?)').run(req.user.id, service_id, business_id, appointment_date, appointment_time, notes || null);
    const booking = database_1.default.prepare('SELECT * FROM bookings WHERE id = ?').get(result.lastInsertRowid);
    res.status(201).json(booking);
});
// Get client's bookings
router.get('/my', auth_1.authenticate, (req, res) => {
    const bookings = database_1.default.prepare(`
    SELECT b.*, s.name as service_name, s.duration_minutes, s.price, bus.name as business_name
    FROM bookings b
    JOIN services s ON b.service_id = s.id
    JOIN businesses bus ON b.business_id = bus.id
    WHERE b.client_id = ?
    ORDER BY b.appointment_date DESC, b.appointment_time DESC
  `).all(req.user.id);
    res.json(bookings);
});
// Get business's bookings
router.get('/business', auth_1.authenticate, (req, res) => {
    if (req.user.role !== 'business') {
        res.status(403).json({ error: 'Not authorized' });
        return;
    }
    const business = database_1.default.prepare('SELECT id FROM businesses WHERE owner_id = ?').get(req.user.id);
    if (!business) {
        res.json([]);
        return;
    }
    const bookings = database_1.default.prepare(`
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
router.patch('/:id', auth_1.authenticate, (req, res) => {
    const booking = database_1.default.prepare('SELECT * FROM bookings WHERE id = ?').get(req.params.id);
    if (!booking) {
        res.status(404).json({ error: 'Booking not found' });
        return;
    }
    // Client can cancel their own booking, business owner can confirm/cancel
    const business = database_1.default.prepare('SELECT owner_id FROM businesses WHERE id = ?').get(booking.business_id);
    const isClient = booking.client_id === req.user.id;
    const isOwner = business && business.owner_id === req.user.id;
    if (!isClient && !isOwner) {
        res.status(403).json({ error: 'Not authorized' });
        return;
    }
    const { status } = req.body;
    if (!['pending', 'confirmed', 'cancelled'].includes(status)) {
        res.status(400).json({ error: 'Invalid status' });
        return;
    }
    database_1.default.prepare('UPDATE bookings SET status = ? WHERE id = ?').run(status, req.params.id);
    const updated = database_1.default.prepare('SELECT * FROM bookings WHERE id = ?').get(req.params.id);
    res.json(updated);
});
exports.default = router;
