# URGENT: Database Connection Error Fix

## Hozirgi muammo: 
"Error establishing a database connection" xatosi

## Tezkor yechim - Serverda quyidagi buyruqlarni bajaring:

### 1. Barcha containerlarni to'xtatish
```bash
cd /var/www/green-metric-wordpress
docker-compose -f docker-compose.production.yml down --volumes
```

### 2. Docker tizimini tozalash
```bash
docker system prune -f
docker volume prune -f
```

### 3. MySQL konfiguratsiyasini butunlay yangilash
```bash
mkdir -p mysql/conf.d
cat > mysql/conf.d/mysql-performance.cnf << 'EOF'
[mysqld]
# Authentication
default-authentication-plugin=mysql_native_password

# Network settings
skip-name-resolve
skip-host-cache
bind-address=0.0.0.0

# Basic settings
max_connections=100
max_allowed_packet=128M
thread_cache_size=50
table_open_cache=2000
tmp_table_size=64M
max_heap_table_size=64M

# InnoDB settings
innodb_buffer_pool_size=256M
innodb_log_file_size=64M
innodb_flush_method=O_DIRECT
innodb_lock_wait_timeout=120
innodb_file_per_table=1
innodb_flush_log_at_trx_commit=2

# Character sets
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci

# Logging
slow_query_log=1
long_query_time=2
log_error_verbosity=2

[mysql]
default-character-set=utf8mb4

[client]
default-character-set=utf8mb4
EOF
```

### 4. Environment faylini to'g'ri sozlash
```bash
cat > .env.production << 'EOF'
# MySQL Database Settings
MYSQL_ROOT_PASSWORD=GreenMetric2024Root!
MYSQL_DATABASE=greenmetric_wp
MYSQL_USER=wp_user
MYSQL_PASSWORD=WpPass2024!

# WordPress Settings
WORDPRESS_DB_HOST=db:3306
WORDPRESS_DB_NAME=greenmetric_wp
WORDPRESS_DB_USER=wp_user
WORDPRESS_DB_PASSWORD=WpPass2024!

# WordPress Configuration
WORDPRESS_TABLE_PREFIX=gm_
WORDPRESS_DEBUG=false

# Domain
DOMAIN=greenmetric.nspi.uz
EOF
```

### 5. Nginx konfiguratsiyasini soddalashtirish (SSL siz)
```bash
cat > nginx/conf.d/wordpress.conf << 'EOF'
upstream wordpress_backend {
    server wordpress:80;
    keepalive 32;
}

server {
    listen 80;
    server_name greenmetric.nspi.uz www.greenmetric.nspi.uz;
    
    client_max_body_size 128M;
    client_body_timeout 120s;
    proxy_read_timeout 120s;
    
    location / {
        proxy_pass http://wordpress_backend;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        
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
```

### 6. WordPress konfiguratsiyasini yangilash
```bash
cat > wp-config-production.php << 'EOF'
<?php
// Database settings
define('DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'greenmetric_wp');
define('DB_USER', getenv('WORDPRESS_DB_USER') ?: 'wp_user');
define('DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'WpPass2024!');
define('DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'db:3306');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// Table prefix
$table_prefix = 'gm_';

// WordPress URLs
define('WP_HOME', 'http://greenmetric.nspi.uz');
define('WP_SITEURL', 'http://greenmetric.nspi.uz');

// Authentication keys
define('AUTH_KEY',         'put-your-unique-phrase-here-auth');
define('SECURE_AUTH_KEY',  'put-your-unique-phrase-here-secure-auth');
define('LOGGED_IN_KEY',    'put-your-unique-phrase-here-logged-in');
define('NONCE_KEY',        'put-your-unique-phrase-here-nonce');
define('AUTH_SALT',        'put-your-unique-phrase-here-auth-salt');
define('SECURE_AUTH_SALT', 'put-your-unique-phrase-here-secure-auth-salt');
define('LOGGED_IN_SALT',   'put-your-unique-phrase-here-logged-in-salt');
define('NONCE_SALT',       'put-your-unique-phrase-here-nonce-salt');

// Debug settings
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

// Security
define('DISALLOW_FILE_EDIT', true);
define('FS_METHOD', 'direct');

// Memory
define('WP_MEMORY_LIMIT', '512M');

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

require_once(ABSPATH . 'wp-settings.php');
EOF
```

### 7. Environment o'zgaruvchilarini yuklash va ishga tushirish
```bash
# Environment export qilish
export $(cat .env.production | grep -v '^#' | xargs)

# Containerlarni bosqichma-bosqich ishga tushirish
echo "Database containerini ishga tushirish..."
docker-compose -f docker-compose.production.yml up -d db

# 30 soniya kutish
sleep 30

# Database holatini tekshirish
docker-compose -f docker-compose.production.yml ps

# Database loglarini ko'rish
docker-compose -f docker-compose.production.yml logs db --tail=20

# Agar database ishlasa, WordPress ni ishga tushirish
echo "WordPress containerini ishga tushirish..."
docker-compose -f docker-compose.production.yml up -d wordpress

# 15 soniya kutish
sleep 15

# Nginx ni ishga tushirish
echo "Nginx containerini ishga tushirish..."
docker-compose -f docker-compose.production.yml up -d nginx

# Final holatni tekshirish
docker-compose -f docker-compose.production.yml ps
```

### 8. Saytni tekshirish
```bash
# Local test
curl -I http://localhost

# External test (agar DNS sozlangan bo'lsa)
curl -I http://greenmetric.nspi.uz
```

## Agar hali ham ishlamasa:

### MySQL 5.7 ga o'tkazish:
```bash
# docker-compose.production.yml da mysql:8.0 ni mysql:5.7 ga o'zgartirish
sed -i 's/mysql:8.0/mysql:5.7/g' docker-compose.production.yml
```

**Yuqoridagi barcha buyruqlarni ketma-ket bajaring va har qadamdan keyin natijani xabar bering!**
