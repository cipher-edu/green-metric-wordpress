# Green Metric NSPI - WordPress Production Deployment

🌱 **Green Metric NSPI** loyihasi uchun production-ready WordPress deployment.

## 🌐 Loyiha Ma'lumotlari

- **Domain:** https://greenmetric.nspi.uz
- **Admin Panel:** https://greenmetric.nspi.uz/wp-admin/
- **Server IP:** 167.86.90.91
- **Technology Stack:** WordPress + Docker + Nginx + MySQL + Redis

## Loyihani ishga tushurish

### Talablar
- Docker Desktop (Windows uchun)
- Docker Compose

### Qadamlar

1. **Docker konteynerlarini ishga tushurish:**
   ```bash
   docker-compose up -d
   ```

2. **Brauzerda ochish:**
   - WordPress: http://localhost:8080
   - PhpMyAdmin: http://localhost:8081

### Xizmatlar

- **WordPress**: Port 8080da ishlaydi
- **MySQL Database**: Port 3306da ishlaydi
- **PhpMyAdmin**: Port 8081da ishlaydi (ma'lumotlar bazasini boshqarish uchun)

### Ma'lumotlar bazasi ma'lumotlari

- **Host**: db
- **Database**: wordpress
- **Username**: wordpress
- **Password**: wordpress_password
- **Root Password**: root_password

### PHP sozlamalari (Plugin yuklash uchun optimallashtirilgan)

- **Memory Limit**: 512M
- **Upload Max Filesize**: 128M
- **Post Max Size**: 128M
- **Max Execution Time**: 600 sekund
- **Max Input Vars**: 3000

### Plugin yuklash muammolarini hal qilish

Agar plugin yuklashda muammo bo'lsa:

1. **Fayl ruxsatlari**: wp-content jildi 775 ruxsat bilan sozlangan
2. **PHP limitlari**: Yuqori limitlar o'rnatilgan
3. **Apache konfiguratsiyasi**: .htaccess orqali sozlangan
4. **WordPress konfiguratsiyasi**: FS_METHOD 'direct' ga o'rnatilgan

### Foydali buyruqlar

```bash
# Konteynerlarni ishga tushurish
docker-compose up -d

# Konteynerlarni to'xtatish
docker-compose down

# Loglarni ko'rish
docker-compose logs -f

# Ma'lumotlar bazasini ham o'chirish
docker-compose down -v

# Konteynerlarni qayta build qilish
docker-compose up --build -d

# WordPress konteyneriga kirish
docker exec -it inkubatsiya-wordpress-1 bash

# PHP konfiguratsiyasini tekshirish
docker exec inkubatsiya-wordpress-1 php -r "echo 'Memory: ' . ini_get('memory_limit') . PHP_EOL;"
```

### Debugging

WordPress debug rejimi yoqilgan va loglar `wp-content/debug.log` faylida saqlanadi:

```bash
# Debug loglarni ko'rish
docker exec inkubatsiya-wordpress-1 tail -f /var/www/html/wp-content/debug.log
```

### Fayllar va jildlar

- `wp-content/` - WordPress mavzulari, plaginlari va yuklangan fayllar
- `wp-config.php` - WordPress konfiguratsiya fayli
- `docker-compose.yml` - Docker Compose konfiguratsiyasi
- `Dockerfile` - WordPress konteyner konfiguratsiyasi
- `.htaccess` - Apache rewrite va PHP sozlamalari

### Ishlab chiqish

WordPress fayllari o'zgartirilganda avtomatik ravishda konteynerda yangilanadi, chunki volume orqali bog'langan.

### Xavfsizlik

Production muhitida quyidagi sozlamalarni o'zgartiring:
- `wp-config.php`dagi AUTH_KEY va boshqa salt kalit so'zlarini
- Ma'lumotlar bazasi parollarini
- `WP_DEBUG`ni false qiling

### Plugin yuklash bo'yicha maslahatlar

1. **ZIP orqali yuklash**: Plugin ZIP faylini Admin > Plugins > Add New > Upload Plugin orqali yuklang
2. **Direkt o'rnatish**: WordPress admin panelidan to'g'ridan-to'g'ri plaginlarni qidiring va o'rnating
3. **Manual o'rnatish**: Plugin fayllarini `wp-content/plugins/` jildiga nusxalang
