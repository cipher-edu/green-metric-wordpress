# WordPress Production Deployment Commands
# Run these commands to deploy to # Nginx konfiguratsiyasini sozlash
```bash
# Domain nomini o'zgartirish (allaqachon greenmetric.nspi.uz ga sozlangan)
# sed -i 's/yoursite.com/greenmetric.nspi.uz/g' nginx/conf.d/wordpress.conf
```ction server

## 1. Server ga ulanish
```bash
ssh root@167.86.90.91
```

## 2. Serverni tayyorlash
```bash
# System yangilash
apt update && apt upgrade -y

# Docker o'rnatish
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh
systemctl enable docker
systemctl start docker

# Docker Compose o'rnatish
curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# Kerakli paketlar
apt install -y ufw fail2ban htop curl wget git nano
```

## 3. Xavfsizlik sozlash
```bash
# Firewall
ufw --force reset
ufw default deny incoming
ufw default allow outgoing
ufw allow ssh
ufw allow 80/tcp
ufw allow 443/tcp
ufw --force enable

# Fail2ban
systemctl enable fail2ban
systemctl start fail2ban
```

## 4. Loyiha fayllarini ko'chirish
```bash
# Loyiha papkasini yaratish
mkdir -p /opt/wordpress
cd /opt/wordpress

# Fayllarni local kompyuterdan server ga ko'chirish (local kompyuterda ishlatish)
scp -r d:/Inkubatsiya/* root@167.86.90.91:/opt/wordpress/
```

## 5. Environment sozlash
```bash
cd /opt/wordpress

# .env.production faylini .env ga ko'chirish
cp .env.production .env

# Domain va email o'zgartirish
nano .env
# DOMAIN_NAME=yoursite.com o'zgartiring
# EMAIL=your-email@domain.com o'zgartiring

# Parollarni yangilash
DB_PASSWORD=$(openssl rand -base64 32)
DB_ROOT_PASSWORD=$(openssl rand -base64 32)
echo "DB_PASSWORD=$DB_PASSWORD" >> .env
echo "DB_ROOT_PASSWORD=$DB_ROOT_PASSWORD" >> .env
```

## 6. WordPress salts generate qilish
```bash
# WordPress xavfsizlik kalitlarini generate qilish
curl -s https://api.wordpress.org/secret-key/1.1/salt/ | sed 's/define.*(\x27\([^x27]*\)\x27,.*\x27\([^x27]*\)\x27.*/\1=\2/' >> .env
```

## 7. Nginx konfiguratsiyasini sozlash
```bash
# Domain nomini o'zgartirish
sed -i 's/yoursite.com/REAL_DOMAIN_NAME/g' nginx/conf.d/wordpress.conf
```

## 8. Konteynerlarni ishga tushirish
```bash
# Production build
docker-compose -f docker-compose.production.yml up -d --build

# Loglarni ko'rish
docker-compose -f docker-compose.production.yml logs -f
```

## 9. SSL sertifikat olish
```bash
# Domain DNS ni server IP ga yo'naltirganingizdan keyin
chmod +x setup-ssl.sh
./setup-ssl.sh
```

## 10. Backup sozlash
```bash
# Backup skriptlarini executable qilish
chmod +x scripts/*.sh

# Cron job qo'shish (har kuni soat 2:00 da backup)
(crontab -l 2>/dev/null; echo "0 2 * * * cd /opt/wordpress && docker-compose -f docker-compose.production.yml run --rm backup /scripts/backup.sh") | crontab -
```

## 11. Monitoring sozlash
```bash
# Health check
curl -f http://localhost/nginx-health

# Container statuslarini tekshirish
docker-compose -f docker-compose.production.yml ps
```

## Muhim Eslatmalar:

1. **Domain DNS**: Domen nomingizni server IP ga yo'naltiring
2. **SSL Certificate**: Faqat DNS o'rnatilgandan keyin SSL olishga harakat qiling
3. **Backup**: Muntazam backup oling va test qiling
4. **Security**: Parollarni o'zgartiring va xavfsiz saqlang
5. **Monitoring**: Log fayllarni muntazam tekshiring

## Foydali Komandalar:

```bash
# Konteyner loglarini ko'rish
docker-compose -f docker-compose.production.yml logs wordpress

# Database backup qilish
docker-compose -f docker-compose.production.yml run --rm backup /scripts/backup.sh

# WordPress CLI ishlatish
docker-compose -f docker-compose.production.yml exec wordpress wp --info

# Konteynerlarni qayta ishga tushirish
docker-compose -f docker-compose.production.yml restart

# Yangilanishlar o'rnatish
docker-compose -f docker-compose.production.yml pull
docker-compose -f docker-compose.production.yml up -d
```
