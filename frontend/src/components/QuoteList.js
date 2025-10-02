import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import { useAuth } from '../App';

const BACKEND_URL = process.env.REACT_APP_BACKEND_URL;
const API = `${BACKEND_URL}/api`;

const QuoteList = () => {
  const { user, logout } = useAuth();
  const [quotes, setQuotes] = useState([]);
  const [loading, setLoading] = useState(true);
  const [systemTitle, setSystemTitle] = useState('Transport Offerte System');

  useEffect(() => {
    fetchQuotes();
    fetchSystemSettings();
  }, []);

  const fetchSystemSettings = async () => {
    try {
      const response = await axios.get(`${API}/system-settings`);
      setSystemTitle(response.data.title);
    } catch (error) {
      console.error('Error fetching system settings:', error);
    }
  };

  const fetchQuotes = async () => {
    try {
      const response = await axios.get(`${API}/quotes`);
      setQuotes(response.data);
    } catch (error) {
      console.error('Error fetching quotes:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleDeleteQuote = async (quoteId) => {
    if (window.confirm('Sind Sie sicher, dass Sie diese Offerte löschen möchten?')) {
      try {
        await axios.delete(`${API}/quotes/${quoteId}`);
        fetchQuotes();
      } catch (error) {
        alert('Fehler beim Löschen der Offerte');
      }
    }
  };

  return (
    <div>
      <div className="header">
        <div className="container">
          <div className="header-content">
            <div className="logo">{systemTitle}</div>
            <div className="user-menu">
              <span className="text-gray-600">Willkommen, {user?.name}</span>
              <button onClick={logout} className="btn btn-secondary">
                Abmelden
              </button>
            </div>
          </div>
        </div>
      </div>

      <div className="container">
        <nav className="nav">
          <Link to="/dashboard" className="nav-link">Dashboard</Link>
          <Link to="/create-quote" className="nav-link">Neue Offerte</Link>
          <Link to="/quotes" className="nav-link active">Offerten</Link>
          {user?.role === 'admin' && <Link to="/admin" className="nav-link">Admin Panel</Link>}
        </nav>

        <div className="mb-6">
          <div className="flex justify-between items-center">
            <h1 className="text-2xl font-bold text-gray-900">
              Alle Offerten
            </h1>
            <Link to="/create-quote" className="btn btn-primary">
              Neue Offerte erstellen
            </Link>
          </div>
        </div>

        <div className="card">
          <div className="card-body">
            {loading ? (
              <div className="text-center py-8">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-red-600 mx-auto"></div>
                <p className="mt-4 text-gray-600">Lädt Offerten...</p>
              </div>
            ) : quotes.length === 0 ? (
              <div className="text-center py-8">
                <p className="text-gray-600 mb-4">Noch keine Offerten erstellt.</p>
                <Link to="/create-quote" className="btn btn-primary">
                  Erste Offerte erstellen
                </Link>
              </div>
            ) : (
              <div className="overflow-x-auto">
                <table className="table">
                  <thead>
                    <tr>
                      <th>Offerte Nr.</th>
                      <th>Datum</th>
                      <th>Kunde</th>
                      <th>Route</th>
                      <th>Gesamtsumme</th>
                      <th>Status</th>
                      <th>Aktionen</th>
                    </tr>
                  </thead>
                  <tbody>
                    {quotes.map((quote) => (
                      <tr key={quote.id}>
                        <td className="font-medium text-red-600">
                          {quote.quote_number}
                        </td>
                        <td>{quote.date}</td>
                        <td>
                          <div>
                            <div className="font-medium">
                              {quote.customer.company_name}
                            </div>
                            <div className="text-sm text-gray-600">
                              {quote.customer.postal_code}
                            </div>
                          </div>
                        </td>
                        <td>
                          <div className="text-sm">
                            <div>
                              <strong>Von:</strong> {quote.transport_details.pickup_location}
                            </div>
                            <div>
                              <strong>Nach:</strong> {quote.transport_details.delivery_location}
                            </div>
                          </div>
                        </td>
                        <td className="font-bold text-green-600">
                          CHF {quote.grand_total.toFixed(2)}
                        </td>
                        <td>
                          <span className="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Entwurf
                          </span>
                        </td>
                        <td>
                          <div className="flex gap-2">
                            <Link
                              to={`/quote/${quote.id}`}
                              className="btn btn-outline"
                              style={{fontSize: '0.75rem', padding: '0.25rem 0.5rem'}}
                            >
                              PDF Ansicht
                            </Link>
                            <button
                              onClick={() => handleDeleteQuote(quote.id)}
                              className="btn btn-danger"
                              style={{fontSize: '0.75rem', padding: '0.25rem 0.5rem'}}
                            >
                              Löschen
                            </button>
                          </div>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            )}
          </div>
        </div>

        {/* Summary Cards */}
        {quotes.length > 0 && (
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div className="card">
              <div className="card-body">
                <h3 className="text-lg font-semibold text-gray-900 mb-2">
                  Gesamte Offerten
                </h3>
                <p className="text-3xl font-bold text-blue-600">
                  {quotes.length}
                </p>
              </div>
            </div>
            
            <div className="card">
              <div className="card-body">
                <h3 className="text-lg font-semibold text-gray-900 mb-2">
                  Gesamtwert
                </h3>
                <p className="text-3xl font-bold text-green-600">
                  CHF {quotes.reduce((sum, quote) => sum + quote.grand_total, 0).toFixed(2)}
                </p>
              </div>
            </div>
            
            <div className="card">
              <div className="card-body">
                <h3 className="text-lg font-semibold text-gray-900 mb-2">
                  Durchschnittswert
                </h3>
                <p className="text-3xl font-bold text-purple-600">
                  CHF {(quotes.reduce((sum, quote) => sum + quote.grand_total, 0) / quotes.length).toFixed(2)}
                </p>
              </div>
            </div>
          </div>
        )}
      </div>
    </div>
  );
};

export default QuoteList;
