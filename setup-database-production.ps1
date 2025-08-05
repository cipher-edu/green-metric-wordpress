# GreenMetric WordPress Production Setup - Windows PowerShell Version
# Bu skript Windows PowerShell orqali ishga tushiriladi

Write-Host "=== GreenMetric WordPress Production Setup ===" -ForegroundColor Green
Write-Host "Sana: $(Get-Date)" -ForegroundColor Yellow

# Loyihaning ildiz katalogiga o'tish
Set-Location "d:\Inkubatsiya"

# 1. Barcha containerlarni to'xtatish
Write-Host "1. Mavjud containerlarni to'xtatish..." -ForegroundColor Cyan
docker-compose -f docker-compose.production.yml down --volumes --remove-orphans

# 2. Docker tizimini tozalash
Write-Host "2. Docker tizimini tozalash..." -ForegroundColor Cyan
docker system prune -f
docker volume prune -f

# 3. .env faylini tekshirish
Write-Host "3. Environment faylini tekshirish..." -ForegroundColor Cyan
if (Test-Path ".env") {
    Write-Host "✓ .env fayli mavjud" -ForegroundColor Green
} else {
    Write-Host "⚠ .env fayli yaratildi" -ForegroundColor Yellow
}

# 4. Kerakli kataloglarni yaratish
Write-Host "4. Kerakli kataloglarni yaratish..." -ForegroundColor Cyan
New-Item -ItemType Directory -Force -Path "mysql\conf.d" | Out-Null
New-Item -ItemType Directory -Force -Path "nginx\conf.d" | Out-Null  
New-Item -ItemType Directory -Force -Path "nginx\logs" | Out-Null

# 5. MySQL containerini ishga tushirish
Write-Host "5. MySQL containerini ishga tushirish..." -ForegroundColor Cyan
docker-compose -f docker-compose.production.yml up -d db

# 6. MySQL ishga tushishini kutish
Write-Host "6. MySQL ishga tushishini kutish (30 soniya)..." -ForegroundColor Cyan
Start-Sleep -Seconds 30

# 7. MySQL loglarini ko'rsatish
Write-Host "7. MySQL loglarini tekshirish..." -ForegroundColor Cyan
docker-compose -f docker-compose.production.yml logs db --tail=10

# 8. Redis containerini ishga tushirish
Write-Host "8. Redis containerini ishga tushirish..." -ForegroundColor Cyan
docker-compose -f docker-compose.production.yml up -d redis
Start-Sleep -Seconds 10

# 9. WordPress containerini ishga tushirish
Write-Host "9. WordPress containerini ishga tushirish..." -ForegroundColor Cyan
docker-compose -f docker-compose.production.yml up -d wordpress
Start-Sleep -Seconds 30

# 10. WordPress loglarini ko'rsatish
Write-Host "10. WordPress loglarini tekshirish..." -ForegroundColor Cyan
docker-compose -f docker-compose.production.yml logs wordpress --tail=10

# 11. Nginx containerini ishga tushirish
Write-Host "11. Nginx containerini ishga tushirish..." -ForegroundColor Cyan
docker-compose -f docker-compose.production.yml up -d nginx
Start-Sleep -Seconds 15

# 12. Barcha konteynerlar holatini tekshirish
Write-Host "12. Barcha konteynerlar holati:" -ForegroundColor Cyan
docker-compose -f docker-compose.production.yml ps

# 13. Web saytni tekshirish
Write-Host "13. Web saytni tekshirish..." -ForegroundColor Cyan
Write-Host "Local test (localhost):" -ForegroundColor Yellow
try {
    $response = Invoke-WebRequest -Uri "http://localhost" -Method Head -TimeoutSec 10
    Write-Host "✓ Status: $($response.StatusCode)" -ForegroundColor Green
} catch {
    Write-Host "✗ Local test failed: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host "External test (greenmetric.nspi.uz):" -ForegroundColor Yellow
try {
    $response = Invoke-WebRequest -Uri "http://greenmetric.nspi.uz" -Method Head -TimeoutSec 10
    Write-Host "✓ Status: $($response.StatusCode)" -ForegroundColor Green
} catch {
    Write-Host "✗ External test failed: $($_.Exception.Message)" -ForegroundColor Red
}

# 14. Yakuniy natija
Write-Host "" 
Write-Host "=== YAKUNIY NATIJA ===" -ForegroundColor Green
Write-Host "Barcha konteynerlar holati:" -ForegroundColor Cyan
docker-compose -f docker-compose.production.yml ps

Write-Host ""
Write-Host "Web sayt manzillari:" -ForegroundColor Yellow
Write-Host "- Local: http://localhost"
Write-Host "- Domain: http://greenmetric.nspi.uz"
Write-Host ""
Write-Host "WordPress admin:" -ForegroundColor Yellow
Write-Host "- URL: http://greenmetric.nspi.uz/wp-admin"
Write-Host ""
Write-Host "Database ma'lumotlari:" -ForegroundColor Yellow
Write-Host "- Host: db:3306"
Write-Host "- Database: greenmetric_wp"
Write-Host "- User: wp_user"
Write-Host ""
Write-Host "Agar sayt ishlamasa, quyidagi buyruqlar bilan tekshiring:" -ForegroundColor Cyan
Write-Host "docker-compose -f docker-compose.production.yml logs wordpress"
Write-Host "docker-compose -f docker-compose.production.yml logs db"
Write-Host "docker-compose -f docker-compose.production.yml logs nginx"

Write-Host ""
Write-Host "Setup yakunlandi! $(Get-Date)" -ForegroundColor Green
