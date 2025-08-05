#!/bin/bash

# Database bazasini to'liq tayyorlash va WordPress ishga tushirish skripti
# GreenMetric WordPress Production Setup

echo "=== GreenMetric WordPress Production Setup ==="
echo "Sana: $(date)"

# Loyihaning ildiz katalogiga o'tish
cd /var/www/green-metric-wordpress

# 1. Barcha containerlarni to'xtatish va tozalash
echo "1. Mavjud containerlarni to'xtatish..."
docker-compose -f docker-compose.production.yml down --volumes --remove-orphans

# Docker tizimini tozalash
echo "2. Docker tizimini tozalash..."
docker system prune -f
docker volume prune -f

# 3. Environment o'zgaruvchilarini export qilish
echo "3. Environment o'zgaruvchilarini yuklash..."
if [ -f .env ]; then
    export $(cat .env | grep -v '^#' | xargs)
    echo "✓ .env fayli yuklandi"
else
    echo "⚠ .env fayli topilmadi, standart qiymatlar ishlatiladi"
fi

# 4. Kerakli kataloglarni yaratish
echo "4. Kerakli kataloglarni yaratish..."
mkdir -p mysql/conf.d
mkdir -p nginx/conf.d  
mkdir -p nginx/logs

# 5. MySQL containerini birinchi bo'lib ishga tushirish
echo "5. MySQL containerini ishga tushirish..."
docker-compose -f docker-compose.production.yml up -d db

# MySQL ishga tushishini kutish
echo "6. MySQL ishga tushishini kutish (45 soniya)..."
sleep 15

# MySQL health check
echo "7. MySQL holatini tekshirish..."
for i in {1..30}; do
    if docker-compose -f docker-compose.production.yml exec -T db mysqladmin ping -h localhost -u root -p${MYSQL_ROOT_PASSWORD:-GreenMetric2024Root!} --silent; then
        echo "✓ MySQL tayyor!"
        break
    else
        echo "⏳ MySQL kutilmoqda... ($i/30)"
        sleep 2
    fi
done

# MySQL loglarini ko'rsatish
echo "8. MySQL loglarini tekshirish..."
docker-compose -f docker-compose.production.yml logs db --tail=10

# 9. Redis containerini ishga tushirish
echo "9. Redis containerini ishga tushirish..."
docker-compose -f docker-compose.production.yml up -d redis

# 10 soniya kutish
sleep 10

# 10. WordPress containerini ishga tushirish
echo "10. WordPress containerini ishga tushirish..."
docker-compose -f docker-compose.production.yml up -d wordpress

# WordPress ishga tushishini kutish
echo "11. WordPress ishga tushishini kutish (30 soniya)..."
sleep 30

# WordPress loglarini ko'rsatish
echo "12. WordPress loglarini tekshirish..."
docker-compose -f docker-compose.production.yml logs wordpress --tail=10

# 13. Nginx containerini ishga tushirish
echo "13. Nginx containerini ishga tushirish..."
docker-compose -f docker-compose.production.yml up -d nginx

# 15 soniya kutish
sleep 15

# 14. Barcha konteynerlar holatini tekshirish
echo "14. Barcha konteynerlar holati:"
docker-compose -f docker-compose.production.yml ps

# 15. Database ulanishini tekshirish
echo "15. Database ulanishini tekshirish..."
docker-compose -f docker-compose.production.yml exec -T wordpress php -r "
\$host = getenv('WORDPRESS_DB_HOST') ?: 'db:3306';
\$dbname = getenv('WORDPRESS_DB_NAME') ?: 'greenmetric_wp';
\$user = getenv('WORDPRESS_DB_USER') ?: 'wp_user';
\$pass = getenv('WORDPRESS_DB_PASSWORD') ?: 'WpPass2024!';

try {
    \$pdo = new PDO('mysql:host=' . \$host . ';dbname=' . \$dbname, \$user, \$pass);
    echo '✓ Database ulanishi muvaffaqiyatli!' . PHP_EOL;
    echo 'Database nomi: ' . \$dbname . PHP_EOL;
    echo 'Foydalanuvchi: ' . \$user . PHP_EOL;
} catch(PDOException \$e) {
    echo '✗ Database ulanish xatosi: ' . \$e->getMessage() . PHP_EOL;
}
"

# 16. Web saytni tekshirish
echo "16. Web saytni tekshirish..."

# Local test
echo "Local test (localhost):"
curl -I http://localhost 2>/dev/null | head -n 5

echo ""
echo "External test (greenmetric.nspi.uz):"
curl -I http://greenmetric.nspi.uz 2>/dev/null | head -n 5

# 17. Yakuniy natija
echo ""
echo "=== YAKUNIY NATIJA ==="
echo "Barcha konteynerlar holati:"
docker-compose -f docker-compose.production.yml ps

echo ""
echo "Web sayt manzillari:"
echo "- Local: http://localhost"
echo "- Domain: http://greenmetric.nspi.uz"
echo ""
echo "WordPress admin:"
echo "- URL: http://greenmetric.nspi.uz/wp-admin"
echo ""
echo "Database ma'lumotlari:"
echo "- Host: db:3306"
echo "- Database: ${MYSQL_DATABASE:-greenmetric_wp}"
echo "- User: ${MYSQL_USER:-wp_user}"
echo ""
echo "Agar sayt ishlamasa, quyidagi buyruqlar bilan tekshiring:"
echo "docker-compose -f docker-compose.production.yml logs wordpress"
echo "docker-compose -f docker-compose.production.yml logs db"
echo "docker-compose -f docker-compose.production.yml logs nginx"

echo ""
echo "Setup yakunlandi! $(date)"
