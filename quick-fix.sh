#!/bin/bash
# QUICK PRODUCTION FIX

echo "🚀 QUICK PRODUCTION FIX"
echo "======================"

cd /var/www/green-metric-wordpress

# 1. Clean start
echo "1. Cleaning up..."
docker-compose -f docker-compose.production.yml down --volumes 2>/dev/null
docker system prune -f

# 2. Load environment
echo "2. Loading environment..."
export $(cat .env.production | grep -v '^#' | xargs)

# 3. Create logs directory
mkdir -p nginx/logs

# 4. Sequential startup (this worked with simple config)
echo "3. Starting services sequentially..."

echo "   Starting database..."
docker-compose -f docker-compose.production.yml up -d db
sleep 20

echo "   Starting Redis..."  
docker-compose -f docker-compose.production.yml up -d redis
sleep 5

echo "   Starting WordPress..."
docker-compose -f docker-compose.production.yml up -d wordpress  
sleep 15

echo "   Starting Nginx..."
docker-compose -f docker-compose.production.yml up -d nginx
sleep 10

# 5. Check status
echo "4. Checking status..."
docker-compose -f docker-compose.production.yml ps

# 6. Test connections
echo "5. Testing..."
echo "Local test:"
curl -I http://localhost/ 

echo "Domain test:"  
curl -I http://greenmetric.nspi.uz/

# 7. If still failing, show logs
if ! curl -s http://localhost/ > /dev/null; then
    echo "❌ Still failing. Container logs:"
    echo "=== DATABASE LOGS ==="
    docker-compose -f docker-compose.production.yml logs db --tail=5
    echo "=== WORDPRESS LOGS ==="
    docker-compose -f docker-compose.production.yml logs wordpress --tail=5  
    echo "=== NGINX LOGS ==="
    docker-compose -f docker-compose.production.yml logs nginx --tail=5
fi

echo "✅ Fix script complete!"
