#!/bin/bash

echo "🔍 Backend loglarını kontrol ediyorum..."
echo "========================================"

# Docker logs
docker-compose -f docker-compose.portainer.yml logs backend --tail=100 | grep -A 10 -B 5 "swiss-qr\|Error\|Exception\|Traceback"

echo ""
echo "========================================"
echo "✅ Log kontrolü tamamlandı"

