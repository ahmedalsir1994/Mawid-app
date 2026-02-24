import React, { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const Dashboard: React.FC = () => {
  const { user } = useAuth();
  const navigate = useNavigate();

  useEffect(() => {
    if (!user) {
      navigate('/login');
    } else if (user.role === 'business') {
      navigate('/dashboard/business');
    } else {
      navigate('/dashboard/client');
    }
  }, [user, navigate]);

  return <div className="loading">Redirecting...</div>;
};

export default Dashboard;
