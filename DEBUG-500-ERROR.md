# DEBUG 500 INTERNAL SERVER ERROR

## Current Status
✅ All containers are running  
✅ Database connection is working  
❌ WordPress returning 500 Internal Server Error  

## Debug Commands for Server

```bash
# Check WordPress container logs
docker-compose -f docker-compose.production.yml logs wordpress --tail=50

# Check database connection from WordPress container
docker-compose -f docker-compose.production.yml exec wordpress wp db check --allow-root

# Check WordPress configuration
docker-compose -f docker-compose.production.yml exec wordpress cat /var/www/html/wp-config.php | head -20

# Check if WordPress files exist
docker-compose -f docker-compose.production.yml exec wordpress ls -la /var/www/html/

# Check PHP error logs
docker-compose -f docker-compose.production.yml exec wordpress cat /var/log/apache2/error.log 2>/dev/null || echo "No Apache error log"
docker-compose -f docker-compose.production.yml exec wordpress cat /usr/local/var/log/php_errors.log 2>/dev/null || echo "No PHP error log"

# Test database connection directly
docker-compose -f docker-compose.production.yml exec db mysql -u wp_user -pWpPass2024! greenmetric_wp -e "SHOW TABLES;"

# Check environment variables in WordPress container
docker-compose -f docker-compose.production.yml exec wordpress env | grep WORDPRESS

# Test simple PHP in WordPress container
docker-compose -f docker-compose.production.yml exec wordpress php -r "echo 'PHP is working: ' . phpversion() . '\n';"
```

## Likely Issues and Solutions

### 1. WordPress Configuration Problem
```bash
# Check if wp-config.php exists and has correct database settings
docker-compose -f docker-compose.production.yml exec wordpress cat /var/www/html/wp-config.php | grep DB_

# If wp-config.php is missing or incorrect, recreate it:
docker-compose -f docker-compose.production.yml exec wordpress wp config create \
  --dbname=greenmetric_wp \
  --dbuser=wp_user \
  --dbpass=WpPass2024! \
  --dbhost=db:3306 \
  --allow-root
```

### 2. WordPress Not Installed
```bash
# Check if WordPress is installed
docker-compose -f docker-compose.production.yml exec wordpress wp core is-installed --allow-root

# If not installed, install WordPress:
docker-compose -f docker-compose.production.yml exec wordpress wp core install \
  --url=http://greenmetric.nspi.uz \
  --title="Green Metric" \
  --admin_user=admin \
  --admin_password=AdminPass2024! \
  --admin_email=admin@greenmetric.nspi.uz \
  --allow-root
```

### 3. File Permissions Issue
```bash
# Fix WordPress file permissions
docker-compose -f docker-compose.production.yml exec wordpress chown -R www-data:www-data /var/www/html
docker-compose -f docker-compose.production.yml exec wordpress chmod -R 755 /var/www/html
```

### 4. Environment Variable Mismatch
The issue might be environment variable names. I notice in your docker-compose.yml:

WordPress expects:
- `WORDPRESS_DB_NAME`
- `WORDPRESS_DB_USER` 
- `WORDPRESS_DB_PASSWORD`

But your .env.production has:
- `MYSQL_DATABASE`
- `MYSQL_USER`
- `MYSQL_PASSWORD`

## Quick Fix Commands

```bash
# Update .env.production to match WordPress expectations
cat > .env.production << 'EOF'
# MySQL Database Settings
MYSQL_ROOT_PASSWORD=GreenMetric2024Root!
MYSQL_DATABASE=greenmetric_wp
MYSQL_USER=wp_user
MYSQL_PASSWORD=WpPass2024!

# WordPress Settings (matching the variable names)
WORDPRESS_DB_NAME=greenmetric_wp
WORDPRESS_DB_USER=wp_user
WORDPRESS_DB_PASSWORD=WpPass2024!
WORDPRESS_DB_HOST=db:3306
EOF

# Reload environment and restart WordPress
export $(cat .env.production | grep -v '^#' | xargs)
docker-compose -f docker-compose.production.yml restart wordpress

# Wait and test
sleep 10
curl -I http://greenmetric.nspi.uz/
```

## Expected Results
After running the debug commands, you should see:
- WordPress logs showing the specific error
- Database connection status
- Whether WordPress is properly installed
- If file permissions are correct

Run the WordPress logs command first to see the exact error message.
