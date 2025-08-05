#!/bin/bash

# WordPress Production Backup Script
# This script creates backups of WordPress files and database

set -euo pipefail

# Configuration
BACKUP_DIR="/backups"
DATE=$(date +%Y%m%d_%H%M%S)
RETENTION_DAYS=${BACKUP_RETENTION_DAYS:-30}

# Database settings
DB_HOST=${DB_HOST:-db}
DB_NAME=${DB_NAME:-production_wordpress}
DB_USER=${DB_USER:-root}
DB_PASSWORD=${DB_PASSWORD}

# Logging function
log() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') [BACKUP] $*"
}

# Create backup directory
mkdir -p "$BACKUP_DIR"

log "Starting WordPress backup process..."

# Database backup
log "Creating database backup..."
mysqldump -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" \
    --single-transaction \
    --routines \
    --triggers \
    --lock-tables=false \
    "$DB_NAME" | gzip > "$BACKUP_DIR/database_${DATE}.sql.gz"

if [ $? -eq 0 ]; then
    log "Database backup completed successfully"
else
    log "ERROR: Database backup failed"
    exit 1
fi

# WordPress files backup
log "Creating WordPress files backup..."
tar -czf "$BACKUP_DIR/wordpress_files_${DATE}.tar.gz" \
    -C /wordpress \
    --exclude="wp-content/cache/*" \
    --exclude="wp-content/tmp/*" \
    --exclude="*.log" \
    .

if [ $? -eq 0 ]; then
    log "WordPress files backup completed successfully"
else
    log "ERROR: WordPress files backup failed"
    exit 1
fi

# Clean old backups
log "Cleaning old backups (older than $RETENTION_DAYS days)..."
find "$BACKUP_DIR" -name "database_*.sql.gz" -mtime +$RETENTION_DAYS -delete
find "$BACKUP_DIR" -name "wordpress_files_*.tar.gz" -mtime +$RETENTION_DAYS -delete

# Backup summary
DB_SIZE=$(du -h "$BACKUP_DIR/database_${DATE}.sql.gz" | cut -f1)
FILES_SIZE=$(du -h "$BACKUP_DIR/wordpress_files_${DATE}.tar.gz" | cut -f1)

log "Backup completed successfully!"
log "Database backup size: $DB_SIZE"
log "Files backup size: $FILES_SIZE"
log "Backup location: $BACKUP_DIR"

# Optional: Upload to cloud storage (uncomment and configure)
# log "Uploading backups to cloud storage..."
# aws s3 cp "$BACKUP_DIR/database_${DATE}.sql.gz" s3://your-backup-bucket/wordpress/
# aws s3 cp "$BACKUP_DIR/wordpress_files_${DATE}.tar.gz" s3://your-backup-bucket/wordpress/
