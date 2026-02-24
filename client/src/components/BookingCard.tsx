import React from 'react';
import { Booking } from '../types';
import './BookingCard.css';

interface Props {
  booking: Booking;
  onCancel?: (id: number) => void;
  onConfirm?: (id: number) => void;
  showClient?: boolean;
}

const BookingCard: React.FC<Props> = ({ booking, onCancel, onConfirm, showClient }) => {
  const isPast = new Date(booking.appointment_date) < new Date(new Date().toDateString());

  return (
    <div className="booking-card card">
      <div className="booking-card-header flex-between">
        <div>
          <h4>{booking.service_name}</h4>
          {showClient ? (
            <p className="text-muted">{booking.client_name} &bull; {booking.client_email}</p>
          ) : (
            <p className="text-muted">{booking.business_name}</p>
          )}
        </div>
        <span className={`badge badge-${booking.status}`}>{booking.status}</span>
      </div>
      <div className="booking-details">
        <span>📅 {booking.appointment_date}</span>
        <span>🕐 {booking.appointment_time}</span>
        {booking.duration_minutes && <span>⏱ {booking.duration_minutes} min</span>}
        {booking.price !== undefined && <span>💵 ${booking.price.toFixed(2)}</span>}
      </div>
      {booking.notes && <p className="booking-notes">{booking.notes}</p>}
      <div className="booking-actions">
        {!isPast && booking.status !== 'cancelled' && onCancel && (
          <button className="btn btn-danger" onClick={() => onCancel(booking.id)}>Cancel</button>
        )}
        {booking.status === 'pending' && onConfirm && (
          <button className="btn btn-success" onClick={() => onConfirm(booking.id)}>Confirm</button>
        )}
      </div>
    </div>
  );
};

export default BookingCard;
