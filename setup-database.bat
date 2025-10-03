@echo off
echo Setting up Portfolio Database...
echo.

echo Installing Composer dependencies...
composer install
echo.

echo Generating application key...
php artisan key:generate
echo.

echo Running database migrations...
php artisan migrate
echo.

echo Seeding database with sample data...
php artisan db:seed
echo.

echo Database setup completed successfully!
echo.
echo You can now start the development server with:
echo php artisan serve
echo.
pause
