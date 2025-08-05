#!/bin/bash

# WordPress Production Monitoring Script
# This script monitors the health of WordPress production environment

set -euo pipefail

# Configuration
DOMAIN=${DOMAIN_NAME:-"greenmetric.nspi.uz"}
ALERT_EMAIL=${ALERT_EMAIL:-"admin@greenmetric.nspi.uz"}
LOG_FILE="/var/log/wordpress-monitor.log"

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

# Logging function
log() {
    local level=$1
    shift
    local message="$*"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    
    case $level in
        "INFO")
            echo -e "${GREEN}[$timestamp] [INFO]${NC} $message" | tee -a "$LOG_FILE"
            ;;
        "WARN")
            echo -e "${YELLOW}[$timestamp] [WARN]${NC} $message" | tee -a "$LOG_FILE"
            ;;
        "ERROR")
            echo -e "${RED}[$timestamp] [ERROR]${NC} $message" | tee -a "$LOG_FILE"
            ;;
    esac
}

# Send alert function
send_alert() {
    local subject="$1"
    local message="$2"
    
    # Send email alert (configure your mail system)
    echo "$message" | mail -s "$subject" "$ALERT_EMAIL" 2>/dev/null || \
    log "WARN" "Failed to send email alert"
    
    # Log alert
    log "ERROR" "$subject: $message"
}

# Check website availability
check_website() {
    log "INFO" "Checking website availability..."
    
    local http_code=$(curl -s -o /dev/null -w "%{http_code}" "https://$DOMAIN" || echo "000")
    
    if [[ "$http_code" =~ ^[23] ]]; then
        log "INFO" "Website is accessible (HTTP $http_code)"
        return 0
    else
        log "ERROR" "Website is not accessible (HTTP $http_code)"
        send_alert "Website Down" "WordPress site $DOMAIN is not accessible. HTTP code: $http_code"
        return 1
    fi
}

# Check SSL certificate
check_ssl() {
    log "INFO" "Checking SSL certificate..."
    
    local expiry_date=$(echo | openssl s_client -servername "$DOMAIN" -connect "$DOMAIN:443" 2>/dev/null | \
                       openssl x509 -noout -dates | grep notAfter | cut -d= -f2)
    
    if [ -n "$expiry_date" ]; then
        local expiry_epoch=$(date -d "$expiry_date" +%s)
        local current_epoch=$(date +%s)
        local days_until_expiry=$(( (expiry_epoch - current_epoch) / 86400 ))
        
        if [ $days_until_expiry -lt 7 ]; then
            log "WARN" "SSL certificate expires in $days_until_expiry days"
            send_alert "SSL Certificate Expiring" "SSL certificate for $DOMAIN expires in $days_until_expiry days"
        else
            log "INFO" "SSL certificate is valid ($days_until_expiry days remaining)"
        fi
    else
        log "ERROR" "Could not check SSL certificate"
        send_alert "SSL Certificate Error" "Unable to check SSL certificate for $DOMAIN"
    fi
}

# Check Docker containers
check_containers() {
    log "INFO" "Checking Docker containers..."
    
    local containers=("nginx-proxy" "wordpress-app" "wordpress-db" "wordpress-redis")
    local failed_containers=()
    
    for container in "${containers[@]}"; do
        if docker ps --format "table {{.Names}}" | grep -q "$container"; then
            local status=$(docker inspect --format='{{.State.Health.Status}}' "$container" 2>/dev/null || echo "unknown")
            if [[ "$status" == "healthy" ]] || [[ "$status" == "unknown" ]]; then
                log "INFO" "Container $container is running"
            else
                log "ERROR" "Container $container is unhealthy"
                failed_containers+=("$container")
            fi
        else
            log "ERROR" "Container $container is not running"
            failed_containers+=("$container")
        fi
    done
    
    if [ ${#failed_containers[@]} -gt 0 ]; then
        send_alert "Container Issues" "Failed containers: ${failed_containers[*]}"
        return 1
    fi
    
    return 0
}

# Check disk usage
check_disk_usage() {
    log "INFO" "Checking disk usage..."
    
    local usage=$(df / | awk 'NR==2 {print $5}' | sed 's/%//')
    
    if [ "$usage" -gt 90 ]; then
        log "ERROR" "Disk usage is critical: ${usage}%"
        send_alert "Disk Space Critical" "Disk usage is at ${usage}%"
    elif [ "$usage" -gt 80 ]; then
        log "WARN" "Disk usage is high: ${usage}%"
    else
        log "INFO" "Disk usage is normal: ${usage}%"
    fi
}

# Check memory usage
check_memory_usage() {
    log "INFO" "Checking memory usage..."
    
    local mem_info=$(free | awk 'NR==2{printf "%.0f", $3*100/$2}')
    
    if [ "$mem_info" -gt 90 ]; then
        log "ERROR" "Memory usage is critical: ${mem_info}%"
        send_alert "Memory Usage Critical" "Memory usage is at ${mem_info}%"
    elif [ "$mem_info" -gt 80 ]; then
        log "WARN" "Memory usage is high: ${mem_info}%"
    else
        log "INFO" "Memory usage is normal: ${mem_info}%"
    fi
}

# Check database connectivity
check_database() {
    log "INFO" "Checking database connectivity..."
    
    if docker-compose -f docker-compose.production.yml exec -T db mysql -u root -p"${DB_ROOT_PASSWORD}" -e "SELECT 1;" >/dev/null 2>&1; then
        log "INFO" "Database is accessible"
    else
        log "ERROR" "Database is not accessible"
        send_alert "Database Connection Failed" "Cannot connect to WordPress database"
        return 1
    fi
}

# Check backup files
check_backups() {
    log "INFO" "Checking recent backups..."
    
    local backup_dir="/opt/wordpress/backups"
    local latest_backup=$(find "$backup_dir" -name "database_*.sql.gz" -mtime -1 | head -1)
    
    if [ -n "$latest_backup" ]; then
        log "INFO" "Recent database backup found: $(basename "$latest_backup")"
    else
        log "WARN" "No recent database backup found (last 24 hours)"
        send_alert "Backup Missing" "No recent database backup found in the last 24 hours"
    fi
}

# Main monitoring function
main() {
    log "INFO" "Starting WordPress monitoring check..."
    
    local checks_failed=0
    
    check_website || ((checks_failed++))
    check_ssl || ((checks_failed++))
    check_containers || ((checks_failed++))
    check_disk_usage || ((checks_failed++))
    check_memory_usage || ((checks_failed++))
    check_database || ((checks_failed++))
    check_backups || ((checks_failed++))
    
    if [ $checks_failed -eq 0 ]; then
        log "INFO" "All monitoring checks passed successfully"
    else
        log "ERROR" "$checks_failed monitoring checks failed"
    fi
    
    log "INFO" "Monitoring check completed"
    echo "" # Add spacing between runs
}

# Run main function
main "$@"
