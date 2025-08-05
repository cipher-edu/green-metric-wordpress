#!/bin/bash
set -euo pipefail

# Function to log messages
log() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') [ENTRYPOINT] $*"
}

log "Starting WordPress production container..."

# Wait for database to be ready
log "Waiting for database connection..."
while ! mysql -h"$WORDPRESS_DB_HOST" -u"$WORDPRESS_DB_USER" -p"$WORDPRESS_DB_PASSWORD" -e "SELECT 1" >/dev/null 2>&1; do
    log "Database not ready, waiting..."
    sleep 2
done
log "Database connection successful!"

# Set proper permissions
log "Setting file permissions..."
chown -R www-data:www-data /var/www/html
find /var/www/html -type d -exec chmod 755 {} \;
find /var/www/html -type f -exec chmod 644 {} \;
chmod -R 775 /var/www/html/wp-content

# Install WordPress if not already installed
if ! wp core is-installed --path=/var/www/html --allow-root 2>/dev/null; then
    log "WordPress not installed, setting up..."
    
    # Download WordPress core if needed
    if [ ! -f /var/www/html/wp-config.php ]; then
        log "Downloading WordPress core..."
        wp core download --path=/var/www/html --allow-root
    fi
    
    # Create wp-config.php if not exists
    if [ ! -f /var/www/html/wp-config.php ]; then
        log "Creating wp-config.php..."
        wp config create \
            --dbname="$WORDPRESS_DB_NAME" \
            --dbuser="$WORDPRESS_DB_USER" \
            --dbpass="$WORDPRESS_DB_PASSWORD" \
            --dbhost="$WORDPRESS_DB_HOST" \
            --path=/var/www/html \
            --allow-root
    fi
else
    log "WordPress already installed, continuing..."
fi

# Create uploads directory if not exists
mkdir -p /var/www/html/wp-content/uploads
chown -R www-data:www-data /var/www/html/wp-content/uploads
chmod -R 775 /var/www/html/wp-content/uploads

# Install Redis Object Cache plugin if Redis is available
if nc -z redis 6379 2>/dev/null; then
    log "Redis detected, configuring object cache..."
    if ! wp plugin is-installed redis-cache --path=/var/www/html --allow-root 2>/dev/null; then
        wp plugin install redis-cache --activate --path=/var/www/html --allow-root
    fi
    wp redis enable --path=/var/www/html --allow-root 2>/dev/null || true
fi

# Flush rewrite rules
log "Flushing rewrite rules..."
wp rewrite flush --path=/var/www/html --allow-root 2>/dev/null || true

# Update WordPress core and plugins (only security updates)
log "Checking for security updates..."
wp core update --minor --path=/var/www/html --allow-root 2>/dev/null || true
wp plugin update --all --path=/var/www/html --allow-root 2>/dev/null || true

log "WordPress setup complete, starting Apache..."

# Start the original entrypoint
exec docker-entrypoint.sh "$@"
