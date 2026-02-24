export interface User {
  id: number;
  name: string;
  email: string;
  role: 'client' | 'business';
}

export interface Business {
  id: number;
  owner_id: number;
  name: string;
  description: string | null;
  category: string;
  address: string | null;
  phone: string | null;
  created_at: string;
  services?: Service[];
}

export interface Service {
  id: number;
  business_id: number;
  name: string;
  description: string | null;
  duration_minutes: number;
  price: number;
  created_at: string;
}

export interface Booking {
  id: number;
  client_id: number;
  service_id: number;
  business_id: number;
  appointment_date: string;
  appointment_time: string;
  status: 'pending' | 'confirmed' | 'cancelled';
  notes: string | null;
  created_at: string;
  service_name?: string;
  duration_minutes?: number;
  price?: number;
  business_name?: string;
  client_name?: string;
  client_email?: string;
}
