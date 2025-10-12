import React, { useState, useEffect } from 'react';
import { Link, useParams } from 'react-router-dom';
import axios from 'axios';
import { useAuth } from '../App';

const BACKEND_URL = process.env.REACT_APP_BACKEND_URL;
const API = `${BACKEND_URL}/api`;

const QuotePDF = () => {
  const { id } = useParams();
  const { user, logout } = useAuth();
  const [quote, setQuote] = useState(null);
  const [loading, setLoading] = useState(true);
  const [company, setCompany] = useState(null);
  const [swissQR, setSwissQR] = useState(null);

  useEffect(() => {
    fetchQuote();
    fetchCompany();
    fetchSwissQR();
  }, [id]);

  const fetchQuote = async () => {
    try {
      const response = await axios.get(`${API}/quotes/${id}`);
      setQuote(response.data);
    } catch (error) {
      console.error('Error fetching quote:', error);
    } finally {
      setLoading(false);
    }
  };

  const fetchCompany = async () => {
    try {
      const response = await axios.get(`${API}/company`);
      setCompany(response.data);
    } catch (error) {
      console.error('Error fetching company:', error);
    }
  };

  const fetchSwissQR = async () => {
    try {
      const token = localStorage.getItem('token');
      const response = await axios.get(`${API}/quotes/${id}/swiss-qr`, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      });
      setSwissQR(response.data);
    } catch (error) {
      console.error('Error fetching Swiss QR code:', error);
    }
  };

  const handlePrint = () => {
    try {
      // Modern browsers için
      if (window.print) {
        window.print();
      } else {
        // Fallback: PDF oluşturma mesajı
        alert('Bitte verwenden Sie Strg+P (Windows) oder Cmd+P (Mac) zum Drucken.');
      }
    } catch (error) {
      console.error('Print error:', error);
      alert('Druckfunktion nicht verfügbar. Verwenden Sie Strg+P zum Drucken.');
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-red-600"></div>
      </div>
    );
  }

  if (!quote) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="text-center">
          <h2 className="text-xl font-bold text-gray-900 mb-4">Offerte nicht gefunden</h2>
          <Link to="/quotes" className="btn btn-primary">Zurück zur Übersicht</Link>
        </div>
      </div>
    );
  }

  return (
    <div>
      {/* Header - Hidden in print */}
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

      {/* Navigation - Hidden in print */}
      <div className="container">
        <nav className="nav">
          <Link to="/dashboard" className="nav-link">Dashboard</Link>
          <Link to="/create-quote" className="nav-link">Neue Offerte</Link>
          <Link to="/quotes" className="nav-link">Offerten</Link>
          {user?.role === 'admin' && <Link to="/admin" className="nav-link">Admin Panel</Link>}
        </nav>

        {/* Action buttons - Hidden in print */}
        <div className="mb-6 flex gap-4 print-hidden">
          <button onClick={handlePrint} className="btn btn-primary">
            🖨️ PDF Drucken/Speichern
          </button>
          <button 
            onClick={() => {
              // Alternative: PDF als HTML Datei herunterladen
              const element = document.querySelector('.pdf-preview');
              const htmlContent = `
                <!DOCTYPE html>
                <html>
                <head>
                  <meta charset="UTF-8">
                  <title>Transport-Offerte ${quote.quote_number}</title>
                  <style>
                    @page { size: A4; margin: 10mm; }
                    body { font-family: Arial, sans-serif; margin: 0; }
                    .pdf-preview { width: 100%; max-width: 210mm; margin: 0 auto; padding: 12mm; box-sizing: border-box; }
                    .company-header { background-color: transparent; color: #111827; padding: 0 0 1.25rem 0; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; gap: 1.5rem; border-bottom: 1px solid #e5e7eb; }
                    .quote-title { text-align: center; font-size: 1.5rem; font-weight: 600; margin: 1rem 0; color: #1f2937; }
                    .transport-table, .price-table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
                    .transport-table th, .transport-table td, .price-table th, .price-table td { border: 1px solid #d1d5db; padding: 0.5rem; text-align: left; font-size: 11px; }
                    .transport-table th, .price-table th { background-color: #f3f4f6; font-weight: 600; }
                    .total-row { background-color: #fef2f2; font-weight: 600; }
                    .text-right { text-align: right; }
                    .advantages-section { margin-top: 1.5rem; padding: 1rem; border-top: 2px solid #e5e7eb; background-color: #fafafa; }
                    .advantages-section h4 { color: #1f2937; font-size: 14px; font-weight: 700; margin-bottom: 0.75rem; text-align: center; }
                    .advantages-section strong { color: #111827; font-weight: 600; }
                    .swiss-qr-section { margin-top: 40mm; width: 100%; background-color: #fff; display: flex; justify-content: center; align-items: center; page-break-before: always; break-before: page; page-break-inside: avoid; break-inside: avoid-page; min-height: 240mm; }
                    .swiss-qr-wrapper { text-align: center; width: 100%; }
                    .swiss-qr-image { width: 160mm; max-width: 100%; height: auto; }
                    @media (max-width: 768px) { .swiss-qr-section { margin-top: 20mm; min-height: 200mm; } }
                    @media print { .swiss-qr-section { margin-top: 0 !important; min-height: calc(297mm - 20mm) !important; page-break-before: always !important; break-before: page !important; page-break-inside: avoid !important; break-inside: avoid-page !important; } .swiss-qr-image { width: 160mm !important; max-width: 100% !important; height: auto !important; } }
                  </style>
                </head>
                <body>
                  ${element.innerHTML}
                </body>
                </html>
              `;
              
              const blob = new Blob([htmlContent], { type: 'text/html' });
              const url = window.URL.createObjectURL(blob);
              const a = document.createElement('a');
              a.href = url;
              a.download = `Transport-Offerte-${quote.quote_number}.html`;
              document.body.appendChild(a);
              a.click();
              document.body.removeChild(a);
              window.URL.revokeObjectURL(url);
            }}
            className="btn btn-secondary"
          >
            💾 HTML Herunterladen
          </button>
          <Link to="/quotes" className="btn btn-secondary">
            Zurück zur Übersicht
          </Link>
        </div>

        {/* PDF Preview */}
        <div className="pdf-preview">
          {/* Company Header */}
          <div className="company-header">
            <div style={{minWidth: '160px'}}>
              {company?.logo_url ? (
                <img 
                  src={company.logo_url} 
                  alt="Company Logo" 
                  style={{
                    maxHeight: '80px',
                    maxWidth: '160px',
                    width: 'auto',
                    height: 'auto',
                    objectFit: 'contain',
                    WebkitPrintColorAdjust: 'exact',
                    colorAdjust: 'exact',
                    printColorAdjust: 'exact'
                  }}
                  onError={(e) => {
                    e.target.style.display = 'none';
                    e.target.nextSibling.style.display = 'block';
                  }}
                />
              ) : null}
              <div 
                className="text-lg font-bold" 
                style={{
                  display: company?.logo_url ? 'none' : 'block'
                }}
              >
                LOGO
              </div>
            </div>
            <div className="text-right" style={{fontSize: '12px', lineHeight: '1.5', color: '#4b5563'}}>
              <div className="font-bold">{company?.name || 'Ammann & Co Transport GmbH'}</div>
              <div>Str. Bern</div>
              <div>Tel: +41 31 55 55 55</div>
              <div>info@ammann-transport.ch</div>
              <div>www.ammann-transport.ch</div>
            </div>
          </div>

          {/* Quote Title */}
          <div className="quote-title">Transport-Offerte</div>

          {/* Quote Info */}
          <div className="quote-info">
            <div>
              <div><strong>Offerte Nr.:</strong> {quote.quote_number}</div>
              <div><strong>Datum:</strong> {quote.date}</div>
            </div>
            <div>
              <div><strong>Kunde:</strong></div>
              <div>{quote.customer.company_name}</div>
              <div>{quote.customer.address}</div>
              <div>{quote.customer.postal_code}</div>
            </div>
          </div>

          {/* Transport Details */}
          <div className="mb-4">
            <h3 className="font-bold mb-2">Transportdetails</h3>
            <table className="transport-table">
              <tbody>
                <tr>
                  <td className="font-medium">Abholung</td>
                  <td>
                    {new Date(quote.transport_details.pickup_date).toLocaleDateString('de-DE')}, {quote.transport_details.pickup_time} Uhr, {quote.transport_details.pickup_location}
                  </td>
                </tr>
                <tr>
                  <td className="font-medium">Lieferung</td>
                  <td>
                    {new Date(quote.transport_details.delivery_date).toLocaleDateString('de-DE')}, {quote.transport_details.delivery_time} Uhr, {quote.transport_details.delivery_location}
                  </td>
                </tr>
                <tr>
                  <td className="font-medium">Sendung</td>
                  <td>{quote.transport_details.shipment_type}</td>
                </tr>
                <tr>
                  <td className="font-medium">Gewicht gesamt</td>
                  <td>{quote.transport_details.total_weight}</td>
                </tr>
                <tr>
                  <td className="font-medium">Service</td>
                  <td>{quote.transport_details.service_type}</td>
                </tr>
                <tr>
                  <td className="font-medium">Tätigkeit der Fahrt</td>
                  <td>{quote.transport_details.transport_type}</td>
                </tr>
              </tbody>
            </table>
          </div>

          {/* Price Table */}
          <div className="mb-4">
            <h3 className="font-bold mb-2">Preise</h3>
            <table className="price-table">
              <thead>
                <tr>
                  <th>Leistung</th>
                  <th>Menge</th>
                  <th>Einzelpreis</th>
                  <th>Total Netto</th>
                  <th>MwSt. {quote.price_items[0]?.vat_rate || 8.1} %</th>
                  <th>Total inkl. MwSt.</th>
                </tr>
              </thead>
              <tbody>
                {quote.price_items.map((item, index) => (
                  <tr key={index}>
                    <td>{item.description}</td>
                    <td>{item.quantity}</td>
                    <td className="text-right">
                      {item.unit_price > 0 ? `CHF ${item.unit_price.toFixed(2)}` : '-'}
                    </td>
                    <td className="text-right">CHF {item.total_net.toFixed(2)}</td>
                    <td className="text-right">CHF {(item.total_net * item.vat_rate / 100).toFixed(2)}</td>
                    <td className="text-right">CHF {item.total_incl_vat.toFixed(2)}</td>
                  </tr>
                ))}
                <tr className="total-row">
                  <td colSpan="3" className="font-bold">Gesamtbetrag</td>
                  <td className="text-right font-bold">CHF {quote.subtotal.toFixed(2)}</td>
                  <td className="text-right font-bold">CHF {quote.vat_total.toFixed(2)}</td>
                  <td className="text-right font-bold">CHF {quote.grand_total.toFixed(2)}</td>
                </tr>
              </tbody>
            </table>
          </div>

          {/* Company Advantages */}
          <div className="advantages-section">
            <h4 className="font-bold mb-3" style={{fontSize: '14px', color: '#1f2937'}}>
              Unsere Vorteile
            </h4>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-3" style={{fontSize: '11px', lineHeight: '1.4'}}>
              <div>
                <strong>🎯 Zuverlässigkeit:</strong> Pünktliche Abholung und termingerechte Lieferung in der ganzen Region.
              </div>
              <div>
                <strong>⚡ Flexibilität:</strong> Transporte als Standard-, Express-, Direkt- oder Nachtexpressfahrten möglich.
              </div>
              <div>
                <strong>💰 Transparente Preise:</strong> Faire Konditionen, klare Zuschläge, keine versteckten Kosten.
              </div>
              <div>
                <strong>🎓 Erfahrung & Kompetenz:</strong> Qualifiziertes Fachpersonal mit langjähriger Branchenerfahrung.
              </div>
              <div>
                <strong>🛡️ Sicherheit:</strong> Versicherungsschutz bis CHF 30'000.– inklusive, zusätzliche Deckung möglich.
              </div>
              <div>
                <strong>🌱 Nachhaltigkeit:</strong> Moderne, treibstoffeffiziente Fahrzeuge.
              </div>
            </div>
          </div>

          {/* Payment Terms */}
          <div className="payment-terms">
            <h4 className="font-bold mb-1">Zahlungsbedingungen</h4>
            <p>Rechnungen sind innert 30 Tagen netto zahlbar.</p>
            <p>Bei Neukunden behalten wir uns Barzahlung oder Vorkasse vor.</p>
          </div>

          {/* Swiss QR Code Section */}
          {swissQR && (
            <div className="swiss-qr-section">
              <div className="swiss-qr-wrapper">
                <img 
                  src={swissQR.qr_code} 
                  alt="Swiss QR Code" 
                  className="swiss-qr-image"
                  style={{
                    WebkitPrintColorAdjust: 'exact',
                    colorAdjust: 'exact',
                    printColorAdjust: 'exact'
                  }}
                />
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default QuotePDF;
