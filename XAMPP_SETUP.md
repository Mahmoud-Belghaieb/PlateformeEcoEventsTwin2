# EcoEvents - XAMPP MySQL Setup Guide

## 📋 Prerequisites
1. **XAMPP installed** with MySQL service running
2. **PHP 8.2+ with MySQL extensions enabled**

## 🔧 Step 1: Enable MySQL Extensions in PHP

### Option A: Edit php.ini manually
1. Open `C:\php\php.ini` in a text editor (as Administrator)
2. Find these lines and remove the semicolon (`;`):
   ```ini
   ;extension=pdo_mysql
   ;extension=mysqli
   ```
   Change to:
   ```ini
   extension=pdo_mysql
   extension=mysqli
   ```
3. Save the file and restart your command prompt

### Option B: Check if extensions are already available
Run: `php -m | findstr mysql`
If you see `pdo_mysql` and `mysqli`, you're ready!

## 🗄️ Step 2: Configure Database

1. **Start XAMPP** and ensure MySQL is running
2. **Open phpMyAdmin** (http://localhost/phpmyadmin)
3. **Create database**: `ecoevents`

## ⚙️ Step 3: Update Laravel Configuration

1. **Edit `.env` file** in your project root:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ecoevents
   DB_USERNAME=root
   DB_PASSWORD=
   ```

## 🚀 Step 4: Run Migrations

```bash
php artisan migrate:fresh
php artisan db:seed --class=AdminUserSeeder
```

## 🧪 Step 5: Test the Application

```bash
php artisan serve
```

Visit: http://localhost:8000

## 👥 Default Login Credentials

- **Admin**: admin@ecoevents.com / admin123
- **Participant**: participant@ecoevents.com / participant123  
- **Volunteer**: volunteer@ecoevents.com / volunteer123

## 🔍 Troubleshooting

### If you get "could not find driver" error:
1. Check PHP version: `php --version`
2. Check MySQL extensions: `php -m | findstr mysql`
3. Ensure XAMPP MySQL service is running
4. Restart command prompt after editing php.ini

### If migrations fail:
1. Check database exists in phpMyAdmin
2. Verify .env database credentials
3. Test connection: `php artisan tinker` then `DB::connection()->getPdo()`

## 📁 Project Structure
```
ecoEvents/
├── app/Http/Controllers/
│   ├── AuthController.php          # Authentication
│   └── UserManagementController.php # Admin panel
├── database/
│   ├── migrations/                 # Database structure
│   └── seeders/AdminUserSeeder.php # Default users
├── resources/views/
│   ├── auth/                       # Login/Register pages
│   ├── admin/                      # Admin panel
│   └── home.blade.php              # Main page
└── routes/web.php                  # Application routes
```

## ✅ Features Implemented
- ✅ User Authentication (Login/Register)
- ✅ Role-based Access (Admin/Participant/Volunteer)
- ✅ User Management System
- ✅ Responsive UI Design
- ✅ Session Management
- ✅ Database Seeding

## 🎯 Next Steps
- Event Management System
- Dashboard Statistics
- Volunteer Task Assignment
- Email Notifications