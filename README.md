# Mawid — Booking Web Application

**Mawid** (مواعيد) is a full-stack appointment booking platform for individuals, small and mid-sized businesses to organize and improve their client booking services.

![Home Page](https://github.com/user-attachments/assets/9fc99255-3b7c-47fc-9b9c-bf2499ead0f7)

## Features

- **Business owners** can register, create a business profile, manage services (name, duration, price), and view/confirm/cancel incoming bookings.
- **Clients** can browse businesses by category, view services, and book appointments with a date + time-slot picker.
- **Authentication** with JWT (register/login, roles: `client` and `business`).
- **Availability engine** generates 30-min (or service-duration) slots from 9 AM – 6 PM (Mon–Sat) and excludes already-booked times.

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Frontend | React 18 + TypeScript + Vite |
| Backend | Node.js + Express + TypeScript |
| Database | SQLite (better-sqlite3) |
| Auth | JWT + bcrypt |
| Styling | Plain CSS (no framework) |

## Project Structure

```
Mawid-app/
├── client/          # React frontend (Vite)
│   └── src/
│       ├── components/   # Navbar, BusinessCard, ServiceCard, BookingCard
│       ├── context/      # AuthContext (JWT + localStorage)
│       ├── pages/        # Home, Login, Register, BusinessProfile,
│       │                 # BookAppointment, Dashboard, ClientDashboard,
│       │                 # BusinessDashboard, SetupBusiness
│       └── styles/       # globals.css
├── server/          # Express REST API
│   └── src/
│       ├── db/           # SQLite schema + db instance
│       ├── middleware/   # JWT auth middleware
│       └── routes/       # auth, businesses, bookings
└── package.json     # Root scripts
```

## Quick Start

### Prerequisites
- Node.js 18+

### Install dependencies

```bash
npm run install:all
```

### Configure environment

```bash
cp server/.env.example server/.env
# Edit server/.env and set a strong JWT_SECRET
```

### Run in development

```bash
# Terminal 1 — backend (port 3001)
npm run dev:server

# Terminal 2 — frontend (port 5173)
npm run dev:client
```

### Build for production

```bash
npm run build
```

## API Reference

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| POST | `/api/auth/register` | — | Register (role: client/business) |
| POST | `/api/auth/login` | — | Login, returns JWT |
| GET | `/api/businesses` | — | List businesses (filter: `?category=`) |
| GET | `/api/businesses/:id` | — | Business + services |
| POST | `/api/businesses` | business | Create business |
| PUT | `/api/businesses/:id` | owner | Update business |
| POST | `/api/businesses/:id/services` | owner | Add service |
| PUT | `/api/businesses/:id/services/:sId` | owner | Update service |
| DELETE | `/api/businesses/:id/services/:sId` | owner | Delete service |
| GET | `/api/businesses/:id/availability` | — | Available slots (`?date=YYYY-MM-DD&serviceId=X`) |
| POST | `/api/bookings` | client | Create booking |
| GET | `/api/bookings/my` | client | My bookings |
| GET | `/api/bookings/business` | business | Incoming bookings |
| PATCH | `/api/bookings/:id` | auth | Update booking status |

## Security

- Passwords hashed with **bcrypt** (cost factor 10)
- JWT secret loaded from **environment variable** (never hardcoded)
- All SQL queries use **parameterized prepared statements** (no injection risk)
- Date inputs validated with regex before parsing
- `.env` is gitignored; `.env.example` provided

