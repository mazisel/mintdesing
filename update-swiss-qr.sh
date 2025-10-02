#!/bin/bash

# Swiss QR Code Güncelleme Scripti
# Bu scripti canlı sunucuda çalıştırın

set -e  # Hata durumunda dur

echo "🇨🇭 Swiss QR Code Güncelleme Başlıyor..."
echo "================================================"

# Renk kodları
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# 1. Git güncellemeleri
echo -e "\n${YELLOW}1. Git güncellemeleri çekiliyor...${NC}"
git fetch origin
git pull origin main
echo -e "${GREEN}✅ Git güncellemesi tamamlandı${NC}"

# 2. Değişiklikleri göster
echo -e "\n${YELLOW}2. Son değişiklikler:${NC}"
git log --oneline -5

# 3. Backend kontrol
echo -e "\n${YELLOW}3. Backend kontrol ediliyor...${NC}"
if [ -f "backend/requirements.txt" ]; then
    echo "✅ requirements.txt bulundu"
    grep -E "segno|Pillow" backend/requirements.txt || echo "⚠️  segno/Pillow bulunamadı!"
else
    echo -e "${RED}❌ requirements.txt bulunamadı!${NC}"
    exit 1
fi

# 4. Docker kontrolü
echo -e "\n${YELLOW}4. Docker durumu kontrol ediliyor...${NC}"
if command -v docker-compose &> /dev/null; then
    echo "✅ docker-compose mevcut"
    
    # Container durumunu kontrol et
    docker-compose ps
    
    # Kullanıcıya sor
    echo -e "\n${YELLOW}Docker rebuild yapmak ister misiniz? (y/n)${NC}"
    read -r response
    
    if [[ "$response" =~ ^[Yy]$ ]]; then
        echo -e "\n${YELLOW}5. Docker rebuild başlıyor...${NC}"
        echo "⏳ Bu işlem birkaç dakika sürebilir..."
        
        # Backend rebuild
        docker-compose build --no-cache backend
        echo -e "${GREEN}✅ Backend rebuild tamamlandı${NC}"
        
        # Restart
        docker-compose restart backend
        echo -e "${GREEN}✅ Backend restart edildi${NC}"
        
        # Logları göster
        echo -e "\n${YELLOW}6. Backend logları (son 20 satır):${NC}"
        docker-compose logs --tail=20 backend
        
    else
        echo "⏩ Docker rebuild atlandı"
        echo -e "\n${YELLOW}Sadece restart yapılıyor...${NC}"
        docker-compose restart backend
    fi
else
    echo "⚠️  docker-compose bulunamadı, manuel restart gerekebilir"
fi

# 7. Sistem durumu
echo -e "\n${YELLOW}7. Sistem durumu:${NC}"
if command -v docker-compose &> /dev/null; then
    docker-compose ps | grep backend
fi

# 8. Test önerileri
echo -e "\n${GREEN}================================================${NC}"
echo -e "${GREEN}✅ Güncelleme tamamlandı!${NC}"
echo -e "\n${YELLOW}📋 Yapılacaklar:${NC}"
echo "1. Tarayıcınızı açın"
echo "2. Ctrl+Shift+R (veya Cmd+Shift+R) ile cache'i temizleyin"
echo "3. Veya Incognito/Private modda test edin"
echo "4. Bir offerte açıp PDF görünümüne gidin"
echo "5. Swiss QR kodun ortasında SİYAH HAÇ olmalı ✚"
echo "6. Mobil banking ile tarayıp test edin"
echo -e "\n${YELLOW}🔍 Backend loglarını izlemek için:${NC}"
echo "   docker-compose logs -f backend"
echo -e "\n${YELLOW}🐛 Sorun yaşarsanız:${NC}"
echo "   docker-compose down"
echo "   docker-compose build --no-cache"
echo "   docker-compose up -d"
echo ""

