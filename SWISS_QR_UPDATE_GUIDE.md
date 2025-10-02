# 🇨🇭 Swiss QR Code Güncelleme Rehberi

## 📋 Canlıda Güncellemeler İçin Adım Adım

### 1. Backend Güncellemeleri

```bash
# SSH ile sunucuya bağlanın
ssh user@your-server.com

# Proje dizinine gidin
cd /path/to/mintdegisn-main

# Güncel kodu çekin
git pull origin main

# Python paketlerini güncelleyin (Docker kullanmıyorsanız)
pip3 install -r backend/requirements.txt

# Docker kullanıyorsanız - Backend'i rebuild edin
docker-compose build backend

# Servisleri restart edin
docker-compose restart backend

# Veya systemd kullanıyorsanız
sudo systemctl restart backend
```

### 2. Cache Temizleme

**Tarayıcı Cache:**
- Chrome/Edge: `Ctrl+Shift+R` (Windows) veya `Cmd+Shift+R` (Mac)
- Firefox: `Ctrl+F5` (Windows) veya `Cmd+Shift+R` (Mac)
- Veya: DevTools açın → Network tab → "Disable cache" işaretleyin

**Backend Cache (Eğer varsa):**
```bash
# Redis kullanıyorsanız
docker-compose exec redis redis-cli FLUSHALL

# Veya backend'i tamamen restart
docker-compose down
docker-compose up -d
```

### 3. Test Etme

**API Test (sunucuda):**
```bash
# Herhangi bir quote ID ile test edin
curl -X GET "http://localhost:8080/api/quotes/QUOTE_ID/swiss-qr" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  | jq '.qr_code' | head -c 100

# Base64 başlangıcını görmeli: data:image/png;base64,iVBORw...
```

**Manuel Test:**
1. Tarayıcıda yeni bir incognito/private window açın
2. Sisteme giriş yapın
3. Bir offerte açın
4. PDF görünümüne gidin
5. Swiss QR kodu kontrol edin
6. QR kodun **ortasında siyah haç** olmalı

### 4. Sorun Giderme

**Eğer hala eski QR geliyorsa:**

```bash
# 1. Backend loglarını kontrol edin
docker-compose logs -f backend | grep -i "swiss"

# 2. Requirements doğru yüklü mü?
docker-compose exec backend pip3 list | grep -E "segno|Pillow"
# Görmeli: segno 1.6.1, Pillow 11.0.0

# 3. Backend tamamen yeniden build
docker-compose down
docker-compose build --no-cache backend
docker-compose up -d

# 4. Tüm konteynerleri yeniden başlat
docker-compose down
docker-compose up -d --force-recreate
```

### 5. Doğrulama

✅ **Başarılı Swiss QR özellikleri:**
- QR kodun ortasında **siyah haç** (İsviçre bayrağı)
- Beyaz zemin
- QR kod boyutu ~200x200 px
- PNG formatında (base64)
- Mobil banking ile tarandığında:
  - IBAN otomatik doluyor
  - Tutar otomatik doluyor
  - Firma adı görünüyor
  - Referans numarası görünüyor

❌ **Eski QR (yanlış):**
- Ortada haç yok
- Sadece siyah-beyaz kareler
- Tarandığında yanlış veriler

### 6. Frontend Cache Temizleme (Node)

Eğer frontend de container'da ise:

```bash
# Frontend container'ı rebuild
docker-compose build --no-cache frontend
docker-compose restart frontend

# Veya node_modules temizle
docker-compose exec frontend rm -rf node_modules
docker-compose exec frontend npm install
docker-compose restart frontend
```

### 7. Production Build (Docker olmadan)

```bash
# Backend
cd backend
pip3 install -r requirements.txt
python3 server.py  # veya uvicorn

# Frontend
cd frontend
npm install
npm run build
# Build klasörünü serve edin
```

## 🔍 Debug Endpoint Ekle (Opsiyonel)

Server.py'ye ekleyin:

```python
@api_router.get("/debug/qr-test")
async def test_qr_generation():
    """Test Swiss QR code generation"""
    import segno
    from PIL import Image
    
    # Simple test
    qr = segno.make("TEST", error='m')
    buffer = BytesIO()
    qr.save(buffer, kind='png', scale=5)
    buffer.seek(0)
    
    img_base64 = base64.b64encode(buffer.getvalue()).decode()
    
    return {
        "status": "ok",
        "segno_working": True,
        "qr_sample": f"data:image/png;base64,{img_base64[:100]}..."
    }
```

Test: `curl http://localhost:8080/api/debug/qr-test`

## 📞 Hızlı Kontrol Komutu

Tek komutla her şeyi yenile:

```bash
#!/bin/bash
echo "🔄 Güncellemeler çekiliyor..."
git pull origin main

echo "🐳 Docker rebuild..."
docker-compose down
docker-compose build --no-cache
docker-compose up -d

echo "⏳ 10 saniye bekleniyor..."
sleep 10

echo "📊 Loglar kontrol ediliyor..."
docker-compose logs backend | tail -50

echo "✅ Tamamlandı! Tarayıcınızı yenileyin (Ctrl+Shift+R)"
```

## 🎯 Son Kontrol Listesi

- [ ] `git pull origin main` çalıştırıldı
- [ ] `docker-compose build backend` çalıştırıldı
- [ ] `docker-compose restart backend` veya `up -d` çalıştırıldı
- [ ] Backend logları kontrol edildi (hata yok)
- [ ] Tarayıcı cache temizlendi (Ctrl+Shift+R)
- [ ] İncognito/Private modda test edildi
- [ ] QR kodda İsviçre haçı görünüyor
- [ ] Mobil banking ile test edildi

---

**En son commit:** `fa8f667` - "Swiss QR kod basitleştirildi - segno ile doğrudan oluşturma"

**Değişen dosyalar:**
- `backend/server.py` (Swiss QR endpoint)
- `backend/requirements.txt` (segno, Pillow)
- `frontend/src/components/QuotePDF.js` (QR görüntüleme)
- `frontend/src/components/AdminPanel.js` (IBAN yönetimi)

