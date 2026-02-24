import React from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';
import { Toaster } from 'react-hot-toast';
import { useAuth } from './context/AuthContext';
import Navbar from './components/Navbar';
import Home from './pages/Home';
import Login from './pages/Login';
import Register from './pages/Register';
import BusinessProfile from './pages/BusinessProfile';
import BookAppointment from './pages/BookAppointment';
import Dashboard from './pages/Dashboard';
import ClientDashboard from './pages/ClientDashboard';
import BusinessDashboard from './pages/BusinessDashboard';
import SetupBusiness from './pages/SetupBusiness';

const ProtectedRoute: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const { isAuthenticated, loading } = useAuth();
  if (loading) return null;
  return isAuthenticated ? <>{children}</> : <Navigate to="/login" replace />;
};

const App: React.FC = () => {
  return (
    <>
      <Navbar />
      <main style={{ flex: 1 }}>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/business/:id" element={<BusinessProfile />} />
          <Route path="/book/:businessId/:serviceId" element={<ProtectedRoute><BookAppointment /></ProtectedRoute>} />
          <Route path="/dashboard" element={<ProtectedRoute><Dashboard /></ProtectedRoute>} />
          <Route path="/dashboard/client" element={<ProtectedRoute><ClientDashboard /></ProtectedRoute>} />
          <Route path="/dashboard/business" element={<ProtectedRoute><BusinessDashboard /></ProtectedRoute>} />
          <Route path="/setup-business" element={<ProtectedRoute><SetupBusiness /></ProtectedRoute>} />
        </Routes>
      </main>
      <Toaster position="top-right" />
    </>
  );
};

export default App;
