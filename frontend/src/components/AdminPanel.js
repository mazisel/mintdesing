import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import { useAuth } from '../App';

const BACKEND_URL = process.env.REACT_APP_BACKEND_URL;
const API = `${BACKEND_URL}/api`;

const AdminPanel = () => {
  const { user, logout } = useAuth();
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [newUser, setNewUser] = useState({
    name: '',
    email: '',
    password: '',
    role: 'member'
  });
  const [showAddUser, setShowAddUser] = useState(false);
  const [systemTitle, setSystemTitle] = useState('');
  const [editingTitle, setEditingTitle] = useState(false);
  const [newTitle, setNewTitle] = useState('');
  const [company, setCompany] = useState(null);
  const [editingCompany, setEditingCompany] = useState(false);
  const [companyForm, setCompanyForm] = useState({
    name: '',
    address: '',
    phone: '',
    email: '',
    website: '',
    logo_url: '',
    iban: '',
    bank_name: '',
    swift_bic: ''
  });

  useEffect(() => {
    fetchUsers();
    fetchSystemSettings();
    fetchCompany();
  }, []);

  const fetchSystemSettings = async () => {
    try {
      const response = await axios.get(`${API}/system-settings`);
      setSystemTitle(response.data.title);
      setNewTitle(response.data.title);
    } catch (error) {
      console.error('Error fetching system settings:', error);
    }
  };

  const handleUpdateTitle = async () => {
    try {
      await axios.put(`${API}/system-settings`, { title: newTitle });
      setSystemTitle(newTitle);
      setEditingTitle(false);
      // Sayfayı yenile
      window.location.reload();
    } catch (error) {
      alert('Fehler beim Aktualisieren des Systemtitels');
    }
  };

  const fetchUsers = async () => {
    try {
      const response = await axios.get(`${API}/users`);
      setUsers(response.data);
    } catch (error) {
      console.error('Error fetching users:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleAddUser = async (e) => {
    e.preventDefault();
    try {
      await axios.post(`${API}/auth/register`, newUser);
      setNewUser({ name: '', email: '', password: '', role: 'member' });
      setShowAddUser(false);
      fetchUsers();
    } catch (error) {
      alert('Fehler beim Hinzufügen des Benutzers: ' + error.response?.data?.detail);
    }
  };

  const handleDeleteUser = async (userId) => {
    if (window.confirm('Sind Sie sicher, dass Sie diesen Benutzer löschen möchten?')) {
      try {
        await axios.delete(`${API}/users/${userId}`);
        fetchUsers();
      } catch (error) {
        alert('Fehler beim Löschen des Benutzers');
      }
    }
  };

  const fetchCompany = async () => {
    try {
      const response = await axios.get(`${API}/company`);
      setCompany(response.data);
      setCompanyForm(response.data);
    } catch (error) {
      console.error('Error fetching company:', error);
    }
  };

  const handleUpdateCompany = async (e) => {
    e.preventDefault();
    try {
      await axios.put(`${API}/company`, companyForm);
      setCompany(companyForm);
      setEditingCompany(false);
      alert('Firmendaten erfolgreich aktualisiert');
    } catch (error) {
      alert('Fehler beim Aktualisieren der Firmendaten');
    }
  };

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
          <Link to="/dashboard" className="nav-link">Dashboard</Link>
          <Link to="/create-quote" className="nav-link">Neue Offerte</Link>
          <Link to="/quotes" className="nav-link">Offerten</Link>
          <Link to="/admin" className="nav-link active">Admin Panel</Link>
        </nav>

        <div className="mb-6">
          <h1 className="text-2xl font-bold text-gray-900 mb-4">
            Admin Panel - Benutzerverwaltung
          </h1>
        </div>

        <div className="card mb-6">
          <div className="card-header">
            <div className="flex justify-between items-center">
              <h3 className="card-title">Team Mitglieder</h3>
              <button
                onClick={() => setShowAddUser(!showAddUser)}
                className="btn btn-primary"
              >
                Neuen Benutzer hinzufügen
              </button>
            </div>
          </div>
          <div className="card-body">
            {showAddUser && (
              <form onSubmit={handleAddUser} className="mb-6 p-4 bg-gray-50 rounded-lg">
                <h4 className="font-semibold mb-4">Neuen Benutzer hinzufügen</h4>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div className="form-group">
                    <label className="form-label">Name</label>
                    <input
                      type="text"
                      className="form-input"
                      value={newUser.name}
                      onChange={(e) => setNewUser({...newUser, name: e.target.value})}
                      required
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">E-Mail</label>
                    <input
                      type="email"
                      className="form-input"
                      value={newUser.email}
                      onChange={(e) => setNewUser({...newUser, email: e.target.value})}
                      required
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">Passwort</label>
                    <input
                      type="password"
                      className="form-input"
                      value={newUser.password}
                      onChange={(e) => setNewUser({...newUser, password: e.target.value})}
                      required
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">Rolle</label>
                    <select
                      className="form-select"
                      value={newUser.role}
                      onChange={(e) => setNewUser({...newUser, role: e.target.value})}
                    >
                      <option value="member">Mitglied</option>
                      <option value="admin">Admin</option>
                    </select>
                  </div>
                </div>
                <div className="flex gap-2 mt-4">
                  <button type="submit" className="btn btn-primary">
                    Benutzer hinzufügen
                  </button>
                  <button
                    type="button"
                    onClick={() => setShowAddUser(false)}
                    className="btn btn-secondary"
                  >
                    Abbrechen
                  </button>
                </div>
              </form>
            )}

            {loading ? (
              <div className="text-center py-4">Lädt...</div>
            ) : (
              <div className="overflow-x-auto">
                <table className="table">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>E-Mail</th>
                      <th>Rolle</th>
                      <th>Erstellt am</th>
                      <th>Aktionen</th>
                    </tr>
                  </thead>
                  <tbody>
                    {users.map((userData) => (
                      <tr key={userData.id}>
                        <td className="font-medium">{userData.name}</td>
                        <td>{userData.email}</td>
                        <td>
                          <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                            userData.role === 'admin' 
                              ? 'bg-red-100 text-red-800' 
                              : 'bg-blue-100 text-blue-800'
                          }`}>
                            {userData.role === 'admin' ? 'Admin' : 'Mitglied'}
                          </span>
                        </td>
                        <td>
                          {new Date(userData.created_at).toLocaleDateString('de-DE')}
                        </td>
                        <td>
                          {userData.id !== user?.id && (
                            <button
                              onClick={() => handleDeleteUser(userData.id)}
                              className="btn btn-danger"
                              style={{fontSize: '0.75rem', padding: '0.25rem 0.5rem'}}
                            >
                              Löschen
                            </button>
                          )}
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            )}
          </div>
        </div>

        <div className="card mb-6">
          <div className="card-header">
            <h3 className="card-title">System Einstellungen</h3>
          </div>
          <div className="card-body">
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700 mb-2">
                System Titel
              </label>
              {editingTitle ? (
                <div className="flex gap-2">
                  <input
                    type="text"
                    className="form-input flex-1"
                    value={newTitle}
                    onChange={(e) => setNewTitle(e.target.value)}
                    placeholder="System Titel eingeben"
                  />
                  <button
                    onClick={handleUpdateTitle}
                    className="btn btn-primary"
                  >
                    Speichern
                  </button>
                  <button
                    onClick={() => {
                      setEditingTitle(false);
                      setNewTitle(systemTitle);
                    }}
                    className="btn btn-secondary"
                  >
                    Abbrechen
                  </button>
                </div>
              ) : (
                <div className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                  <span className="text-gray-900 font-medium">{systemTitle}</span>
                  <button
                    onClick={() => setEditingTitle(true)}
                    className="btn btn-primary"
                    style={{fontSize: '0.875rem', padding: '0.375rem 0.75rem'}}
                  >
                    Bearbeiten
                  </button>
                </div>
              )}
            </div>
          </div>
        </div>

        <div className="card mb-6">
          <div className="card-header">
            <div className="flex justify-between items-center">
              <h3 className="card-title">Firma Informationen & Bankdaten</h3>
              {!editingCompany && (
                <button
                  onClick={() => setEditingCompany(true)}
                  className="btn btn-primary"
                >
                  Bearbeiten
                </button>
              )}
            </div>
          </div>
          <div className="card-body">
            {editingCompany ? (
              <form onSubmit={handleUpdateCompany}>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div className="form-group">
                    <label className="form-label">Firmenname</label>
                    <input
                      type="text"
                      className="form-input"
                      value={companyForm.name}
                      onChange={(e) => setCompanyForm({...companyForm, name: e.target.value})}
                      required
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">Adresse</label>
                    <input
                      type="text"
                      className="form-input"
                      value={companyForm.address}
                      onChange={(e) => setCompanyForm({...companyForm, address: e.target.value})}
                      required
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">Telefon</label>
                    <input
                      type="text"
                      className="form-input"
                      value={companyForm.phone}
                      onChange={(e) => setCompanyForm({...companyForm, phone: e.target.value})}
                      required
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">E-Mail</label>
                    <input
                      type="email"
                      className="form-input"
                      value={companyForm.email}
                      onChange={(e) => setCompanyForm({...companyForm, email: e.target.value})}
                      required
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">Website</label>
                    <input
                      type="text"
                      className="form-input"
                      value={companyForm.website}
                      onChange={(e) => setCompanyForm({...companyForm, website: e.target.value})}
                      required
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">Logo URL</label>
                    <input
                      type="text"
                      className="form-input"
                      value={companyForm.logo_url}
                      onChange={(e) => setCompanyForm({...companyForm, logo_url: e.target.value})}
                    />
                  </div>
                  <div className="form-group md:col-span-2">
                    <h4 className="font-semibold text-red-600 mb-3">Bankdaten für Swiss QR Rechnung</h4>
                  </div>
                  <div className="form-group">
                    <label className="form-label">IBAN</label>
                    <input
                      type="text"
                      className="form-input"
                      value={companyForm.iban}
                      onChange={(e) => setCompanyForm({...companyForm, iban: e.target.value})}
                      placeholder="CH93 0076 2011 6238 5295 7"
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">Bank Name</label>
                    <input
                      type="text"
                      className="form-input"
                      value={companyForm.bank_name}
                      onChange={(e) => setCompanyForm({...companyForm, bank_name: e.target.value})}
                      placeholder="UBS Switzerland AG"
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">SWIFT/BIC</label>
                    <input
                      type="text"
                      className="form-input"
                      value={companyForm.swift_bic}
                      onChange={(e) => setCompanyForm({...companyForm, swift_bic: e.target.value})}
                      placeholder="UBSWCHZH80A"
                    />
                  </div>
                </div>
                <div className="flex gap-2 mt-4">
                  <button type="submit" className="btn btn-primary">
                    Speichern
                  </button>
                  <button
                    type="button"
                    onClick={() => {
                      setEditingCompany(false);
                      setCompanyForm(company);
                    }}
                    className="btn btn-secondary"
                  >
                    Abbrechen
                  </button>
                </div>
              </form>
            ) : (
              <div>
                {company && (
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div className="p-3 bg-gray-50 rounded-lg">
                      <label className="text-sm text-gray-600">Firmenname</label>
                      <p className="font-medium">{company.name}</p>
                    </div>
                    <div className="p-3 bg-gray-50 rounded-lg">
                      <label className="text-sm text-gray-600">Adresse</label>
                      <p className="font-medium">{company.address}</p>
                    </div>
                    <div className="p-3 bg-gray-50 rounded-lg">
                      <label className="text-sm text-gray-600">Telefon</label>
                      <p className="font-medium">{company.phone}</p>
                    </div>
                    <div className="p-3 bg-gray-50 rounded-lg">
                      <label className="text-sm text-gray-600">E-Mail</label>
                      <p className="font-medium">{company.email}</p>
                    </div>
                    <div className="p-3 bg-gray-50 rounded-lg">
                      <label className="text-sm text-gray-600">Website</label>
                      <p className="font-medium">{company.website}</p>
                    </div>
                    <div className="p-3 bg-gray-50 rounded-lg md:col-span-2">
                      <label className="text-sm text-gray-600">Logo URL</label>
                      <p className="font-medium text-xs break-all">{company.logo_url || 'Nicht gesetzt'}</p>
                    </div>
                    <div className="md:col-span-2">
                      <h4 className="font-semibold text-red-600 mb-3 mt-2">Bankdaten für Swiss QR Rechnung</h4>
                    </div>
                    <div className="p-3 bg-red-50 rounded-lg">
                      <label className="text-sm text-gray-600">IBAN</label>
                      <p className="font-medium">{company.iban || 'Nicht gesetzt'}</p>
                    </div>
                    <div className="p-3 bg-red-50 rounded-lg">
                      <label className="text-sm text-gray-600">Bank Name</label>
                      <p className="font-medium">{company.bank_name || 'Nicht gesetzt'}</p>
                    </div>
                    <div className="p-3 bg-red-50 rounded-lg">
                      <label className="text-sm text-gray-600">SWIFT/BIC</label>
                      <p className="font-medium">{company.swift_bic || 'Nicht gesetzt'}</p>
                    </div>
                  </div>
                )}
              </div>
            )}
          </div>
        </div>

        <div className="card">
          <div className="card-header">
            <h3 className="card-title">System Informationen</h3>
          </div>
          <div className="card-body">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div className="p-4 bg-blue-50 rounded-lg">
                <h4 className="font-semibold text-blue-900">Aktive Benutzer</h4>
                <p className="text-2xl font-bold text-blue-600">{users.length}</p>
              </div>
              <div className="p-4 bg-green-50 rounded-lg">
                <h4 className="font-semibold text-green-900">Admins</h4>
                <p className="text-2xl font-bold text-green-600">
                  {users.filter(u => u.role === 'admin').length}
                </p>
              </div>
              <div className="p-4 bg-purple-50 rounded-lg">
                <h4 className="font-semibold text-purple-900">Mitglieder</h4>
                <p className="text-2xl font-bold text-purple-600">
                  {users.filter(u => u.role === 'member').length}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default AdminPanel;
