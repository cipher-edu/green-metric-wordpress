# GitHub Repository Yaratish va Loyihani Yuklash

## 1. GitHub Repository Yaratish

1. GitHub sahifangizga o'ting: https://github.com
2. **"New Repository"** tugmasini bosing
3. Quyidagi ma'lumotlarni kiriting:
   - **Repository name:** `green-metric-wordpress`
   - **Description:** `Green Metric NSPI WordPress Production Deployment - greenmetric.nspi.uz`
   - **Visibility:** Public (yoki Private, agar kerak bo'lsa)
   - **Initialize this repository:** bo'sh qoldiring (bizda allaqachon kodlar bor)

## 2. Repository Yaratgandan So'ng

Repository yaratgandan so'ng, GitHub sahifasida quyidagi buyruqlar ko'rsatiladi. Ular o'rniga quyidagi buyruqlarni terminal orqali bajaring:

```bash
# GitHub repository ni remote sifatida qo'shish
git remote add origin https://github.com/SIZNING-USERNAME/green-metric-wordpress.git

# Main branch ni yaratish va o'rnatish
git branch -M main

# Loyihani GitHub ga yuklash
git push -u origin main
```

**Muhim:** `SIZNING-USERNAME` ni o'zingizning GitHub username bilan almashtiring!

## 3. Fayllar Haqida Ma'lumot

Quyidagi fayllar loyihaga qo'shildi:

### Docker Konfiguratsiyasi
- `docker-compose.production.yml` - Production uchun asosiy orkestratsiya
- `Dockerfile.production` - Production container image
- `docker-compose.yml` - Development uchun
- `.env.production` - Production muhit o'zgaruvchilari
- `.env.example` - Namuna muhit fayli

### Nginx Konfiguratsiyasi
- `nginx/conf.d/wordpress.conf` - SSL va security bilan reverse proxy
- Domain: `greenmetric.nspi.uz` uchun sozlangan

### SSL va Xavfsizlik
- `setup-ssl.sh` - Let's Encrypt SSL sertifikatini avtomatik o'rnatish
- `deploy.sh` - Server setup va xavfsizlik konfiguratsiyasi

### Backup va Monitoring
- `scripts/backup.sh` - Ma'lumotlar bazasi va fayllar backup
- `scripts/restore.sh` - Backup ni qayta tiklash
- `scripts/monitor.sh` - System monitoring va alertlar

### Database
- `mysql/conf.d/mysql-performance.cnf` - MySQL optimization

### GitHub Actions CI/CD
- `.github/workflows/deploy.yml` - Avtomatik deploy pipeline

## 4. Production Deploy Qilish

```bash
# Serverga ulanish
ssh root@167.86.90.91

# Repository ni clone qilish
git clone https://github.com/SIZNING-USERNAME/green-metric-wordpress.git
cd green-metric-wordpress

# Deploy scriptini ishga tushirish
chmod +x deploy.sh
./deploy.sh
```

## 5. Domain Setup

1. DNS ni serverga yo'naltiring:
   ```
   A Record: greenmetric.nspi.uz → 167.86.90.91
   ```

2. SSL sertifikatini o'rnating:
   ```bash
   chmod +x setup-ssl.sh
   ./setup-ssl.sh
   ```

3. Containerlarni ishga tushiring:
   ```bash
   docker-compose -f docker-compose.production.yml up -d
   ```

## 6. Server Ma'lumotlari

- **Server IP:** 167.86.90.91
- **User:** root
- **Password:** JZh53k9q6
- **Domain:** greenmetric.nspi.uz

## 7. Monitoring va Backup

- **Backup:** Har kuni avtomatik backup `/backups/` papkasida
- **Monitoring:** `scripts/monitor.sh` orqali health check
- **Logs:** `docker-compose logs` orqali tekshiring

## 8. Texnik Xususiyatlar

- **WordPress:** PHP 8.2 + FPM
- **Database:** MySQL 8.0 optimized
- **Cache:** Redis object cache
- **Web Server:** Nginx reverse proxy
- **SSL:** Let's Encrypt with auto-renewal
- **Security:** UFW firewall, fail2ban, rate limiting
