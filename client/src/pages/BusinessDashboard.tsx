import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import toast from 'react-hot-toast';
import api from '../api/axios';
import { Business, Service, Booking } from '../types';
import { useAuth } from '../context/AuthContext';
import BookingCard from '../components/BookingCard';
import './Dashboard.css';

const BusinessDashboard: React.FC = () => {
  const { user } = useAuth();
  const navigate = useNavigate();
  const [business, setBusiness] = useState<Business | null>(null);
  const [bookings, setBookings] = useState<Booking[]>([]);
  const [loading, setLoading] = useState(true);
  const [showServiceForm, setShowServiceForm] = useState(false);
  const [editService, setEditService] = useState<Service | null>(null);
  const [serviceForm, setServiceForm] = useState({ name: '', description: '', duration_minutes: 30, price: 0 });
  const [tab, setTab] = useState<'bookings' | 'services' | 'profile'>('bookings');

  useEffect(() => {
    if (!user) { navigate('/login'); return; }
    if (user.role !== 'business') { navigate('/dashboard/client'); return; }
    fetchData();
  }, [user]);

  const fetchData = async () => {
    try {
      const [bizRes, bookRes] = await Promise.all([
        api.get('/businesses').then(r => r.data.find((b: Business) => b.owner_id === user!.id)),
        api.get('/bookings/business')
      ]);
      setBusiness(bizRes || null);
      setBookings(bookRes.data);
    } catch {
      toast.error('Failed to load data');
    } finally {
      setLoading(false);
    }
  };

  const handleConfirm = async (id: number) => {
    await api.patch(`/bookings/${id}`, { status: 'confirmed' });
    toast.success('Booking confirmed');
    fetchData();
  };

  const handleCancel = async (id: number) => {
    await api.patch(`/bookings/${id}`, { status: 'cancelled' });
    toast.success('Booking cancelled');
    fetchData();
  };

  const handleServiceSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      if (editService) {
        await api.put(`/businesses/${business!.id}/services/${editService.id}`, serviceForm);
        toast.success('Service updated');
      } else {
        await api.post(`/businesses/${business!.id}/services`, serviceForm);
        toast.success('Service added');
      }
      setShowServiceForm(false);
      setEditService(null);
      setServiceForm({ name: '', description: '', duration_minutes: 30, price: 0 });
      fetchData();
    } catch (err: any) {
      toast.error(err.response?.data?.error || 'Failed to save service');
    }
  };

  const handleDeleteService = async (serviceId: number) => {
    if (!confirm('Delete this service?')) return;
    await api.delete(`/businesses/${business!.id}/services/${serviceId}`);
    toast.success('Service deleted');
    fetchData();
  };

  const startEditService = (s: Service) => {
    setEditService(s);
    setServiceForm({ name: s.name, description: s.description || '', duration_minutes: s.duration_minutes, price: s.price });
    setShowServiceForm(true);
  };

  if (loading) return <div className="loading">Loading...</div>;

  if (!business) {
    return (
      <div className="container py-8">
        <div className="empty-state">
          <p>You haven't set up your business profile yet.</p>
          <button className="btn btn-primary" onClick={() => navigate('/setup-business')}>Setup Business</button>
        </div>
      </div>
    );
  }

  const todayStr = new Date().toISOString().split('T')[0];
  const upcoming = bookings.filter(b => b.appointment_date >= todayStr && b.status !== 'cancelled');
  const past = bookings.filter(b => b.appointment_date < todayStr || b.status === 'cancelled');

  return (
    <div className="container py-8">
      <div className="flex-between mb-6">
        <h1 className="page-title" style={{marginBottom:0}}>{business.name}</h1>
        <div className="tab-buttons">
          {(['bookings', 'services', 'profile'] as const).map(t => (
            <button key={t} className={`tab-btn ${tab === t ? 'active' : ''}`} onClick={() => setTab(t)}>
              {t.charAt(0).toUpperCase() + t.slice(1)}
            </button>
          ))}
        </div>
      </div>

      {tab === 'bookings' && (
        <div>
          <section className="mb-6">
            <h2 className="section-heading">Upcoming Bookings</h2>
            {upcoming.length === 0 ? (
              <div className="empty-state"><p>No upcoming bookings.</p></div>
            ) : (
              <div className="grid-2">
                {upcoming.map(b => <BookingCard key={b.id} booking={b} onConfirm={handleConfirm} onCancel={handleCancel} showClient />)}
              </div>
            )}
          </section>
          <section>
            <h2 className="section-heading">Past & Cancelled</h2>
            {past.length === 0 ? (
              <div className="empty-state"><p>No past bookings.</p></div>
            ) : (
              <div className="grid-2">
                {past.map(b => <BookingCard key={b.id} booking={b} showClient />)}
              </div>
            )}
          </section>
        </div>
      )}

      {tab === 'services' && (
        <div>
          <div className="flex-between mb-4">
            <h2 className="section-heading" style={{marginBottom:0}}>Services</h2>
            <button className="btn btn-primary" onClick={() => { setEditService(null); setServiceForm({ name: '', description: '', duration_minutes: 30, price: 0 }); setShowServiceForm(true); }}>+ Add Service</button>
          </div>
          {showServiceForm && (
            <div className="card service-form-card">
              <h3>{editService ? 'Edit Service' : 'New Service'}</h3>
              <form onSubmit={handleServiceSubmit}>
                <div className="form-group">
                  <label>Name</label>
                  <input required value={serviceForm.name} onChange={e => setServiceForm({...serviceForm, name: e.target.value})} />
                </div>
                <div className="form-group">
                  <label>Description</label>
                  <textarea rows={2} value={serviceForm.description} onChange={e => setServiceForm({...serviceForm, description: e.target.value})} />
                </div>
                <div className="form-row">
                  <div className="form-group">
                    <label>Duration (minutes)</label>
                    <input type="number" min={15} required value={serviceForm.duration_minutes} onChange={e => setServiceForm({...serviceForm, duration_minutes: parseInt(e.target.value)})} />
                  </div>
                  <div className="form-group">
                    <label>Price ($)</label>
                    <input type="number" min={0} step={0.01} required value={serviceForm.price} onChange={e => setServiceForm({...serviceForm, price: parseFloat(e.target.value)})} />
                  </div>
                </div>
                <div className="form-actions">
                  <button type="submit" className="btn btn-primary">Save</button>
                  <button type="button" className="btn btn-outline" onClick={() => setShowServiceForm(false)}>Cancel</button>
                </div>
              </form>
            </div>
          )}
          {business.services && business.services.length > 0 ? (
            <div className="grid-3">
              {business.services.map(s => (
                <div key={s.id} className="service-card card">
                  <div className="flex-between">
                    <h4>{s.name}</h4>
                    <div style={{display:'flex',gap:'0.5rem'}}>
                      <button className="btn btn-outline" style={{padding:'0.25rem 0.5rem',fontSize:'0.8rem'}} onClick={() => startEditService(s)}>Edit</button>
                      <button className="btn btn-danger" style={{padding:'0.25rem 0.5rem',fontSize:'0.8rem'}} onClick={() => handleDeleteService(s.id)}>Delete</button>
                    </div>
                  </div>
                  {s.description && <p className="text-muted" style={{fontSize:'0.875rem'}}>{s.description}</p>}
                  <div style={{display:'flex',justifyContent:'space-between',fontSize:'0.875rem',color:'var(--text-muted)'}}>
                    <span>⏱ {s.duration_minutes} min</span>
                    <span style={{fontWeight:700,color:'var(--primary)'}}>${s.price.toFixed(2)}</span>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <div className="empty-state"><p>No services yet. Add your first service!</p></div>
          )}
        </div>
      )}

      {tab === 'profile' && (
        <div className="card" style={{padding:'1.5rem', maxWidth:'600px'}}>
          <h2 className="section-heading">Business Profile</h2>
          <div style={{display:'flex',flexDirection:'column',gap:'0.75rem'}}>
            <div><strong>Category:</strong> {business.category}</div>
            {business.description && <div><strong>Description:</strong> {business.description}</div>}
            {business.address && <div><strong>Address:</strong> {business.address}</div>}
            {business.phone && <div><strong>Phone:</strong> {business.phone}</div>}
          </div>
          <button className="btn btn-outline" style={{marginTop:'1rem'}} onClick={() => navigate('/setup-business')}>Edit Profile</button>
        </div>
      )}
    </div>
  );
};

export default BusinessDashboard;
