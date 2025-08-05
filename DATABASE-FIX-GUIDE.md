# ⚠️ Database Connection Error - Hal Qilish Bo'yicha Qo'llanma

## 🔍 Muammo Tahlili
"Error establishing a database connection" xatosi quyidagi sabablarga ko'ra yuzaga kelishi mumkin:

1. **Environment variables to'g'ri o'rnatilmagan**
2. **MySQL container ishlamayapti**
3. **Database parollari mos kelmayapti**

## 🔧 Hal Qilish Qadamlari

### 1. Containerlarni To'xtatish
```bash
cd /var/www/green-metric-wordpress
docker-compose -f docker-compose.production.yml down
```

### 2. Environment Faylini To'g'rilash
```bash
# .env.production faylini yaratish yoki tahrirlash
cat > .env.production << 'EOF'
# Database Configuration
MYSQL_ROOT_PASSWORD=greenmetric_root_2024
MYSQL_DATABASE=greenmetric_wp
MYSQL_USER=greenmetric_user
MYSQL_PASSWORD=greenmetric_pass_2024

# WordPress Database Settings
WORDPRESS_DB_HOST=db:3306
WORDPRESS_DB_NAME=greenmetric_wp
WORDPRESS_DB_USER=greenmetric_user
WORDPRESS_DB_PASSWORD=greenmetric_pass_2024

# Additional WordPress Settings
WORDPRESS_TABLE_PREFIX=gm_
WORDPRESS_DEBUG=false

# Security Keys (WordPress salts)
WORDPRESS_AUTH_KEY=put-your-unique-phrase-here-auth
WORDPRESS_SECURE_AUTH_KEY=put-your-unique-phrase-here-secure-auth
WORDPRESS_LOGGED_IN_KEY=put-your-unique-phrase-here-logged-in
WORDPRESS_NONCE_KEY=put-your-unique-phrase-here-nonce
WORDPRESS_AUTH_SALT=put-your-unique-phrase-here-auth-salt
WORDPRESS_SECURE_AUTH_SALT=put-your-unique-phrase-here-secure-auth-salt
WORDPRESS_LOGGED_IN_SALT=put-your-unique-phrase-here-logged-in-salt
WORDPRESS_NONCE_SALT=put-your-unique-phrase-here-nonce-salt

# Domain
DOMAIN=greenmetric.nspi.uz
EOF
```

### 3. WordPress Konfiguratsiyasini Yaratish
```bash
# wp-config-production.php faylini yangilash
cat > wp-config-production.php << 'EOF'
<?php
/**
 * Green Metric NSPI WordPress Production Configuration
 * Domain: greenmetric.nspi.uz
 */

// Database settings
define('DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'greenmetric_wp');
define('DB_USER', getenv('WORDPRESS_DB_USER') ?: 'greenmetric_user');
define('DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'greenmetric_pass_2024');
define('DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'db:3306');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// Table prefix
$table_prefix = getenv('WORDPRESS_TABLE_PREFIX') ?: 'gm_';

// Authentication Unique Keys and Salts
define('AUTH_KEY',         getenv('WORDPRESS_AUTH_KEY') ?: 'put-your-unique-phrase-here-auth');
define('SECURE_AUTH_KEY',  getenv('WORDPRESS_SECURE_AUTH_KEY') ?: 'put-your-unique-phrase-here-secure-auth');
define('LOGGED_IN_KEY',    getenv('WORDPRESS_LOGGED_IN_KEY') ?: 'put-your-unique-phrase-here-logged-in');
define('NONCE_KEY',        getenv('WORDPRESS_NONCE_KEY') ?: 'put-your-unique-phrase-here-nonce');
define('AUTH_SALT',        getenv('WORDPRESS_AUTH_SALT') ?: 'put-your-unique-phrase-here-auth-salt');
define('SECURE_AUTH_SALT', getenv('WORDPRESS_SECURE_AUTH_SALT') ?: 'put-your-unique-phrase-here-secure-auth-salt');
define('LOGGED_IN_SALT',   getenv('WORDPRESS_LOGGED_IN_SALT') ?: 'put-your-unique-phrase-here-logged-in-salt');
define('NONCE_SALT',       getenv('WORDPRESS_NONCE_SALT') ?: 'put-your-unique-phrase-here-nonce-salt');

// WordPress debugging
define('WP_DEBUG', getenv('WORDPRESS_DEBUG') === 'true');
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// WordPress URLs
define('WP_HOME', 'http://greenmetric.nspi.uz');
define('WP_SITEURL', 'http://greenmetric.nspi.uz');

// Force HTTPS (will be enabled after SSL setup)
// define('FORCE_SSL_ADMIN', true);

// File permissions
define('FS_METHOD', 'direct');

// Memory limit
define('WP_MEMORY_LIMIT', '512M');

// Cache settings
define('WP_CACHE', true);
define('WP_CACHE_KEY_SALT', 'greenmetric.nspi.uz');

// Redis Cache Configuration
define('WP_REDIS_HOST', 'redis');
define('WP_REDIS_PORT', 6379);
define('WP_REDIS_TIMEOUT', 1);
define('WP_REDIS_READ_TIMEOUT', 1);
define('WP_REDIS_DATABASE', 0);

// Security enhancements
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', false);
define('AUTOMATIC_UPDATER_DISABLED', true);

// Increase timeouts
define('WP_HTTP_BLOCK_EXTERNAL', false);
define('WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,*.github.com');

// That's all, stop editing!
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

require_once(ABSPATH . 'wp-settings.php');
EOF
```

### 4. Vaqtincha HTTP-Only Nginx Konfiguratsiyasi
```bash
# SSL siz nginx konfiguratsiyasi
cat > nginx/conf.d/wordpress.conf << 'EOF'
# Rate limiting
limit_req_zone $binary_remote_addr zone=wp_login:10m rate=5r/m;
limit_req_zone $binary_remote_addr zone=wp_admin:10m rate=10r/m;
limit_req_zone $binary_remote_addr zone=wp_general:10m rate=30r/m;

# Upstream for WordPress
upstream wordpress_backend {
    server wordpress:80;
    keepalive 32;
}

# HTTP server (temporary, until SSL is configured)
server {
    listen 80;
    server_name greenmetric.nspi.uz www.greenmetric.nspi.uz;
    
    # Basic Settings
    client_max_body_size 128M;
    client_body_timeout 60s;
    client_header_timeout 60s;
    keepalive_timeout 65s;
    send_timeout 60s;
    
    # Security Headers
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    
    # Static files caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|pdf|txt)$ {
        proxy_pass http://wordpress_backend;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }
    
    # WordPress wp-login.php protection
    location = /wp-login.php {
        limit_req zone=wp_login burst=5 nodelay;
        
        proxy_pass http://wordpress_backend;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
    
    # WordPress admin area
    location ~* ^/wp-admin/ {
        limit_req zone=wp_admin burst=20 nodelay;
        
        proxy_pass http://wordpress_backend;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
    
    # Block access to sensitive files
    location ~* /(?:uploads|files)/.*\.php$ {
        deny all;
    }
    
    location ~* ^/(wp-config\.php|wp-config-sample\.php|readme\.html|license\.txt) {
        deny all;
    }
    
    location ~ /\. {
        deny all;
    }
    
    # Main location
    location / {
        limit_req zone=wp_general burst=50 nodelay;
        
        proxy_pass http://wordpress_backend;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        
        proxy_connect_timeout 60s;
        proxy_send_timeout 60s;
        proxy_read_timeout 60s;
    }
    
    # Health check
    location /nginx-health {
        access_log off;
        return 200 "healthy\n";
        add_header Content-Type text/plain;
    }
}
EOF
```

### 5. Database Volumelarni Tozalash
```bash
# Eski database volumelarni o'chirish (barcha ma'lumotlar yo'qoladi!)
docker volume rm green-metric-wordpress_db_data 2>/dev/null || true
docker volume rm green-metric-wordpress_wordpress_data 2>/dev/null || true
docker volume rm green-metric-wordpress_redis_data 2>/dev/null || true
```

### 6. Qayta Ishga Tushirish
```bash
# Environment faylini export qilish
export $(cat .env.production | grep -v '^#' | xargs)

# Containerlarni qayta ishga tushirish
docker-compose -f docker-compose.production.yml up -d
```

### 7. Tekshirish
```bash
# Container holatini ko'rish
docker-compose -f docker-compose.production.yml ps

# Database containerini tekshirish
docker-compose -f docker-compose.production.yml logs db

# WordPress containerini tekshirish
docker-compose -f docker-compose.production.yml logs wordpress
```

### 8. Saytni Tekshirish
```bash
# Sayt javob berishini tekshirish
curl -I http://greenmetric.nspi.uz

# Agar ishlamasa, localhost orqali tekshiring
curl -I http://localhost
```

## 🔍 Muammoni Diagnostika Qilish

### Database Connection Test
```bash
# MySQL containeriga ulanish
docker-compose -f docker-compose.production.yml exec db mysql -u greenmetric_user -p greenmetric_wp

# WordPress containerida database testini
docker-compose -f docker-compose.production.yml exec wordpress php -r "
\$connection = new mysqli('db', 'greenmetric_user', 'greenmetric_pass_2024', 'greenmetric_wp');
if (\$connection->connect_error) {
    echo 'Connection failed: ' . \$connection->connect_error . PHP_EOL;
} else {
    echo 'Database connection successful!' . PHP_EOL;
    \$connection->close();
}
"
```

Ushbu barcha qadamlarni ketma-ket bajaring va natijani xabar bering!
