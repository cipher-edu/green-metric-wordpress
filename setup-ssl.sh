#!/bin/bash

# SSL Certificate Setup Script
# This script obtains SSL certificates using Let's Encrypt

set -euo pipefail

# Configuration
DOMAIN=${DOMAIN_NAME:-"greenmetric.nspi.uz"}
EMAIL=${SSL_EMAIL:-"admin@greenmetric.nspi.uz"}

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

log() {
    echo -e "${GREEN}$(date '+%Y-%m-%d %H:%M:%S') [SSL]${NC} $*"
}

warn() {
    echo -e "${YELLOW}$(date '+%Y-%m-%d %H:%M:%S') [WARN]${NC} $*"
}

error() {
    echo -e "${RED}$(date '+%Y-%m-%d %H:%M:%S') [ERROR]${NC} $*"
}

log "Starting SSL certificate setup for domain: $DOMAIN"

# Check if domain is accessible
log "Checking domain accessibility..."
if ! curl -s -o /dev/null -w "%{http_code}" http://$DOMAIN | grep -q "200\|301\|302"; then
    warn "Domain $DOMAIN is not accessible. Make sure:"
    echo "1. Domain DNS points to your server IP"
    echo "2. Nginx is running and configured"
    echo "3. Firewall allows HTTP/HTTPS traffic"
    read -p "Continue anyway? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Obtain SSL certificate
log "Obtaining SSL certificate from Let's Encrypt..."
docker-compose -f docker-compose.production.yml run --rm certbot certonly \
    --webroot \
    --webroot-path=/var/www/certbot \
    --email "$EMAIL" \
    --agree-tos \
    --no-eff-email \
    -d "$DOMAIN" \
    -d "www.$DOMAIN"

if [ $? -eq 0 ]; then
    log "SSL certificate obtained successfully!"
    
    # Test certificate renewal
    log "Testing certificate renewal..."
    docker-compose -f docker-compose.production.yml run --rm certbot renew --dry-run
    
    # Create renewal cron job
    log "Setting up automatic renewal..."
    (crontab -l 2>/dev/null; echo "0 12 * * * cd $(pwd) && docker-compose -f docker-compose.production.yml run --rm certbot renew --quiet") | crontab -
    
    log "SSL setup completed successfully!"
    log "Certificate will auto-renew via cron job"
    
    # Restart nginx to use new certificate
    log "Restarting Nginx to apply SSL certificate..."
    docker-compose -f docker-compose.production.yml restart nginx
    
else
    error "Failed to obtain SSL certificate"
    exit 1
fi

# Verify SSL certificate
log "Verifying SSL certificate..."
if openssl s_client -connect $DOMAIN:443 -servername $DOMAIN < /dev/null 2>/dev/null | openssl x509 -noout -dates; then
    log "SSL certificate is valid and active"
else
    warn "Could not verify SSL certificate"
fi

log "SSL setup completed!"
echo ""
echo "Your website should now be accessible at:"
echo "https://$DOMAIN"
echo "https://www.$DOMAIN"
