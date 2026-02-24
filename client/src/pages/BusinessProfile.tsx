import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import api from '../api/axios';
import { Business } from '../types';
import ServiceCard from '../components/ServiceCard';
import { useAuth } from '../context/AuthContext';
import './BusinessProfile.css';

const BusinessProfile: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const { user } = useAuth();
  const [business, setBusiness] = useState<Business | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    api.get(`/businesses/${id}`)
      .then(res => setBusiness(res.data))
      .catch(() => setBusiness(null))
      .finally(() => setLoading(false));
  }, [id]);

  if (loading) return <div className="loading">Loading...</div>;
  if (!business) return <div className="empty-state"><p>Business not found.</p></div>;

  const canBook = user?.role === 'client';

  return (
    <div className="container py-8">
      <div className="business-profile-header card">
        <div>
          <h1 className="business-profile-name">{business.name}</h1>
          <span className="business-category-badge">{business.category}</span>
        </div>
        {business.description && <p className="business-profile-desc">{business.description}</p>}
        <div className="business-profile-meta">
          {business.address && <span>📍 {business.address}</span>}
          {business.phone && <span>📞 {business.phone}</span>}
        </div>
      </div>

      <h2 className="section-title">Services</h2>
      {business.services && business.services.length > 0 ? (
        <div className="grid-3">
          {business.services.map(s => (
            <ServiceCard key={s.id} service={s} businessId={business.id} canBook={canBook} />
          ))}
        </div>
      ) : (
        <div className="empty-state"><p>No services available.</p></div>
      )}
    </div>
  );
};

export default BusinessProfile;
