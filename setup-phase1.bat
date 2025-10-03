@echo off
echo ========================================
echo Phase 1: Backend API Development Setup
echo ========================================
echo.

echo [1/8] Installing Laravel Sanctum...
composer require laravel/sanctum
echo.

echo [2/8] Publishing Sanctum configuration...
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
echo.

echo [3/8] Running database migrations...
php artisan migrate
echo.

echo [4/8] Seeding database with sample data...
php artisan db:seed
echo.

echo [5/8] Generating application key...
php artisan key:generate
echo.

echo [6/8] Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
echo.

echo [7/8] Creating storage link...
php artisan storage:link
echo.

echo [8/8] Testing API endpoints...
echo Testing health check...
curl -s http://localhost:8000/api/health || echo "Server not running - start with: php artisan serve"
echo.

echo ========================================
echo Phase 1 Setup Complete!
echo ========================================
echo.
echo Next steps:
echo 1. Start the server: php artisan serve
echo 2. Test API endpoints with Postman
echo 3. Check admin login: POST /api/v1/admin/login
echo 4. Test contact form: POST /api/v1/contact
echo.
echo API Documentation:
echo - Health Check: GET /api/health
echo - Blogs: GET /api/v1/blogs
echo - Portfolios: GET /api/v1/portfolios
echo - Contact: POST /api/v1/contact
echo - Testimonials: GET /api/v1/testimonials
echo - Admin Login: POST /api/v1/admin/login
echo.
pause
