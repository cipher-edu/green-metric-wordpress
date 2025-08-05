#!/bin/bash

# WordPress Production Restore Script
# This script restores WordPress from backup files

set -euo pipefail

# Configuration
BACKUP_DIR="/backups"
DB_HOST=${DB_HOST:-db}
DB_NAME=${DB_NAME:-production_wordpress}
DB_USER=${DB_USER:-root}
DB_PASSWORD=${DB_PASSWORD}

# Logging function
log() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') [RESTORE] $*"
}

# Usage function
usage() {
    echo "Usage: $0 [database_backup.sql.gz] [wordpress_files_backup.tar.gz]"
    echo "Example: $0 database_20250805_120000.sql.gz wordpress_files_20250805_120000.tar.gz"
    exit 1
}

# Check arguments
if [ $# -ne 2 ]; then
    log "ERROR: Invalid arguments provided"
    usage
fi

DB_BACKUP="$1"
FILES_BACKUP="$2"

# Check if backup files exist
if [ ! -f "$BACKUP_DIR/$DB_BACKUP" ]; then
    log "ERROR: Database backup file not found: $BACKUP_DIR/$DB_BACKUP"
    exit 1
fi

if [ ! -f "$BACKUP_DIR/$FILES_BACKUP" ]; then
    log "ERROR: Files backup file not found: $BACKUP_DIR/$FILES_BACKUP"
    exit 1
fi

log "Starting WordPress restore process..."
log "Database backup: $DB_BACKUP"
log "Files backup: $FILES_BACKUP"

# Confirmation prompt
read -p "Are you sure you want to restore? This will overwrite existing data (y/N): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    log "Restore cancelled by user"
    exit 0
fi

# Restore database
log "Restoring database..."
gunzip -c "$BACKUP_DIR/$DB_BACKUP" | mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME"

if [ $? -eq 0 ]; then
    log "Database restore completed successfully"
else
    log "ERROR: Database restore failed"
    exit 1
fi

# Restore WordPress files
log "Restoring WordPress files..."
tar -xzf "$BACKUP_DIR/$FILES_BACKUP" -C /wordpress

if [ $? -eq 0 ]; then
    log "WordPress files restore completed successfully"
else
    log "ERROR: WordPress files restore failed"
    exit 1
fi

# Set proper permissions
log "Setting file permissions..."
chown -R www-data:www-data /wordpress
find /wordpress -type d -exec chmod 755 {} \;
find /wordpress -type f -exec chmod 644 {} \;
chmod -R 775 /wordpress/wp-content

log "Restore completed successfully!"
log "Please clear cache and check your website"
