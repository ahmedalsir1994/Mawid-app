import React from 'react';
import { Link } from 'react-router-dom';
import { Business } from '../types';
import './BusinessCard.css';

interface Props {
  business: Business;
}

const categoryEmoji: Record<string, string> = {
  healthcare: '🏥',
  beauty: '💅',
  fitness: '💪',
  education: '📚',
  legal: '⚖️',
  finance: '💰',
  tech: '💻',
  other: '🏢',
};

const BusinessCard: React.FC<Props> = ({ business }) => {
  const emoji = categoryEmoji[business.category] || '🏢';
  return (
    <div className="business-card card">
      <div className="business-card-header">
        <span className="category-emoji">{emoji}</span>
        <span className="business-category">{business.category}</span>
      </div>
      <h3 className="business-name">{business.name}</h3>
      {business.description && <p className="business-desc">{business.description}</p>}
      {business.address && <p className="business-meta">📍 {business.address}</p>}
      {business.phone && <p className="business-meta">📞 {business.phone}</p>}
      <Link to={`/business/${business.id}`} className="btn btn-primary business-card-btn">View & Book</Link>
    </div>
  );
};

export default BusinessCard;
