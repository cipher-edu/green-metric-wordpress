# 🚀 Server Deployment Guide - greenmetric.nspi.uz

## 📋 Server Ma'lumotlari
- **IP:** 167.86.90.91
- **User:** root
- **Password:** JZh53k9q6
- **Repository:** https://github.com/cipher-edu/green-metric-wordpress

## 🔧 Deployment Qadamlari

### 1. Serverga Ulanish
```bash
ssh root@167.86.90.91
```

### 2. Loyiha Papkasiga O'tish
```bash
cd /var/www/green-metric-wordpress
```

### 3. Environment Faylini Sozlash
```bash
# Production environment faylini nusxalash
cp .env.example .env.production

# Environment faylini tahrirlash
nano .env.production
```

### 4. Docker va Kerakli Dasturlarni O'rnatish
```bash
# Tizimni yangilash
apt update && apt upgrade -y

# Docker o'rnatish
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh

# Docker Compose o'rnatish
curl -L "https://github.com/docker/compose/releases/download/v2.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# Git o'rnatish (agar yo'q bo'lsa)
apt install -y git curl wget nano
```

### 5. Deploy Scriptini Ishga Tushirish
```bash
# Script ruxsatlarini berish
chmod +x deploy.sh

# Deploy scriptini ishga tushirish
./deploy.sh
```

### 6. SSL Sertifikatini O'rnatish
```bash
# SSL setup script ruxsatlarini berish
chmod +x setup-ssl.sh

# SSL sertifikatini o'rnatish
./setup-ssl.sh
```

### 7. Docker Containerlarni Ishga Tushirish
```bash
# Production environment bilan containerlarni ishga tushirish
docker-compose -f docker-compose.production.yml up -d

# Container holatini tekshirish
docker-compose -f docker-compose.production.yml ps
```

### 8. DNS Sozlashni Tekshirish
Domain `greenmetric.nspi.uz` uchun DNS A record ni sozlang:
```
A Record: greenmetric.nspi.uz → 167.86.90.91
```

### 9. Sayt Ishlashini Tekshirish
```bash
# Nginx holatini tekshirish
docker-compose -f docker-compose.production.yml logs nginx

# WordPress holatini tekshirish
docker-compose -f docker-compose.production.yml logs wordpress

# Database holatini tekshirish
docker-compose -f docker-compose.production.yml logs db

# SSL sertifikat holatini tekshirish
curl -I https://greenmetric.nspi.uz
```

## 🔍 Monitoring va Xatolarni Tekshirish

### Container Loglarini Ko'rish
```bash
# Barcha container loglarini ko'rish
docker-compose -f docker-compose.production.yml logs

# Alohida container loglarini ko'rish
docker-compose -f docker-compose.production.yml logs nginx
docker-compose -f docker-compose.production.yml logs wordpress
docker-compose -f docker-compose.production.yml logs db
docker-compose -f docker-compose.production.yml logs redis
```

### Xizmatlarni Qayta Ishga Tushirish
```bash
# Barcha xizmatlarni qayta ishga tushirish
docker-compose -f docker-compose.production.yml restart

# Alohida xizmatni qayta ishga tushirish
docker-compose -f docker-compose.production.yml restart nginx
```

### Backup Yaratish
```bash
# Backup scriptini ishga tushirish
chmod +x scripts/backup.sh
./scripts/backup.sh
```

## 🎯 Yakuniy Tekshirish

1. **Sayt ochilishi:** https://greenmetric.nspi.uz
2. **SSL sertifikat:** Yashil qulf belgisi
3. **WordPress admin:** https://greenmetric.nspi.uz/wp-admin
4. **PhpMyAdmin:** https://greenmetric.nspi.uz:8080

## 🔧 Muammolarni Hal Qilish

### Agar containerlar ishlamasa:
```bash
# Containerlarni to'xtatish
docker-compose -f docker-compose.production.yml down

# Volumelarni tozalash
docker volume prune

# Qayta ishga tushirish
docker-compose -f docker-compose.production.yml up -d
```

### Agar SSL ishlamasa:
```bash
# SSL sertifikatni qayta olish
./setup-ssl.sh --force-renewal
```

### Agar sayt ochilmasa:
```bash
# Firewall sozlamalarini tekshirish
ufw status
ufw allow 80
ufw allow 443
ufw allow 22

# Nginx konfiguratsiyasini tekshirish
docker-compose -f docker-compose.production.yml exec nginx nginx -t
```

## 📞 Qo'llab-quvvatlash

Sayt manzili: https://greenmetric.nspi.uz
Repository: https://github.com/cipher-edu/green-metric-wordpress
