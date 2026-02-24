import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import toast from 'react-hot-toast';
import api from '../api/axios';
import { Business, Service } from '../types';
import './BookAppointment.css';

const BookAppointment: React.FC = () => {
  const { businessId, serviceId } = useParams<{ businessId: string; serviceId: string }>();
  const navigate = useNavigate();
  const [business, setBusiness] = useState<Business | null>(null);
  const [service, setService] = useState<Service | null>(null);
  const [date, setDate] = useState('');
  const [slots, setSlots] = useState<string[]>([]);
  const [selectedSlot, setSelectedSlot] = useState('');
  const [notes, setNotes] = useState('');
  const [loading, setLoading] = useState(false);
  const [slotsLoading, setSlotsLoading] = useState(false);

  const today = new Date().toISOString().split('T')[0];

  useEffect(() => {
    api.get(`/businesses/${businessId}`).then(res => {
      setBusiness(res.data);
      const svc = res.data.services?.find((s: Service) => s.id === parseInt(serviceId!));
      setService(svc || null);
    });
  }, [businessId, serviceId]);

  useEffect(() => {
    if (!date) return;
    setSlotsLoading(true);
    setSelectedSlot('');
    api.get(`/businesses/${businessId}/availability`, { params: { date, serviceId } })
      .then(res => setSlots(res.data.slots))
      .catch(() => setSlots([]))
      .finally(() => setSlotsLoading(false));
  }, [date, businessId, serviceId]);

  const handleBook = async () => {
    if (!selectedSlot) {
      toast.error('Please select a time slot');
      return;
    }
    setLoading(true);
    try {
      await api.post('/bookings', {
        service_id: parseInt(serviceId!),
        business_id: parseInt(businessId!),
        appointment_date: date,
        appointment_time: selectedSlot,
        notes: notes || undefined,
      });
      toast.success('Booking confirmed!');
      navigate('/dashboard/client');
    } catch (err: any) {
      toast.error(err.response?.data?.error || 'Booking failed');
    } finally {
      setLoading(false);
    }
  };

  if (!business || !service) return <div className="loading">Loading...</div>;

  return (
    <div className="container py-8">
      <div className="book-header card">
        <h1>Book Appointment</h1>
        <p className="text-muted">{business.name} &bull; {service.name}</p>
        <div className="service-details">
          <span>⏱ {service.duration_minutes} min</span>
          <span>💵 ${service.price.toFixed(2)}</span>
        </div>
      </div>

      <div className="book-form card">
        <div className="form-group">
          <label>Select Date</label>
          <input type="date" min={today} value={date} onChange={e => setDate(e.target.value)} />
        </div>

        {date && (
          <div className="slots-section">
            <label>Select Time Slot</label>
            {slotsLoading ? (
              <p className="text-muted">Loading slots...</p>
            ) : slots.length === 0 ? (
              <p className="text-muted">No available slots for this date.</p>
            ) : (
              <div className="slots-grid">
                {slots.map(slot => (
                  <button
                    key={slot}
                    className={`slot-btn ${selectedSlot === slot ? 'selected' : ''}`}
                    onClick={() => setSelectedSlot(slot)}
                  >
                    {slot}
                  </button>
                ))}
              </div>
            )}
          </div>
        )}

        <div className="form-group mt-4">
          <label>Notes (optional)</label>
          <textarea rows={3} value={notes} onChange={e => setNotes(e.target.value)} placeholder="Any special requests..." />
        </div>

        <button className="btn btn-primary book-btn" onClick={handleBook} disabled={loading || !selectedSlot}>
          {loading ? 'Booking...' : 'Confirm Booking'}
        </button>
      </div>
    </div>
  );
};

export default BookAppointment;
