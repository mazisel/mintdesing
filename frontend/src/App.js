import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import axios from 'axios';
import './App.css';

// Components
import Login from './components/Login';
import Dashboard from './components/Dashboard';
import AdminPanel from './components/AdminPanel';
import QuoteCreator from './components/QuoteCreator';
import QuoteList from './components/QuoteList';
import QuotePDF from './components/QuotePDF';

const BACKEND_URL = process.env.REACT_APP_BACKEND_URL;
const API = `${BACKEND_URL}/api`;

// Auth context
const AuthContext = React.createContext();

export const useAuth = () => {
  const context = React.useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
};

function App() {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem('token');
    if (token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      // Verify token validity by making a request
      axios.get(`${API}/users`)
        .then(() => {
          const userData = JSON.parse(localStorage.getItem('user') || '{}');
          setUser(userData);
        })
        .catch(() => {
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          delete axios.defaults.headers.common['Authorization'];
        })
        .finally(() => setLoading(false));
    } else {
      setLoading(false);
    }
  }, []);

  const login = async (email, password) => {
    try {
      const response = await axios.post(`${API}/auth/login`, { email, password });
      const { user, token } = response.data;
      
      localStorage.setItem('token', token);
      localStorage.setItem('user', JSON.stringify(user));
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      setUser(user);
      
      return { success: true };
    } catch (error) {
      return { 
        success: false, 
        error: error.response?.data?.detail || 'Login failed' 
      };
    }
  };

  const logout = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    delete axios.defaults.headers.common['Authorization'];
    setUser(null);
  };

  const authValue = {
    user,
    login,
    logout,
    isAuthenticated: !!user,
    isAdmin: user?.role === 'admin'
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-red-600"></div>
      </div>
    );
  }

  return (
    <AuthContext.Provider value={authValue}>
      <Router>
        <div className="App min-h-screen bg-gray-50">
          <Routes>
            <Route path="/login" element={
              !authValue.isAuthenticated ? <Login /> : <Navigate to="/dashboard" />
            } />
            <Route path="/dashboard" element={
              authValue.isAuthenticated ? <Dashboard /> : <Navigate to="/login" />
            } />
            <Route path="/admin" element={
              authValue.isAuthenticated && authValue.isAdmin ? <AdminPanel /> : <Navigate to="/dashboard" />
            } />
            <Route path="/create-quote" element={
              authValue.isAuthenticated ? <QuoteCreator /> : <Navigate to="/login" />
            } />
            <Route path="/quotes" element={
              authValue.isAuthenticated ? <QuoteList /> : <Navigate to="/login" />
            } />
            <Route path="/quote/:id" element={
              authValue.isAuthenticated ? <QuotePDF /> : <Navigate to="/login" />
            } />
            <Route path="/" element={<Navigate to="/dashboard" />} />
          </Routes>
        </div>
      </Router>
    </AuthContext.Provider>
  );
}

export default App;