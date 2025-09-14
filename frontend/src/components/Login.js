import React, { useState, useEffect } from 'react';
import { useAuth } from '../App';

const Login = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const [darkMode, setDarkMode] = useState(false);
  const { login } = useAuth();

  useEffect(() => {
    const savedDarkMode = localStorage.getItem('darkMode') === 'true';
    setDarkMode(savedDarkMode);
    if (savedDarkMode) {
      document.documentElement.classList.add('dark');
    }
  }, []);

  const toggleDarkMode = () => {
    const newDarkMode = !darkMode;
    setDarkMode(newDarkMode);
    localStorage.setItem('darkMode', newDarkMode.toString());
    if (newDarkMode) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    const result = await login(email, password);
    
    if (!result.success) {
      setError(result.error);
    }
    
    setLoading(false);
  };

  return (
    <div className={`min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 ${darkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
      <div className="max-w-md w-full space-y-8">
        <div className="flex justify-end mb-4">
          <button
            onClick={toggleDarkMode}
            className={`p-2 rounded-lg transition-colors ${
              darkMode 
                ? 'bg-gray-800 text-yellow-400 hover:bg-gray-700' 
                : 'bg-gray-200 text-gray-800 hover:bg-gray-300'
            }`}
            title={darkMode ? 'Açık moda geç' : 'Koyu moda geç'}
          >
            {darkMode ? '☀️' : '🌙'}
          </button>
        </div>
        <div>
          <h2 className={`mt-6 text-center text-3xl font-bold ${darkMode ? 'text-white' : 'text-gray-900'}`}>
            Transport Offerte System
          </h2>
          <p className={`mt-2 text-center text-sm ${darkMode ? 'text-gray-300' : 'text-gray-600'}`}>
            Anmelden um fortzufahren
          </p>
        </div>
        <form className="mt-8 space-y-6" onSubmit={handleSubmit}>
          <div className={`card ${darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white'}`}>
            <div className="card-body">
              {error && (
                <div className={`mb-4 p-3 rounded-md ${
                  darkMode 
                    ? 'bg-red-900 border border-red-700 text-red-300' 
                    : 'bg-red-50 border border-red-200 text-red-700'
                }`}>
                  {error}
                </div>
              )}
              
              <div className="form-group">
                <label className={`form-label ${darkMode ? 'text-gray-200' : ''}`}>E-Mail</label>
                <input
                  type="email"
                  className={`form-input ${
                    darkMode 
                      ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' 
                      : ''
                  }`}
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  required
                  placeholder="ihre@email.com"
                />
              </div>
              
              <div className="form-group">
                <label className={`form-label ${darkMode ? 'text-gray-200' : ''}`}>Passwort</label>
                <input
                  type="password"
                  className={`form-input ${
                    darkMode 
                      ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' 
                      : ''
                  }`}
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  required
                  placeholder="Ihr Passwort"
                />
              </div>
              
              <button
                type="submit"
                className="btn btn-primary w-full"
                disabled={loading}
              >
                {loading ? 'Wird angemeldet...' : 'Anmelden'}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  );
};

export default Login;
