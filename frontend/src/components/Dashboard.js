import React from 'react';
import { Link } from 'react-router-dom';
import { useAuth } from '../App';

const Dashboard = () => {
  const { user, logout, isAdmin } = useAuth();

  return (
    <div>
      <div className="header">
        <div className="container">
          <div className="header-content">
            <div className="logo">Transport Offerte System</div>
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
          <Link to="/dashboard" className="nav-link active">Dashboard</Link>
          <Link to="/create-quote" className="nav-link">Neue Offerte</Link>
          <Link to="/quotes" className="nav-link">Offerten</Link>
          {isAdmin && <Link to="/admin" className="nav-link">Admin Panel</Link>}
        </nav>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div className="card">
            <div className="card-body">
              <h3 className="card-title">Neue Offerte erstellen</h3>
              <p className="text-gray-600 mb-4">
                Erstellen Sie eine neue Transport-Offerte für Ihre Kunden
              </p>
              <Link to="/create-quote" className="btn btn-primary">
                Offerte erstellen
              </Link>
            </div>
          </div>

          <div className="card">
            <div className="card-body">
              <h3 className="card-title">Offerten verwalten</h3>
              <p className="text-gray-600 mb-4">
                Sehen Sie alle erstellten Offerten und exportieren Sie PDF
              </p>
              <Link to="/quotes" className="btn btn-outline">
                Alle Offerten
              </Link>
            </div>
          </div>

          {isAdmin && (
            <div className="card">
              <div className="card-body">
                <h3 className="card-title">Team verwalten</h3>
                <p className="text-gray-600 mb-4">
                  Verwalten Sie Benutzer und Unternehmenseinstellungen
                </p>
                <Link to="/admin" className="btn btn-secondary">
                  Admin Panel
                </Link>
              </div>
            </div>
          )}
        </div>

        <div className="mt-8">
          <div className="card">
            <div className="card-header">
              <h3 className="card-title">Schnellaktionen</h3>
            </div>
            <div className="card-body">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="p-4 bg-gray-50 rounded-lg">
                  <h4 className="font-semibold mb-2">Letzte Offerten</h4>
                  <p className="text-sm text-gray-600">
                    Zugriff auf die zuletzt erstellten Offerten
                  </p>
                  <Link to="/quotes" className="text-red-600 text-sm font-medium hover:underline">
                    Alle anzeigen →
                  </Link>
                </div>
                <div className="p-4 bg-gray-50 rounded-lg">
                  <h4 className="font-semibold mb-2">Vorlagen</h4>
                  <p className="text-sm text-gray-600">
                    Verwenden Sie Vorlagen für häufige Transport-Services
                  </p>
                  <Link to="/create-quote" className="text-red-600 text-sm font-medium hover:underline">
                    Erstellen →
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;