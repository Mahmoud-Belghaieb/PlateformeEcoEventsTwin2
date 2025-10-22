# 🔐 ADMIN CREDENTIALS - EcoEvents

## 👨‍💼 Admin Login

**Email:** `admin@ecoevents.com`  
**Password:** `admin123`

---

## 🌐 Important URLs

### Login Page:
```
http://localhost:8000/login
```

### Admin Panel:
```
http://localhost:8000/admin
```

### New Module Management:

**Sponsors Management:**
```
http://localhost:8000/admin/sponsors
```

**Products Management:**
```
http://localhost:8000/admin/produits
```

**Materials Management:**
```
http://localhost:8000/admin/materiels
```

---

## 👥 All Available Test Users

| Name | Email | Role | Password |
|------|-------|------|----------|
| Administrateur EcoEvents | admin@ecoevents.com | **admin** | admin123 |
| ahmed | participant@ecoevents.com | participant | *(unknown)* |
| Marie Bénévole | volunteer@ecoevents.com | volunteer | *(unknown)* |
| balsem | yokhedh@gmail.com | volunteer | *(unknown)* |
| mayssa | mayssa.benhammouda@esprit.tn | participant | *(unknown)* |

---

## 🚀 Quick Start

1. **Start the server:**
   ```powershell
   php artisan serve
   ```

2. **Visit:** http://localhost:8000/login

3. **Login with:**
   - Email: `admin@ecoevents.com`
   - Password: `admin123`

4. **Access new modules:**
   - Create sponsors
   - Add products
   - Manage materials
   - View shopping cart functionality

---

## 🔄 Reset Password (If Needed)

To reset the admin password again, run:
```powershell
php reset_admin_password.php
```

This will reset the password back to `admin123`

---

## ⚠️ Security Note

**IMPORTANT:** Change the default password after first login!

The current password (`admin123`) is for development/testing only.

---

## 📝 Testing Workflow

### As Admin:
1. Login with admin credentials
2. Go to `/admin/sponsors`
3. Create a new sponsor with logo
4. Go to `/admin/produits`
5. Create products and assign to sponsor
6. Go to `/admin/materiels`
7. Create materials and assign to events

### As Customer:
1. Logout from admin
2. Register a new user account
3. Visit `/produits` (product catalog)
4. Add products to cart
5. Visit `/panier` (shopping cart)
6. Complete checkout

---

## 🎯 All Admin Features

With admin credentials, you can access:

- ✅ **Dashboard** - Admin overview
- ✅ **Users Management** - Manage all users
- ✅ **Events Management** - Create/edit events
- ✅ **Categories** - Event categories
- ✅ **Venues** - Event locations
- ✅ **Registrations** - Event sign-ups
- ✅ **Avis (Reviews)** - Moderate reviews
- ✅ **Commentaires** - Moderate comments
- ✅ **Email Logs** - Email history
- ✅ **NEW: Sponsors** - Partner management
- ✅ **NEW: Products** - E-commerce catalog
- ✅ **NEW: Materials** - Equipment inventory

---

## 📊 Quick Stats

Current database has:
- **5 Users** (1 admin, 2 participants, 2 volunteers)
- **4 New Tables** (sponsors, produits, materiels, paniers)
- **31 New Routes** (admin + public + cart)
- **13 New Views** (admin interfaces + frontend)

---

## 🐛 Troubleshooting

### Can't Login?
- Check server is running: `php artisan serve`
- Verify URL: http://localhost:8000/login
- Try resetting password: `php reset_admin_password.php`

### Admin Routes Not Working?
- Clear cache: `php artisan cache:clear`
- Clear routes: `php artisan route:clear`
- Verify role: Should be 'admin' not 'administrator'

### Session Issues?
- Clear browser cookies
- Try incognito/private mode
- Run: `php artisan session:flush`

---

## 💡 Pro Tips

1. **Use Admin Credentials** for testing all new modules
2. **Create Test Data** immediately after login
3. **Test Cart Flow** with a separate user account
4. **Upload Sample Images** for sponsors and products
5. **Check Responsive Design** on mobile view

---

*Last Updated: October 10, 2025*  
*Password Last Reset: Today*  
*Security Level: Development/Testing Only*

---

## ⚡ Quick Commands Reference

```powershell
# Start server
php artisan serve

# Reset admin password
php reset_admin_password.php

# Clear all cache
php artisan cache:clear; php artisan config:clear; php artisan route:clear; php artisan view:clear

# Check routes
php artisan route:list | Select-String "admin"

# Check database
php artisan migrate:status

# Create storage link
php artisan storage:link
```

---

**Ready to login and test your new modules!** 🚀
