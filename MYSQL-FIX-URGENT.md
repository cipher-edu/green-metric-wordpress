# 🚨 MySQL Container Muammosi va Tezkor Yechimlari

## Hozirgi holat: MySQL container restarting va ulanmayapti

### Tezkor Yechim - Serverda bajaring:

```bash
# 1. Barcha containerlarni to'xtatish
docker-compose -f docker-compose.production.yml down

# 2. MySQL volumelarini butunlay o'chirish
docker volume rm green-metric-wordpress_db_data 2>/dev/null || true
docker volume prune -f

# 3. MySQL konfiguratsiyasini yangilash
cat > mysql/conf.d/mysql-performance.cnf << 'EOF'  
[mysqld]
default-authentication-plugin=mysql_native_password
skip-name-resolve
skip-host-cache

# Basic settings
max_connections=100
thread_cache_size=50
table_open_cache=2000
tmp_table_size=64M
max_heap_table_size=64M

# InnoDB settings  
innodb_buffer_pool_size=256M
innodb_flush_method=O_DIRECT
innodb_lock_wait_timeout=120

# Disable deprecated features
sql_mode='STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO'

[mysql]
default-character-set=utf8mb4

[client] 
default-character-set=utf8mb4
EOF

# 4. Vaqtincha Nginx ni HTTP-only rejimiga o'tkazish
cat > nginx/conf.d/wordpress.conf << 'EOF'
upstream wordpress_backend {
    server wordpress:80;
    keepalive 32;
}

server {
    listen 80;
    server_name greenmetric.nspi.uz www.greenmetric.nspi.uz;
    
    client_max_body_size 128M;
    
    location / {
        proxy_pass http://wordpress_backend;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_Set_header X-Forwarded-Proto $scheme;
        
        proxy_connect_timeout 60s;
        proxy_send_timeout 60s;
        proxy_read_timeout 60s;
    }
    
    location /nginx-health {
        access_log off;
        return 200 "healthy\n";
        add_header Content-Type text/plain;
    }
}
EOF

# 5. Environment faylini tekshirish/yaratish
cat > .env.production << 'EOF'
MYSQL_ROOT_PASSWORD=greenmetric_root_2024
MYSQL_DATABASE=greenmetric_wp
MYSQL_USER=greenmetric_user
MYSQL_PASSWORD=greenmetric_pass_2024

WORDPRESS_DB_HOST=db:3306
WORDPRESS_DB_NAME=greenmetric_wp
WORDPRESS_DB_USER=greenmetric_user
WORDPRESS_DB_PASSWORD=greenmetric_pass_2024
EOF

# 6. Environment o'zgaruvchilarini yuklash
export $(cat .env.production | grep -v '^#' | xargs)

# 7. Faqat database containerini ishga tushirish
docker-compose -f docker-compose.production.yml up -d db

# 8. Database loglarini kuzatish (30 soniya)
echo "Database loglarini kuzatamiz..."
timeout 30s docker-compose -f docker-compose.production.yml logs -f db

# 9. Database holatini tekshirish
docker-compose -f docker-compose.production.yml ps

# 10. Agar database OK bo'lsa, qolgan xizmatlarni ham ishga tushirish
if docker-compose -f docker-compose.production.yml exec -T db mysqladmin ping -h localhost --silent; then
    echo "✅ Database ishlamoqda! Qolgan containerlarni ishga tushiramiz..."
    docker-compose -f docker-compose.production.yml up -d
else
    echo "❌ Database hali ham ishlamayapti. Loglarni tekshiring."
fi
```

### Diagnostika buyruqlari:

```bash
# Container holatini ko'rish
docker-compose -f docker-compose.production.yml ps

# Database specific loglarni ko'rish
docker-compose -f docker-compose.production.yml logs db --tail=50

# System resourcelarini tekshirish
free -h
df -h

# Docker system ma'lumoti
docker system df
docker system prune -f
```

### Alternativ yechim - PostgreSQL ga o'tish:

Agar MySQL bilan muammo davom etsa, PostgreSQL ishlatishni taklif qilaman:

```bash
# docker-compose.production.yml da db xizmatini PostgreSQL ga o'zgartirish
# Bu yerda PostgreSQL konfiguratsiyasi bo'lishi mumkin
```

**ESLATMA:** Yuqoridagi buyruqlarni ketma-ket bajaring va har qadamdan keyin natijani xabar bering!
