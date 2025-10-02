@echo off
echo ========================================
echo EcoEvents - MySQL Setup for XAMPP
echo ========================================
echo.

echo Step 1: Creating database...
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS ecoevents CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if %errorlevel% equ 0 (
    echo ✓ Database 'ecoevents' created successfully
) else (
    echo ✗ Failed to create database. Make sure XAMPP MySQL is running.
    pause
    exit /b 1
)

echo.
echo Step 2: Running migrations...
php artisan migrate --force
if %errorlevel% equ 0 (
    echo ✓ Migrations completed successfully
) else (
    echo ✗ Migration failed
    pause
    exit /b 1
)

echo.
echo Step 3: Seeding database with users...
php artisan db:seed --class=AdminUserSeeder --force
if %errorlevel% equ 0 (
    echo ✓ Database seeded successfully
) else (
    echo ✗ Seeding failed
    pause
    exit /b 1
)

echo.
echo ========================================
echo ✓ MySQL setup completed successfully!
echo ========================================
echo.
echo Default users created:
echo - Admin: admin@ecoevents.com / admin123
echo - Participant: participant@ecoevents.com / participant123
echo - Volunteer: volunteer@ecoevents.com / volunteer123
echo.
echo You can now access phpMyAdmin at: http://localhost/phpmyadmin
echo.
pause