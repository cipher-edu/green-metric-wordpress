# 🎯 FINAL PRODUCTION FIX

## ✅ Success Status
Your simple Docker setup worked perfectly! Getting 302 redirect to WordPress setup.

## ❌ Production Issues
Now getting 500 errors with production setup. Let's fix this permanently.

## 🚀 Complete Production Fix Commands

```bash
# 1. Stop production containers
cd /var/www/green-metric-wordpress
docker-compose -f docker-compose.production.yml down --volumes

# 2. Fix MySQL configuration (remove deprecated options)
cat > mysql/conf.d/mysql-performance.cnf << 'EOF'
[mysqld]
# Basic settings
max_connections=100
max_allowed_packet=128M
thread_cache_size=50
table_open_cache=2000

# InnoDB settings  
innodb_buffer_pool_size=256M
innodb_log_file_size=64M
innodb_flush_method=O_DIRECT

# Authentication and charset
default-authentication-plugin=mysql_native_password
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci

# Network settings
bind-address=0.0.0.0
skip-name-resolve

[mysql]
default-character-set=utf8mb4

[client]
default-character-set=utf8mb4
EOF

# 3. Fix Nginx configuration (remove SSL for now)
cat > nginx/conf.d/wordpress.conf << 'EOF'
upstream wordpress_backend {
    server wordpress:80;
    keepalive 32;
}

server {
    listen 80;
    server_name greenmetric.nspi.uz www.greenmetric.nspi.uz;
    
    client_max_body_size 128M;
    client_body_timeout 60s;
    client_header_timeout 60s;
    keepalive_timeout 65s;
    send_timeout 60s;
    
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

# 4. Fix environment variables
cat > .env.production << 'EOF'
MYSQL_ROOT_PASSWORD=GreenMetric2024Root!
MYSQL_DATABASE=greenmetric_wp
MYSQL_USER=wp_user
MYSQL_PASSWORD=WpPass2024!
EOF

# 5. Create minimal production docker-compose (without SSL complications)
cat > docker-compose.production.yml << 'EOF'
version: '3.8'

services:
  # Nginx Reverse Proxy
  nginx:
    image: nginx:alpine
    container_name: nginx-proxy
    restart: unless-stopped
    ports:
      - "80:80"
    volumes:
      - ./nginx/conf.d:/etc/nginx/conf.d
      - ./nginx/logs:/var/log/nginx
    depends_on:
      - wordpress
    networks:
      - wordpress-network

  # WordPress Application
  wordpress:
    build: .
    container_name: wordpress-app
    restart: unless-stopped
    environment:
      WORDPRESS_DB_HOST: db:3306
      WORDPRESS_DB_NAME: ${MYSQL_DATABASE:-greenmetric_wp}
      WORDPRESS_DB_USER: ${MYSQL_USER:-wp_user}
      WORDPRESS_DB_PASSWORD: ${MYSQL_PASSWORD}
    volumes:
      - wordpress_data:/var/www/html
      - ./uploads.ini:/usr/local/etc/php/conf.d/uploads.ini
    depends_on:
      - db
      - redis
    networks:
      - wordpress-network

  # MySQL Database
  db:
    image: mysql:8.0
    container_name: wordpress-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: ${MYSQL_DATABASE:-greenmetric_wp}
      MYSQL_USER: ${MYSQL_USER:-wp_user}
      MYSQL_PASSWORD: ${MYSQL_PASSWORD}
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
    volumes:
      - db_data:/var/lib/mysql
      - ./mysql/conf.d:/etc/mysql/conf.d
    command: --default-authentication-plugin=mysql_native_password
    networks:
      - wordpress-network

  # Redis Cache
  redis:
    image: redis:7-alpine
    container_name: wordpress-redis
    restart: unless-stopped
    command: redis-server --appendonly yes --maxmemory 128mb --maxmemory-policy allkeys-lru
    volumes:
      - redis_data:/data
    networks:
      - wordpress-network

volumes:
  wordpress_data:
    driver: local
  db_data:
    driver: local
  redis_data:
    driver: local

networks:
  wordpress-network:
    driver: bridge
EOF

# 6. Load environment and start production
export $(cat .env.production | grep -v '^#' | xargs)

# Start database first
docker-compose -f docker-compose.production.yml up -d db
sleep 30

# Start WordPress
docker-compose -f docker-compose.production.yml up -d wordpress redis
sleep 15

# Start Nginx
docker-compose -f docker-compose.production.yml up -d nginx
sleep 10

# Check all services
docker-compose -f docker-compose.production.yml ps

# Test the site
curl -I http://greenmetric.nspi.uz/

# If you get a redirect (302), WordPress is working!
# Complete installation
echo "If you see 302 redirect, WordPress is working!"
echo "Go to: http://greenmetric.nspi.uz/wp-admin/install.php"
echo "Or run this to install via command line:"

docker-compose -f docker-compose.production.yml exec wordpress php -r "
if (!file_exists('/var/www/html/wp-config.php')) {
    copy('/var/www/html/wp-config-sample.php', '/var/www/html/wp-config.php');
    \$config = file_get_contents('/var/www/html/wp-config.php');
    \$config = str_replace('database_name_here', 'greenmetric_wp', \$config);
    \$config = str_replace('username_here', 'wp_user', \$config);
    \$config = str_replace('password_here', 'WpPass2024!', \$config);
    \$config = str_replace('localhost', 'db:3306', \$config);
    file_put_contents('/var/www/html/wp-config.php', \$config);
}

require_once('/var/www/html/wp-load.php');
require_once('/var/www/html/wp-admin/includes/upgrade.php');

if (!is_blog_installed()) {
    wp_install('Green Metric', 'admin', 'admin@greenmetric.nspi.uz', true, '', 'AdminPass2024!');
    echo 'WordPress installed!\nURL: http://greenmetric.nspi.uz\nAdmin: admin\nPassword: AdminPass2024!\n';
} else {
    echo 'WordPress already installed\n';
}
"
```

## 🔥 Key Changes Made:

1. **Removed deprecated MySQL options**: No more `query_cache_type`
2. **Simplified Nginx**: No SSL certificates required 
3. **Fixed environment variables**: Consistent naming
4. **Removed complex volumes**: Simplified volume mapping
5. **Sequential startup**: Database → WordPress → Nginx

## 🎯 Expected Result:
- **Database**: ✅ Starts without errors
- **WordPress**: ✅ Connects to database
- **Nginx**: ✅ Proxies requests
- **Site**: ✅ Returns 302 redirect (WordPress setup)

Run the commands above and you should get the same **302 redirect** that worked with the simple version!
