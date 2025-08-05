#!/bin/bash

# WordPress Production Deployment Script
# Run this script on your production server

set -euo pipefail

# Configuration
SERVER_IP="167.86.90.91"
SERVER_USER="root"
PROJECT_DIR="/opt/wordpress"
DOMAIN="greenmetric.nspi.uz"  # Domain name
EMAIL="admin@greenmetric.nspi.uz"  # Admin email

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Logging function
log() {
    echo -e "${GREEN}$(date '+%Y-%m-%d %H:%M:%S') [DEPLOY]${NC} $*"
}

warn() {
    echo -e "${YELLOW}$(date '+%Y-%m-%d %H:%M:%S') [WARN]${NC} $*"
}

error() {
    echo -e "${RED}$(date '+%Y-%m-%d %H:%M:%S') [ERROR]${NC} $*"
}

# Check if running as root
if [ "$EUID" -ne 0 ]; then
    error "Please run this script as root"
    exit 1
fi

log "Starting WordPress production deployment..."

# Update system packages
log "Updating system packages..."
apt update && apt upgrade -y

# Install Docker and Docker Compose
log "Installing Docker and Docker Compose..."
if ! command -v docker &> /dev/null; then
    curl -fsSL https://get.docker.com -o get-docker.sh
    sh get-docker.sh
    systemctl enable docker
    systemctl start docker
    rm get-docker.sh
fi

if ! command -v docker-compose &> /dev/null; then
    curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    chmod +x /usr/local/bin/docker-compose
fi

# Install required packages
log "Installing required packages..."
apt install -y ufw fail2ban htop curl wget git nano

# Configure firewall
log "Configuring firewall..."
ufw --force reset
ufw default deny incoming
ufw default allow outgoing
ufw allow ssh
ufw allow 80/tcp
ufw allow 443/tcp
ufw --force enable

# Configure fail2ban
log "Configuring fail2ban..."
cat > /etc/fail2ban/jail.local << EOF
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 5

[sshd]
enabled = true
port = ssh
logpath = /var/log/auth.log
maxretry = 3
EOF

systemctl enable fail2ban
systemctl restart fail2ban

# Create project directory
log "Creating project directory..."
mkdir -p "$PROJECT_DIR"
cd "$PROJECT_DIR"

# Create environment file
log "Creating environment configuration..."
cat > .env << EOF
# Production Environment Variables
DOMAIN_NAME=$DOMAIN
EMAIL=$EMAIL

# Database Configuration
DB_NAME=production_wordpress
DB_USER=wp_user
DB_PASSWORD=$(openssl rand -base64 32)
DB_ROOT_PASSWORD=$(openssl rand -base64 32)
TABLE_PREFIX=wp_

# WordPress Configuration
WP_DEBUG=false
WP_ENV=production

# Generate WordPress salts
EOF

# Generate WordPress salts and add to .env
log "Generating WordPress security keys..."
curl -s https://api.wordpress.org/secret-key/1.1/salt/ | sed 's/define.*(\x27\([^x27]*\)\x27,.*\x27\([^x27]*\)\x27.*/\1=\2/' >> .env

# Create directories
log "Creating required directories..."
mkdir -p nginx/conf.d nginx/ssl nginx/logs nginx/webroot
mkdir -p mysql/conf.d
mkdir -p scripts
mkdir -p backups
chmod 755 backups

# Set proper permissions
chmod 600 .env
chmod +x scripts/*.sh 2>/dev/null || true

log "Basic server setup completed!"
warn "Next steps:"
echo "1. Copy your WordPress files to: $PROJECT_DIR"
echo "2. Update the domain name in: $PROJECT_DIR/nginx/conf.d/wordpress.conf"
echo "3. Update environment variables in: $PROJECT_DIR/.env"
echo "4. Run: docker-compose -f docker-compose.production.yml up -d"
echo "5. Set up SSL certificate with: docker-compose -f docker-compose.production.yml run --rm certbot certonly --webroot --webroot-path=/var/www/certbot -d $DOMAIN -d www.$DOMAIN"

log "Deployment preparation completed!"
log "Server is ready for WordPress production deployment"
