import React, { useState, useEffect } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import { useAuth } from '../App';

const BACKEND_URL = process.env.REACT_APP_BACKEND_URL;
const API = `${BACKEND_URL}/api`;

const QuoteCreator = () => {
  const { user, logout } = useAuth();
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [systemTitle, setSystemTitle] = useState('Transport Offerte System');

  useEffect(() => {
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

  const [quote, setQuote] = useState({
    customer: {
      company_name: '',
      address: '',
      postal_code: ''
    },
    transport_details: {
      pickup_date: '',
      pickup_time: '',
      pickup_location: '',
      delivery_date: '',
      delivery_time: '',
      delivery_location: '',
      shipment_type: '4 Europaletten',
      total_weight: '1200 kg',
      service_type: 'Palettentransport (24h)',
      transport_type: 'Standardfahrt / Express / Direktfahrt / Nachtexpress'
    },
    price_items: [
      {
        description: 'Transport (Bern → Zürich)',
        quantity: '4 Paletten',
        unit_price: 65.0,
        total_net: 260.0,
        vat_rate: 8.1,
        total_incl_vat: 281.06
      },
      {
        description: 'Kilometerpauschale',
        quantity: '120 km',
        unit_price: 1.50,
        total_net: 180.0,
        vat_rate: 8.1,
        total_incl_vat: 194.58
      },
      {
        description: 'Treibstoffzuschlag 7.5 %',
        quantity: '-',
        unit_price: 0,
        total_net: 33.75,
        vat_rate: 8.1,
        total_incl_vat: 36.48
      },
      {
        description: 'Express-/Zuschläge',
        quantity: '-',
        unit_price: 0,
        total_net: 0.0,
        vat_rate: 8.1,
        total_incl_vat: 0.0
      }
    ],
    subtotal: 473.75,
    vat_total: 38.37,
    grand_total: 512.12
  });

  const handleCustomerChange = (field, value) => {
    setQuote(prev => ({
      ...prev,
      customer: {
        ...prev.customer,
        [field]: value
      }
    }));
  };

  const handleTransportChange = (field, value) => {
    setQuote(prev => ({
      ...prev,
      transport_details: {
        ...prev.transport_details,
        [field]: value
      }
    }));
  };

  const handlePriceItemChange = (index, field, value) => {
    const newPriceItems = [...quote.price_items];
    newPriceItems[index] = {
      ...newPriceItems[index],
      [field]: field === 'unit_price' || field === 'total_net' || field === 'vat_rate' || field === 'total_incl_vat' 
        ? parseFloat(value) || 0 
        : value
    };

    // Recalculate totals
    if (field === 'unit_price' || field === 'total_net') {
      const item = newPriceItems[index];
      if (field === 'unit_price') {
        // Extract number from quantity if it's a string like "4 Paletten"
        const qty = parseFloat(item.quantity) || 1;
        item.total_net = item.unit_price * qty;
      }
      item.total_incl_vat = item.total_net * (1 + item.vat_rate / 100);
    }

    // Recalculate totals
    const subtotal = newPriceItems.reduce((sum, item) => sum + item.total_net, 0);
    const vat_total = newPriceItems.reduce((sum, item) => sum + (item.total_net * item.vat_rate / 100), 0);
    
    setQuote(prev => ({
      ...prev,
      price_items: newPriceItems,
      subtotal,
      vat_total,
      grand_total: subtotal + vat_total
    }));
  };

  const addPriceItem = () => {
    setQuote(prev => ({
      ...prev,
      price_items: [
        ...prev.price_items,
        {
          description: '',
          quantity: '1',
          unit_price: 0,
          total_net: 0,
          vat_rate: 8.1,
          total_incl_vat: 0
        }
      ]
    }));
  };

  const removePriceItem = (index) => {
    if (quote.price_items.length > 1) {
      const newPriceItems = quote.price_items.filter((_, i) => i !== index);
      const subtotal = newPriceItems.reduce((sum, item) => sum + item.total_net, 0);
      const vat_total = newPriceItems.reduce((sum, item) => sum + (item.total_net * item.vat_rate / 100), 0);
      
      setQuote(prev => ({
        ...prev,
        price_items: newPriceItems,
        subtotal,
        vat_total,
        grand_total: subtotal + vat_total
      }));
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);

    try {
      const response = await axios.post(`${API}/quotes`, quote);
      navigate(`/quote/${response.data.id}`);
    } catch (error) {
      alert('Fehler beim Erstellen der Offerte: ' + error.response?.data?.detail);
      setLoading(false);
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
          <Link to="/create-quote" className="nav-link active">Neue Offerte</Link>
          <Link to="/quotes" className="nav-link">Offerten</Link>
          {user?.role === 'admin' && <Link to="/admin" className="nav-link">Admin Panel</Link>}
        </nav>

        <div className="mb-6">
          <h1 className="text-2xl font-bold text-gray-900 mb-4">
            Neue Transport-Offerte erstellen
          </h1>
        </div>

        <form onSubmit={handleSubmit}>
          {/* Customer Information */}
          <div className="card mb-6">
            <div className="card-header">
              <h3 className="card-title">Kundeninformationen</h3>
            </div>
            <div className="card-body">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="form-group">
                  <label className="form-label">Firmenname</label>
                  <input
                    type="text"
                    className="form-input"
                    value={quote.customer.company_name}
                    onChange={(e) => handleCustomerChange('company_name', e.target.value)}
                    required
                    placeholder="z.B. Musterfirma AG"
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">PLZ/Ort</label>
                  <input
                    type="text"
                    className="form-input"
                    value={quote.customer.postal_code}
                    onChange={(e) => handleCustomerChange('postal_code', e.target.value)}
                    required
                    placeholder="z.B. 8001 Zürich"
                  />
                </div>
                <div className="form-group md:col-span-2">
                  <label className="form-label">Adresse</label>
                  <textarea
                    className="form-textarea"
                    value={quote.customer.address}
                    onChange={(e) => handleCustomerChange('address', e.target.value)}
                    required
                    placeholder="Straße und Hausnummer"
                  />
                </div>
              </div>
            </div>
          </div>

          {/* Transport Details */}
          <div className="card mb-6">
            <div className="card-header">
              <h3 className="card-title">Transportdetails</h3>
            </div>
            <div className="card-body">
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div className="form-group">
                  <label className="form-label">Abholung Datum</label>
                  <input
                    type="date"
                    className="form-input"
                    value={quote.transport_details.pickup_date}
                    onChange={(e) => handleTransportChange('pickup_date', e.target.value)}
                    required
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">Abholung Zeit</label>
                  <input
                    type="time"
                    className="form-input"
                    value={quote.transport_details.pickup_time}
                    onChange={(e) => handleTransportChange('pickup_time', e.target.value)}
                    required
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">Abholung Ort</label>
                  <input
                    type="text"
                    className="form-input"
                    value={quote.transport_details.pickup_location}
                    onChange={(e) => handleTransportChange('pickup_location', e.target.value)}
                    required
                    placeholder="z.B. Bern"
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">Lieferung Datum</label>
                  <input
                    type="date"
                    className="form-input"
                    value={quote.transport_details.delivery_date}
                    onChange={(e) => handleTransportChange('delivery_date', e.target.value)}
                    required
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">Lieferung Zeit</label>
                  <input
                    type="time"
                    className="form-input"
                    value={quote.transport_details.delivery_time}
                    onChange={(e) => handleTransportChange('delivery_time', e.target.value)}
                    required
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">Lieferung Ort</label>
                  <input
                    type="text"
                    className="form-input"
                    value={quote.transport_details.delivery_location}
                    onChange={(e) => handleTransportChange('delivery_location', e.target.value)}
                    required
                    placeholder="z.B. Zürich"
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">Sendung</label>
                  <input
                    type="text"
                    className="form-input"
                    value={quote.transport_details.shipment_type}
                    onChange={(e) => handleTransportChange('shipment_type', e.target.value)}
                    placeholder="z.B. 4 Europaletten"
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">Gewicht gesamt</label>
                  <input
                    type="text"
                    className="form-input"
                    value={quote.transport_details.total_weight}
                    onChange={(e) => handleTransportChange('total_weight', e.target.value)}
                    placeholder="z.B. 1200 kg"
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">Service</label>
                  <input
                    type="text"
                    className="form-input"
                    value={quote.transport_details.service_type}
                    onChange={(e) => handleTransportChange('service_type', e.target.value)}
                    placeholder="z.B. Palettentransport (24h)"
                  />
                </div>
              </div>
              <div className="form-group">
                <label className="form-label">Tätigkeit der Fahrt</label>
                <input
                  type="text"
                  className="form-input"
                  value={quote.transport_details.transport_type}
                  onChange={(e) => handleTransportChange('transport_type', e.target.value)}
                  placeholder="z.B. Standardfahrt / Express / Direktfahrt / Nachtexpress"
                />
              </div>
            </div>
          </div>

          {/* Price Items */}
          <div className="card mb-6">
            <div className="card-header">
              <div className="flex justify-between items-center">
                <h3 className="card-title">Preise</h3>
                <button
                  type="button"
                  onClick={addPriceItem}
                  className="btn btn-secondary"
                >
                  Position hinzufügen
                </button>
              </div>
            </div>
            <div className="card-body">
              <div className="overflow-x-auto">
                <table className="table">
                  <thead>
                    <tr>
                      <th>Leistung</th>
                      <th>Menge</th>
                      <th>Einzelpreis</th>
                      <th>Total Netto</th>
                      <th>MwSt. %</th>
                      <th>Total inkl. MwSt.</th>
                      <th>Aktionen</th>
                    </tr>
                  </thead>
                  <tbody>
                    {quote.price_items.map((item, index) => (
                      <tr key={index}>
                        <td>
                          <input
                            type="text"
                            className="form-input"
                            value={item.description}
                            onChange={(e) => handlePriceItemChange(index, 'description', e.target.value)}
                            placeholder="Leistungsbeschreibung"
                          />
                        </td>
                        <td>
                          <input
                            type="text"
                            className="form-input"
                            value={item.quantity}
                            onChange={(e) => handlePriceItemChange(index, 'quantity', e.target.value)}
                            placeholder="Menge"
                          />
                        </td>
                        <td>
                          <input
                            type="number"
                            step="0.01"
                            className="form-input"
                            value={item.unit_price}
                            onChange={(e) => handlePriceItemChange(index, 'unit_price', e.target.value)}
                            placeholder="0.00"
                          />
                        </td>
                        <td>
                          <input
                            type="number"
                            step="0.01"
                            className="form-input"
                            value={item.total_net.toFixed(2)}
                            onChange={(e) => handlePriceItemChange(index, 'total_net', e.target.value)}
                          />
                        </td>
                        <td>
                          <input
                            type="number"
                            step="0.1"
                            className="form-input"
                            value={item.vat_rate}
                            onChange={(e) => handlePriceItemChange(index, 'vat_rate', e.target.value)}
                          />
                        </td>
                        <td>
                          <input
                            type="text"
                            className="form-input"
                            value={`CHF ${item.total_incl_vat.toFixed(2)}`}
                            readOnly
                          />
                        </td>
                        <td>
                          {quote.price_items.length > 1 && (
                            <button
                              type="button"
                              onClick={() => removePriceItem(index)}
                              className="btn btn-danger"
                              style={{fontSize: '0.75rem', padding: '0.25rem 0.5rem'}}
                            >
                              ×
                            </button>
                          )}
                        </td>
                      </tr>
                    ))}
                  </tbody>
                  <tfoot>
                    <tr className="font-bold">
                      <td colSpan="3">Gesamtbetrag</td>
                      <td>CHF {quote.subtotal.toFixed(2)}</td>
                      <td>CHF {quote.vat_total.toFixed(2)}</td>
                      <td>CHF {quote.grand_total.toFixed(2)}</td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

          {/* Submit */}
          <div className="flex gap-4">
            <button
              type="submit"
              className="btn btn-primary"
              disabled={loading}
            >
              {loading ? 'Wird erstellt...' : 'Offerte erstellen'}
            </button>
            <Link to="/dashboard" className="btn btn-secondary">
              Abbrechen
            </Link>
          </div>
        </form>
      </div>
    </div>
  );
};

export default QuoteCreator;
