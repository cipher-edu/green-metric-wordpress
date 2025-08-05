#!/bin/bash
# DEBUG SCRIPT FOR PRODUCTION SETUP

echo "🔍 DEBUGGING PRODUCTION SETUP"
echo "================================"

cd /var/www/green-metric-wordpress

echo "1. Stopping all containers..."
docker-compose -f docker-compose.production.yml down --volumes
sleep 5

echo "2. Checking Docker system..."
docker system df
docker ps -a

echo "3. Loading environment variables..."
export $(cat .env.production | grep -v '^#' | xargs)
echo "Environment variables loaded:"
echo "MYSQL_DATABASE=$MYSQL_DATABASE"
echo "MYSQL_USER=$MYSQL_USER" 
echo "MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD"

echo "4. Starting database only..."
docker-compose -f docker-compose.production.yml up -d db
sleep 10

echo "5. Checking database container..."
docker-compose -f docker-compose.production.yml ps
docker-compose -f docker-compose.production.yml logs db --tail=10

echo "6. Starting Redis..."
docker-compose -f docker-compose.production.yml up -d redis
sleep 5

echo "7. Starting WordPress..."
docker-compose -f docker-compose.production.yml up -d wordpress
sleep 15

echo "8. Checking WordPress container..."
docker-compose -f docker-compose.production.yml logs wordpress --tail=10

echo "9. Starting Nginx..."
docker-compose -f docker-compose.production.yml up -d nginx
sleep 5

echo "10. Final status check..."
docker-compose -f docker-compose.production.yml ps

echo "11. Testing connections..."
echo "Testing nginx container:"
docker-compose -f docker-compose.production.yml exec nginx nginx -t 2>/dev/null && echo "✅ Nginx config OK" || echo "❌ Nginx config error"

echo "Testing database connection:"
docker-compose -f docker-compose.production.yml exec db mysql -u wp_user -pWpPass2024! greenmetric_wp -e "SELECT 1;" 2>/dev/null && echo "✅ Database OK" || echo "❌ Database error"

echo "12. Network test..."
curl -I http://localhost/ 2>/dev/null && echo "✅ Local connection OK" || echo "❌ Local connection failed"
curl -I http://greenmetric.nspi.uz/ 2>/dev/null && echo "✅ Domain connection OK" || echo "❌ Domain connection failed"

echo "13. Port check..."
netstat -tlnp | grep :80 || echo "❌ Port 80 not listening"

echo "🎯 TROUBLESHOOTING COMPLETE"
