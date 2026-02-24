import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import toast from 'react-hot-toast';
import api from '../api/axios';
import { useAuth } from '../context/AuthContext';
import { Business } from '../types';
import './AuthForm.css';

const CATEGORIES = ['healthcare', 'beauty', 'fitness', 'education', 'legal', 'finance', 'tech', 'other'];

const SetupBusiness: React.FC = () => {
  const { user } = useAuth();
  const navigate = useNavigate();
  const [existing, setExisting] = useState<Business | null>(null);
  const [form, setForm] = useState({ name: '', description: '', category: 'other', address: '', phone: '' });
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    if (!user || user.role !== 'business') { navigate('/'); return; }
    api.get('/businesses').then(res => {
      const biz = res.data.find((b: Business) => b.owner_id === user.id);
      if (biz) {
        setExisting(biz);
        setForm({ name: biz.name, description: biz.description || '', category: biz.category, address: biz.address || '', phone: biz.phone || '' });
      }
    });
  }, [user]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    try {
      if (existing) {
        await api.put(`/businesses/${existing.id}`, form);
        toast.success('Business profile updated!');
      } else {
        await api.post('/businesses', form);
        toast.success('Business profile created!');
      }
      navigate('/dashboard/business');
    } catch (err: any) {
      toast.error(err.response?.data?.error || 'Failed to save');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="auth-page">
      <div className="auth-card card" style={{maxWidth:'520px'}}>
        <h2 className="auth-title">{existing ? 'Edit Business' : 'Setup Business'}</h2>
        <p className="auth-subtitle">Tell clients about your business</p>
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label>Business Name</label>
            <input required value={form.name} onChange={e => setForm({...form, name: e.target.value})} placeholder="My Business" />
          </div>
          <div className="form-group">
            <label>Category</label>
            <select value={form.category} onChange={e => setForm({...form, category: e.target.value})}>
              {CATEGORIES.map(c => <option key={c} value={c}>{c.charAt(0).toUpperCase() + c.slice(1)}</option>)}
            </select>
          </div>
          <div className="form-group">
            <label>Description</label>
            <textarea rows={3} value={form.description} onChange={e => setForm({...form, description: e.target.value})} placeholder="Describe your business..." />
          </div>
          <div className="form-group">
            <label>Address</label>
            <input value={form.address} onChange={e => setForm({...form, address: e.target.value})} placeholder="123 Main St" />
          </div>
          <div className="form-group">
            <label>Phone</label>
            <input value={form.phone} onChange={e => setForm({...form, phone: e.target.value})} placeholder="+1 555 0000" />
          </div>
          <button type="submit" className="btn btn-primary auth-btn" disabled={loading}>
            {loading ? 'Saving...' : (existing ? 'Update' : 'Create Business')}
          </button>
        </form>
      </div>
    </div>
  );
};

export default SetupBusiness;
