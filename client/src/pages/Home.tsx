import React, { useState, useEffect } from 'react';
import api from '../api/axios';
import { Business } from '../types';
import BusinessCard from '../components/BusinessCard';
import './Home.css';

const CATEGORIES = ['all', 'healthcare', 'beauty', 'fitness', 'education', 'legal', 'finance', 'tech', 'other'];

const Home: React.FC = () => {
  const [businesses, setBusinesses] = useState<Business[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [category, setCategory] = useState('all');

  useEffect(() => {
    fetchBusinesses();
  }, [category]);

  const fetchBusinesses = async () => {
    setLoading(true);
    try {
      const params: Record<string, string> = {};
      if (category !== 'all') params.category = category;
      if (search) params.search = search;
      const res = await api.get('/businesses', { params });
      setBusinesses(res.data);
    } catch {
      //
    } finally {
      setLoading(false);
    }
  };

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    fetchBusinesses();
  };

  return (
    <div className="home">
      <section className="hero">
        <div className="container">
          <h1 className="hero-title">Book Appointments with Ease</h1>
          <p className="hero-subtitle">Find and book services from local businesses in just a few clicks.</p>
          <form className="search-bar" onSubmit={handleSearch}>
            <input
              type="text"
              placeholder="Search businesses..."
              value={search}
              onChange={e => setSearch(e.target.value)}
            />
            <button type="submit" className="btn btn-primary">Search</button>
          </form>
        </div>
      </section>

      <section className="businesses-section container">
        <div className="category-filters">
          {CATEGORIES.map(cat => (
            <button
              key={cat}
              className={`category-btn ${category === cat ? 'active' : ''}`}
              onClick={() => setCategory(cat)}
            >
              {cat.charAt(0).toUpperCase() + cat.slice(1)}
            </button>
          ))}
        </div>

        {loading ? (
          <div className="loading">Loading businesses...</div>
        ) : businesses.length === 0 ? (
          <div className="empty-state">
            <p>No businesses found.</p>
          </div>
        ) : (
          <div className="grid-2">
            {businesses.map(b => <BusinessCard key={b.id} business={b} />)}
          </div>
        )}
      </section>
    </div>
  );
};

export default Home;
