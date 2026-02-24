import React from 'react';
import { useNavigate } from 'react-router-dom';
import { Service } from '../types';
import './ServiceCard.css';

interface Props {
  service: Service;
  businessId: number;
  canBook?: boolean;
}

const ServiceCard: React.FC<Props> = ({ service, businessId, canBook = true }) => {
  const navigate = useNavigate();
  return (
    <div className="service-card card">
      <h4 className="service-name">{service.name}</h4>
      {service.description && <p className="service-desc">{service.description}</p>}
      <div className="service-meta">
        <span>⏱ {service.duration_minutes} min</span>
        <span className="service-price">${service.price.toFixed(2)}</span>
      </div>
      {canBook && (
        <button
          className="btn btn-primary"
          onClick={() => navigate(`/book/${businessId}/${service.id}`)}
        >
          Book Now
        </button>
      )}
    </div>
  );
};

export default ServiceCard;
