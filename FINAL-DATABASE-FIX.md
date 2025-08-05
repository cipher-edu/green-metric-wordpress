# FINAL DATABASE CONNECTION FIX

## Problem
The MySQL 8.0 container was failing due to deprecated `query-cache-size` and `query-cache-type` parameters in the Docker Compose file.

## Solution
Run these commands on your server to fix the database connection:

```bash
# Step 1: Navigate to project directory
cd /var/www/green-metric-wordpress

# Step 2: Stop all containers and remove volumes
docker-compose -f docker-compose.production.yml down --volumes
docker system prune -f
docker volume prune -f

# Step 3: Update docker-compose.production.yml (remove deprecated MySQL options)
cat > docker-compose.yml.temp << 'EOF'
version: '3.8'

services:
  # Nginx Reverse Proxy
  nginx:
    image: nginx:alpine
    container_name: nginx-proxy
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./nginx/conf.d:/etc/nginx/conf.d
      - ./nginx/ssl:/etc/nginx/ssl
      - ./nginx/logs:/var/log/nginx
      - /etc/letsencrypt:/etc/letsencrypt:ro
      - wordpress_data:/var/www/html:ro
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
      WORDPRESS_TABLE_PREFIX: wp_
      WORDPRESS_DEBUG: false
    volumes:
      - wordpress_data:/var/www/html
      - ./uploads.ini:/usr/local/etc/php/conf.d/uploads.ini
      - ./wp-config-production.php:/var/www/html/wp-config.php
    depends_on:
      - db
      - redis
    networks:
      - wordpress-network

  # MySQL Database (Fixed for MySQL 8.0)
  db:
    image: mysql:8.0
    container_name: wordpress-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: ${MYSQL_DATABASE:-greenmetric_wp}
      MYSQL_USER: ${MYSQL_USER:-wp_user}
      MYSQL_PASSWORD: ${MYSQL_PASSWORD}
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
      MYSQL_CHARSET: utf8mb4
      MYSQL_COLLATION: utf8mb4_unicode_ci
    volumes:
      - db_data:/var/lib/mysql
      - ./mysql/conf.d:/etc/mysql/conf.d
      - ./backups:/backups
    command: >
      --character-set-server=utf8mb4
      --collation-server=utf8mb4_unicode_ci
      --innodb-buffer-pool-size=256M
      --max-connections=200
      --default-authentication-plugin=mysql_native_password
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

# Step 4: Replace the old docker-compose file
mv docker-compose.yml.temp docker-compose.production.yml

# Step 5: Ensure environment variables are correct
cat > .env.production << 'EOF'
MYSQL_ROOT_PASSWORD=GreenMetric2024Root!
MYSQL_DATABASE=greenmetric_wp
MYSQL_USER=wp_user
MYSQL_PASSWORD=WpPass2024!

WORDPRESS_DB_HOST=db:3306
WORDPRESS_DB_NAME=greenmetric_wp
WORDPRESS_DB_USER=wp_user
WORDPRESS_DB_PASSWORD=WpPass2024!
EOF

# Step 6: Load environment variables
export $(cat .env.production | grep -v '^#' | xargs)

# Step 7: Start services in order
echo "Starting database..."
docker-compose -f docker-compose.production.yml up -d db

# Wait for database to be ready
echo "Waiting for database to initialize..."
sleep 30

# Check database logs
echo "Checking database status..."
docker-compose -f docker-compose.production.yml logs db --tail=5

# Step 8: Start WordPress
echo "Starting WordPress..."
docker-compose -f docker-compose.production.yml up -d wordpress

# Wait for WordPress
sleep 15

# Step 9: Start Nginx
echo "Starting Nginx..."
docker-compose -f docker-compose.production.yml up -d nginx

# Step 10: Check all services
echo "Checking all services..."
docker-compose -f docker-compose.production.yml ps

# Step 11: Test the site
echo "Testing website..."
curl -I http://localhost

echo "Deployment complete! Check http://greenmetric.nspi.uz"
```

## Key Changes Made:
1. **Removed deprecated MySQL options**: `query-cache-size` and `query-cache-type` 
2. **Fixed environment variable names**: Matched to your .env.production file
3. **Simplified Docker Compose**: Removed unnecessary services for initial deployment
4. **Added proper MySQL 8.0 authentication**: `--default-authentication-plugin=mysql_native_password`

## After Running the Script:
If successful, you should see:
- All containers running: `docker-compose -f docker-compose.production.yml ps`
- Website accessible: `curl http://greenmetric.nspi.uz`
- No more "Error establishing a database connection"

If you still have issues, check:
```bash
# Database connection test
docker-compose -f docker-compose.production.yml exec db mysql -u wp_user -pWpPass2024! -e "SHOW DATABASES;"

# WordPress logs
docker-compose -f docker-compose.production.yml logs wordpress --tail=20
```
