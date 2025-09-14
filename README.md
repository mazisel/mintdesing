# Mintdegisn - Teklif Yönetim Sistemi

Bu proje, nakliye şirketleri için geliştirilmiş modern bir teklif yönetim sistemidir.

## 🚀 Özellikler

- **Kullanıcı Yönetimi**: JWT tabanlı kimlik doğrulama sistemi
- **Teklif Oluşturma**: Detaylı teklif oluşturma ve yönetimi
- **PDF Export**: Teklifleri PDF formatında dışa aktarma
- **Admin Paneli**: Kullanıcı ve şirket bilgileri yönetimi
- **Responsive Tasarım**: Mobil ve masaüstü uyumlu arayüz

## 🛠️ Teknolojiler

- **Backend**: FastAPI + Python
- **Frontend**: React + Tailwind CSS + Radix UI
- **Veritabanı**: MongoDB
- **Konteynerizasyon**: Docker + Docker Compose

## 📦 Docker ile Kurulum (Önerilen)

### Gereksinimler
- Docker
- Docker Compose

### Kurulum Adımları

1. **Projeyi klonlayın:**
```bash
git clone https://github.com/mazisel/mintdesing.git
cd mintdesing
```

2. **Docker Compose ile çalıştırın:**
```bash
docker-compose up -d
```

3. **Servislerin durumunu kontrol edin:**
```bash
docker-compose ps
```

### Erişim Bilgileri
- **Frontend**: http://localhost:3005
- **Backend API**: http://localhost:8080
- **API Dokümantasyonu**: http://localhost:8080/docs
- **MongoDB**: localhost:27017

### Docker Komutları

```bash
# Servisleri başlat
docker-compose up -d

# Servisleri durdur
docker-compose down

# Logları görüntüle
docker-compose logs -f

# Belirli bir servisin loglarını görüntüle
docker-compose logs -f backend
docker-compose logs -f frontend

# Servisleri yeniden başlat
docker-compose restart

# Veritabanı verilerini de sil
docker-compose down -v
```

## 🔧 Manuel Kurulum

### Gereksinimler
- Python 3.8+
- Node.js 16+
- MongoDB
- Yarn

### Backend Kurulumu

1. **Backend dizinine gidin:**
```bash
cd backend
```

2. **Virtual environment oluşturun:**
```bash
python3 -m venv venv
source venv/bin/activate  # Linux/Mac
# venv\Scripts\activate  # Windows
```

3. **Bağımlılıkları kurun:**
```bash
pip install -r requirements.txt
```

4. **Çevre değişkenlerini ayarlayın:**
```bash
cp .env.example .env
# .env dosyasını düzenleyin
```

5. **Sunucuyu başlatın:**
```bash
uvicorn server:app --host 0.0.0.0 --port 8080 --reload
```

### Frontend Kurulumu

1. **Frontend dizinine gidin:**
```bash
cd frontend
```

2. **Bağımlılıkları kurun:**
```bash
yarn install
```

3. **Çevre değişkenlerini ayarlayın:**
```bash
cp .env.example .env
# .env dosyasını düzenleyin
```

4. **Development sunucusunu başlatın:**
```bash
yarn start
```

### MongoDB Kurulumu

MongoDB'yi yerel olarak kurmak için [MongoDB resmi dokümantasyonunu](https://docs.mongodb.com/manual/installation/) takip edin.

## 🌐 Production Deployment

### Ubuntu Sunucuya Kurulum

1. **Gerekli paketleri kurun:**
```bash
sudo apt update
sudo apt install -y docker.io docker-compose git
```

2. **Docker servisini başlatın:**
```bash
sudo systemctl start docker
sudo systemctl enable docker
```

3. **Projeyi klonlayın:**
```bash
git clone https://github.com/mazisel/mintdesing.git
cd mintdesing
```

4. **Production için çevre değişkenlerini ayarlayın:**
```bash
# docker-compose.yml dosyasındaki environment değişkenlerini düzenleyin
```

5. **Servisleri başlatın:**
```bash
sudo docker-compose up -d
```

6. **Firewall ayarları:**
```bash
sudo ufw allow 3005
sudo ufw allow 8080
```

## 📝 API Dokümantasyonu

Backend çalıştıktan sonra API dokümantasyonuna şu adresten erişebilirsiniz:
- Swagger UI: http://localhost:8080/docs
- ReDoc: http://localhost:8080/redoc

## 🔐 Varsayılan Giriş Bilgileri

İlk kurulumdan sonra admin kullanıcısı oluşturmak için `/api/auth/register` endpoint'ini kullanın.

## 🤝 Katkıda Bulunma

1. Bu repository'yi fork edin
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add some amazing feature'`)
4. Branch'inizi push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

## 🆘 Destek

Herhangi bir sorun yaşarsanız, lütfen [GitHub Issues](https://github.com/mazisel/mintdesing/issues) sayfasından bildiriniz.
