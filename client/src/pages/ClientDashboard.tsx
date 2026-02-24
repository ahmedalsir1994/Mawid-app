import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import toast from 'react-hot-toast';
import api from '../api/axios';
import { Booking } from '../types';
import { useAuth } from '../context/AuthContext';
import BookingCard from '../components/BookingCard';
import './Dashboard.css';

const ClientDashboard: React.FC = () => {
  const { user } = useAuth();
  const navigate = useNavigate();
  const [bookings, setBookings] = useState<Booking[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!user) { navigate('/login'); return; }
    if (user.role !== 'client') { navigate('/dashboard/business'); return; }
    fetchBookings();
  }, [user]);

  const fetchBookings = async () => {
    try {
      const res = await api.get('/bookings/my');
      setBookings(res.data);
    } catch {
      toast.error('Failed to load bookings');
    } finally {
      setLoading(false);
    }
  };

  const handleCancel = async (id: number) => {
    try {
      await api.patch(`/bookings/${id}`, { status: 'cancelled' });
      toast.success('Booking cancelled');
      fetchBookings();
    } catch {
      toast.error('Failed to cancel booking');
    }
  };

  const todayStr = new Date().toISOString().split('T')[0];
  const upcoming = bookings.filter(b => b.appointment_date >= todayStr && b.status !== 'cancelled');
  const past = bookings.filter(b => b.appointment_date < todayStr || b.status === 'cancelled');

  if (loading) return <div className="loading">Loading...</div>;

  return (
    <div className="container py-8">
      <div className="flex-between mb-6">
        <h1 className="page-title" style={{marginBottom:0}}>My Bookings</h1>
        <button className="btn btn-primary" onClick={() => navigate('/')}>Book New</button>
      </div>

      <section className="mb-6">
        <h2 className="section-heading">Upcoming</h2>
        {upcoming.length === 0 ? (
          <div className="empty-state"><p>No upcoming bookings.</p></div>
        ) : (
          <div className="grid-2">
            {upcoming.map(b => <BookingCard key={b.id} booking={b} onCancel={handleCancel} />)}
          </div>
        )}
      </section>

      <section>
        <h2 className="section-heading">Past & Cancelled</h2>
        {past.length === 0 ? (
          <div className="empty-state"><p>No past bookings.</p></div>
        ) : (
          <div className="grid-2">
            {past.map(b => <BookingCard key={b.id} booking={b} />)}
          </div>
        )}
      </section>
    </div>
  );
};

export default ClientDashboard;
