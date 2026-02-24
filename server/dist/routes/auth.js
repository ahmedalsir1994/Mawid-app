"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const bcryptjs_1 = __importDefault(require("bcryptjs"));
const jsonwebtoken_1 = __importDefault(require("jsonwebtoken"));
const database_1 = __importDefault(require("../db/database"));
const router = (0, express_1.Router)();
const JWT_SECRET = process.env.JWT_SECRET;
if (!JWT_SECRET) {
    throw new Error('JWT_SECRET environment variable is required');
}
router.post('/register', (req, res) => {
    const { name, email, password, role } = req.body;
    if (!name || !email || !password || !role) {
        res.status(400).json({ error: 'All fields are required' });
        return;
    }
    if (!['client', 'business'].includes(role)) {
        res.status(400).json({ error: 'Role must be client or business' });
        return;
    }
    const existing = database_1.default.prepare('SELECT id FROM users WHERE email = ?').get(email);
    if (existing) {
        res.status(409).json({ error: 'Email already registered' });
        return;
    }
    const password_hash = bcryptjs_1.default.hashSync(password, 10);
    const result = database_1.default.prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)').run(name, email, password_hash, role);
    const token = jsonwebtoken_1.default.sign({ id: result.lastInsertRowid, email, role, name }, JWT_SECRET, { expiresIn: '7d' });
    res.status(201).json({ token, user: { id: result.lastInsertRowid, name, email, role } });
});
router.post('/login', (req, res) => {
    const { email, password } = req.body;
    if (!email || !password) {
        res.status(400).json({ error: 'Email and password required' });
        return;
    }
    const user = database_1.default.prepare('SELECT * FROM users WHERE email = ?').get(email);
    if (!user || !bcryptjs_1.default.compareSync(password, user.password_hash)) {
        res.status(401).json({ error: 'Invalid credentials' });
        return;
    }
    const token = jsonwebtoken_1.default.sign({ id: user.id, email: user.email, role: user.role, name: user.name }, JWT_SECRET, { expiresIn: '7d' });
    res.json({ token, user: { id: user.id, name: user.name, email: user.email, role: user.role } });
});
exports.default = router;
