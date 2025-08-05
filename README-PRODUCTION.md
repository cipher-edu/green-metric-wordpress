# WordPress Production Ready Deployment

Bu loyiha WordPress saytingizni production muhitida Docker bilan ishga tushirish uchun to'liq konfiguratsiya.

## 🚀 Xususiyatlar

- ✅ **Docker Compose** - Multi-container WordPress stack
- ✅ **Nginx Reverse Proxy** - SSL va caching bilan
- ✅ **Let's Encrypt SSL** - Avtomatik SSL sertifikatlar
- ✅ **MySQL 8.0** - Optimizatsiya va backup bilan
- ✅ **Redis Cache** - Object caching uchun
- ✅ **PHP 8.2** - OPcache va optimizatsiya bilan
- ✅ **Xavfsizlik** - Firewall, fail2ban, security headers
- ✅ **Backup & Restore** - Avtomatik backup tizimi
- ✅ **Monitoring** - Health check va alertlar
- ✅ **Production Ready** - Scaling va performance uchun

## 📁 Fayl Tuzilishi

```
├── docker-compose.production.yml    # Production compose file
├── Dockerfile.production           # Custom WordPress container
├── wp-config-production.php        # Production WordPress config
├── .env.production                 # Environment variables template
├── nginx/
│   └── conf.d/
│       └── wordpress.conf          # Nginx configuration
├── mysql/
│   └── conf.d/
│       └── mysql-performance.cnf   # MySQL tuning
├── scripts/
│   ├── backup.sh                   # Backup script
│   ├── restore.sh                  # Restore script
│   └── monitor.sh                  # Monitoring script
├── uploads.ini                     # PHP upload settings
├── opcache.ini                     # PHP OPcache settings
├── deploy.sh                       # Server setup script
├── setup-ssl.sh                    # SSL certificate setup
├── docker-entrypoint.sh            # Custom entrypoint
└── DEPLOYMENT-GUIDE.md             # Step-by-step guide
```

## 🛠️ Server Ma'lumotlari

- **Server IP:** 167.86.90.91
- **Username:** root
- **Password:** JZh53k9q6
- **SSH Command:** `ssh root@167.86.90.91`

## 📋 Deploy Qilish Bosqichlari

### 1. Server ga Ulanish
```bash
ssh root@167.86.90.91
```

### 2. Loyiha Fayllarini Ko'chirish
```bash
# Local kompyuterda (Windows PowerShell)
scp -r "d:\Inkubatsiya\*" root@167.86.90.91:/opt/wordpress/
```

### 3. Serverni Tayyorlash
```bash
cd /opt/wordpress
chmod +x deploy.sh
./deploy.sh
```

### 4. Environment Sozlash
```bash
# .env faylini sozlash
cp .env.production .env
nano .env

# Quyidagilarni o'zgartiring:
# DOMAIN_NAME=your-real-domain.com
# EMAIL=your-email@domain.com
```

### 5. WordPress Ishga Tushirish
```bash
# Konteynerlarni ishga tushirish
docker-compose -f docker-compose.production.yml up -d --build

# Loglarni ko'rish
docker-compose -f docker-compose.production.yml logs -f
```

### 6. SSL Sertifikat Olish
```bash
# Domain DNS ni server IP ga yo'naltirgandan keyin
chmod +x setup-ssl.sh
./setup-ssl.sh
```

## 🔧 Konfiguratsiya

### Database Sozlamalari
- **MySQL 8.0** optimizatsiya bilan
- **InnoDB** buffer pool 256MB
- **Query cache** 32MB
- **Avtomatik backup** har kuni

### PHP Sozlamalari
- **Memory limit:** 512MB
- **Upload limit:** 128MB
- **Execution time:** 600s
- **OPcache** yoqilgan

### Nginx Sozlamalari
- **SSL/TLS 1.2+** faqat
- **Gzip compression** yoqilgan
- **Rate limiting** bor
- **Security headers** qo'shilgan

### Xavfsizlik
- **Firewall (UFW)** sozlangan
- **Fail2ban** SSH himoyasi
- **File permissions** to'g'ri o'rnatilgan
- **WordPress admin** file editing o'chirilgan

## 📊 Monitoring

### Health Check
```bash
# Website holatini tekshirish
curl -f https://your-domain.com/nginx-health

# Container statuslarini ko'rish
docker-compose -f docker-compose.production.yml ps
```

### Monitoring Script
```bash
# Monitoring skriptini ishga tushirish
chmod +x scripts/monitor.sh
./scripts/monitor.sh

# Cron job qo'shish (har 5 daqiqada)
(crontab -l 2>/dev/null; echo "*/5 * * * * cd /opt/wordpress && ./scripts/monitor.sh") | crontab -
```

## 💾 Backup va Restore

### Backup Olish
```bash
# Manual backup
docker-compose -f docker-compose.production.yml run --rm backup /scripts/backup.sh

# Avtomatik backup (cron)
(crontab -l 2>/dev/null; echo "0 2 * * * cd /opt/wordpress && docker-compose -f docker-compose.production.yml run --rm backup /scripts/backup.sh") | crontab -
```

### Restore Qilish
```bash
# Backup fayllarini ko'rish
ls -la backups/

# Restore qilish
docker-compose -f docker-compose.production.yml run --rm backup /scripts/restore.sh database_YYYYMMDD_HHMMSS.sql.gz wordpress_files_YYYYMMDD_HHMMSS.tar.gz
```

## 🎯 Performance Tuning

### Redis Object Cache
```bash
# Redis cache holati
docker-compose -f docker-compose.production.yml exec redis redis-cli info memory

# Cache clear qilish
docker-compose -f docker-compose.production.yml exec redis redis-cli flushall
```

### Database Optimization
```bash
# Database tuning
docker-compose -f docker-compose.production.yml exec db mysql -u root -p -e "SHOW VARIABLES LIKE 'innodb_buffer_pool_size';"

# Slow query log
docker-compose -f docker-compose.production.yml exec db tail -f /var/log/mysql-slow.log
```

## 🚨 Troubleshooting

### Container Loglarini Ko'rish
```bash
# WordPress logs
docker-compose -f docker-compose.production.yml logs wordpress

# Nginx logs
docker-compose -f docker-compose.production.yml logs nginx

# Database logs
docker-compose -f docker-compose.production.yml logs db
```

### Service Restart
```bash
# Bitta serviceni restart qilish
docker-compose -f docker-compose.production.yml restart wordpress

# Barcha servicelarni restart qilish
docker-compose -f docker-compose.production.yml restart
```

### Debug Mode
```bash
# Debug mode yoqish (.env da)
WP_DEBUG=true

# Container rebuild qilish
docker-compose -f docker-compose.production.yml up -d --build wordpress
```

## 📱 Foydali Komandalar

```bash
# WordPress CLI ishlatish
docker-compose -f docker-compose.production.yml exec wordpress wp --info

# Database backup qilish
docker-compose -f docker-compose.production.yml exec db mysqldump -u root -p wordpress | gzip > backup.sql.gz

# SSL sertifikatni yangilash
docker-compose -f docker-compose.production.yml run --rm certbot renew

# Container resource usage
docker stats

# Disk usage
df -h
du -sh /opt/wordpress/
```

## 🔒 Security Checklist

- [ ] Server firewall (UFW) yoqilgan
- [ ] Fail2ban SSH himoyasi sozlangan
- [ ] SSL sertifikat o'rnatilgan va avtomatik yangilanadi
- [ ] WordPress admin file editing o'chirilgan
- [ ] Database root parol o'zgartirilgan
- [ ] WordPress salts yangilangan
- [ ] File permissions to'g'ri o'rnatilgan
- [ ] Backup muntazam olinmoqda
- [ ] Monitoring sozlangan

## 📞 Yordam

Agar qiyinchiliklar bo'lsa:

1. **Loglarni tekshiring:** `docker-compose logs -f`
2. **Health check qiling:** `curl -f https://your-domain.com/nginx-health`
3. **Container statusini ko'ring:** `docker-compose ps`
4. **Monitoring skriptni ishga tushiring:** `./scripts/monitor.sh`

## 🎉 Muvaffaqiyat!

Loyihangiz production muhitida ishga tushdi! 

- **Website:** https://your-domain.com
- **Admin:** https://your-domain.com/wp-admin/
- **Performance:** Optimizatsiya va caching yoqilgan
- **Security:** Xavfsizlik choralari qo'llanilgan
- **Monitoring:** Avtomatik monitoring ishlaydi
- **Backup:** Kunlik backup avtomatik olinadi

**Omad tilaymiz!** 🚀
