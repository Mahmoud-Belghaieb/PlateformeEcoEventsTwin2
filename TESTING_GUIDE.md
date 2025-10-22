# 🧪 TESTING GUIDE - New Modules

Quick guide to test all the new functionality.

## 🚀 Quick Start Test

### 1. Start the Development Server
```powershell
php artisan serve
```
Visit: http://localhost:8000

---

## 👨‍💼 ADMIN TESTING

### Access Admin Panel
1. Login as admin user
2. Navigate to admin section

### Test Sponsors Module

#### Create a Sponsor:
1. Go to `/admin/sponsors`
2. Click "Nouveau Sponsor"
3. Fill in:
   - Name: "EcoTech Solutions"
   - Description: "Leading provider of sustainable technology"
   - Website: "https://ecotech-solutions.tn"
   - Email: "contact@ecotech.tn"
   - Phone: "+216 71 123 456"
   - Level: "Gold"
   - Contribution: "5000"
   - Logo: Upload a test image
   - Active: Checked
4. Click "Créer"
5. ✅ Should see success message and sponsor in list

#### Edit a Sponsor:
1. Click edit icon on a sponsor
2. Change contribution amount
3. Upload new logo
4. Save
5. ✅ Verify changes are saved

#### Delete a Sponsor:
1. Click delete icon
2. Confirm deletion
3. ✅ Sponsor removed from list

---

### Test Products Module

#### Create a Product:
1. Go to `/admin/produits`
2. Click "Nouveau Produit"
3. Fill in:
   - Name: "Sac Écologique Réutilisable"
   - Description: "Sac en coton biologique, 100% recyclable"
   - Category: "Écologie"
   - Price: "25.50"
   - Stock: "100"
   - Image: Upload product image
   - Sponsor: Select "EcoTech Solutions"
   - Available: Checked
4. Click "Créer"
5. ✅ Product appears in list

#### Test Stock Display:
- Stock > 10: Green badge
- Stock 1-10: Yellow badge
- Stock = 0: Red badge

#### Edit Product:
1. Change price to "19.99"
2. Update stock to "50"
3. ✅ Verify updates

---

### Test Materials Module

#### Create a Material:
1. Go to `/admin/materiels`
2. Click "Nouveau Matériel"
3. Fill in:
   - Name: "Tables Pliantes"
   - Description: "Tables pliantes pour événements extérieurs"
   - Type: "Mobilier"
   - Quantity: "20"
   - Condition: "Bon"
   - Value: "150.00"
   - Image: Upload image
   - Event: Select an existing event (optional)
   - Available: Checked
4. Click "Créer"
5. ✅ Material created successfully

#### Test Condition Badges:
- Good: Green badge
- Fair: Yellow badge
- Poor: Red badge

---

## 🛍️ FRONTEND TESTING (Customer View)

### Test Product Catalog

1. **Browse Products:**
   - Go to `/produits`
   - ✅ Should see product grid
   - ✅ Images display correctly
   - ✅ Prices show with "DT"
   - ✅ Stock levels visible

2. **Search Products:**
   - Enter "Sac" in search box
   - Click "Filtrer"
   - ✅ Results filtered

3. **Filter by Category:**
   - Select "Écologie" from dropdown
   - Click "Filtrer"
   - ✅ Only category products shown

4. **Filter by Sponsor:**
   - Select a sponsor
   - ✅ Only sponsor's products shown

---

### Test Product Details

1. Click "Voir" on a product
2. ✅ Check:
   - Product image displays
   - Description shows
   - Price formatted correctly
   - Stock availability shown
   - Sponsor info (if applicable)
   - Related products section (if category has other products)

---

### Test Shopping Cart (Requires Login)

#### Add to Cart:
1. Login as regular user (not admin)
2. Go to `/produits`
3. Click "Ajouter" on a product
4. ✅ Should see success message

#### View Cart:
1. Go to `/panier` or click cart icon in nav
2. ✅ Verify:
   - Product listed with image
   - Price shown
   - Quantity editable
   - Subtotal calculated correctly
   - Total at bottom correct

#### Update Quantity:
1. Change quantity in cart
2. Click update button
3. ✅ Subtotal recalculates
4. ✅ Cannot exceed stock limit

#### Remove from Cart:
1. Click trash icon
2. Confirm
3. ✅ Item removed

#### Clear Cart:
1. Click "Vider le panier"
2. Confirm
3. ✅ All items removed

#### Checkout:
1. Add multiple products to cart
2. Click "Valider la commande"
3. ✅ Success message appears
4. ✅ Go to admin → products
5. ✅ Verify stock decreased
6. ✅ Cart now empty

---

### Test Sponsors Page

1. Go to `/sponsors`
2. ✅ Check:
   - Sponsor logos display
   - Sponsorship level badges show correct colors
   - Contact information visible
   - Website links work
   - Products listed (if sponsor has products)
   - "Devenir Sponsor" CTA visible

---

## 🔐 SECURITY TESTING

### Test Authentication:
1. **Logout** from account
2. Try to access:
   - `/admin/sponsors` → ✅ Should redirect to login
   - `/admin/produits` → ✅ Should redirect to login
   - `/panier` → ✅ Should redirect to login
3. Login as **regular user** (not admin)
4. Try to access:
   - `/admin/sponsors` → ✅ Should get 403 Forbidden or redirect
5. Login as **admin**
6. Access admin routes → ✅ Should work

### Test Cart Ownership:
1. Login as User A
2. Add products to cart
3. Note a panier ID from database
4. Logout, login as User B
5. Try to manipulate User A's cart → ✅ Should fail (403)

---

## 🖼️ IMAGE UPLOAD TESTING

### Test Image Uploads:
1. **Valid Images:**
   - Upload JPG (< 2MB) → ✅ Works
   - Upload PNG (< 2MB) → ✅ Works
   - Upload GIF (< 2MB) → ✅ Works

2. **Invalid Images:**
   - Upload > 2MB file → ✅ Should show error
   - Upload .txt file → ✅ Should show error

3. **Image Display:**
   - Check images appear in:
     - Admin list pages
     - Product catalog
     - Product details
     - Cart items
     - Sponsors page

4. **Image Replacement:**
   - Edit a product/sponsor
   - Upload new image
   - ✅ Old image should be deleted
   - ✅ New image displays

---

## 📊 DATA VALIDATION TESTING

### Test Required Fields:
Try to submit forms with missing required fields:
- Sponsor name → ✅ Error shown
- Product name → ✅ Error shown
- Product price → ✅ Error shown
- Product stock → ✅ Error shown
- Material name → ✅ Error shown

### Test Numeric Fields:
- Enter negative price → ✅ Error
- Enter negative stock → ✅ Error
- Enter text in price field → ✅ Error

### Test Email Validation:
- Enter invalid email → ✅ Error shown

### Test URL Validation:
- Enter invalid website URL → ✅ Error shown

---

## 🛒 STOCK MANAGEMENT TESTING

### Test Stock Limits:
1. Create product with stock = 5
2. Add 3 to cart
3. Try to add 3 more → ✅ Should show error "Stock insuffisant"
4. Checkout with 3 items
5. ✅ Stock should become 2
6. Try to add 3 more → ✅ Should show error

### Test Out of Stock:
1. Create product with stock = 0
2. View product page
3. ✅ "Épuisé" badge shown
4. ✅ "Add to cart" button disabled
5. ✅ Cannot add to cart

---

## 🔄 RELATIONSHIP TESTING

### Test Sponsor → Products:
1. Create a sponsor
2. Create 3 products assigned to that sponsor
3. View sponsor on public page
4. ✅ Should show product badges
5. Delete sponsor
6. ✅ Products should still exist (sponsor_id set to null)

### Test Event → Materials:
1. Create an event
2. Create materials assigned to that event
3. View event (if you have event details page)
4. Delete event
5. ✅ Materials should still exist (event_id set to null)

### Test User → Cart:
1. Login as User A, add items
2. Login as User B, add different items
3. ✅ Each user sees only their cart

---

## 📱 RESPONSIVE TESTING

### Test on Different Devices:
1. **Desktop (1920x1080):**
   - ✅ Product grid shows 4 columns
   - ✅ Navigation horizontal
   - ✅ Cart table displays properly

2. **Tablet (768x1024):**
   - ✅ Product grid shows 3 columns
   - ✅ Navigation still horizontal
   - ✅ Forms remain readable

3. **Mobile (375x667):**
   - ✅ Product grid shows 1 column
   - ✅ Navigation collapses to hamburger
   - ✅ Cart table scrollable
   - ✅ Buttons stack vertically

**How to Test:**
- Use browser DevTools (F12)
- Click "Toggle device toolbar"
- Select different devices

---

## 🐛 COMMON ISSUES TO CHECK

### Image Display Issues:
- ✅ Check `storage/app/public/` contains folders: sponsors, produits, materiels
- ✅ Check symbolic link exists: `public/storage` → `storage/app/public`
- ✅ Run: `php artisan storage:link` if needed

### Route Not Found:
- ✅ Check routes added to `routes/web.php`
- ✅ Run: `php artisan route:list` to verify
- ✅ Clear cache: `php artisan route:clear`

### View Not Found:
- ✅ Check file paths match route definitions
- ✅ Check file extensions are `.blade.php`
- ✅ Run: `php artisan view:clear`

### Database Errors:
- ✅ Verify migrations ran: `php artisan migrate:status`
- ✅ Check foreign keys exist
- ✅ Verify relationships in models

---

## ✅ COMPLETE TEST CHECKLIST

### Admin Panel:
- [ ] Create sponsor with logo
- [ ] Edit sponsor
- [ ] Delete sponsor
- [ ] Create product with image
- [ ] Update product stock
- [ ] Delete product
- [ ] Create material
- [ ] Assign material to event
- [ ] Delete material

### Frontend:
- [ ] Browse product catalog
- [ ] Search products
- [ ] Filter by category
- [ ] Filter by sponsor
- [ ] View product details
- [ ] See related products
- [ ] View sponsors page

### Shopping Cart:
- [ ] Add product to cart
- [ ] Update cart quantity
- [ ] Remove from cart
- [ ] Clear entire cart
- [ ] Checkout order
- [ ] Verify stock decreased

### Security:
- [ ] Cannot access admin without login
- [ ] Cannot access admin as regular user
- [ ] Cannot modify other user's cart
- [ ] Cannot checkout empty cart
- [ ] Cannot add more than stock allows

### Images:
- [ ] Sponsor logos display
- [ ] Product images display
- [ ] Material images display
- [ ] Images in cart
- [ ] Default icons when no image

### Validation:
- [ ] Required fields validated
- [ ] Numeric fields validated
- [ ] Email format validated
- [ ] URL format validated
- [ ] Image size/type validated

---

## 📝 TEST DATA EXAMPLES

### Sample Sponsors:
```
Name: "Green Energy Corp"
Level: Platinum
Contribution: 10000 DT

Name: "Eco Packaging Ltd"
Level: Silver
Contribution: 3000 DT
```

### Sample Products:
```
Name: "Bouteille Réutilisable en Acier"
Category: "Écologie"
Price: 35.00 DT
Stock: 50

Name: "Cahier Recyclé A5"
Category: "Papeterie"
Price: 12.50 DT
Stock: 200
```

### Sample Materials:
```
Name: "Chaises Pliantes"
Type: "Mobilier"
Quantity: 50
Condition: Good
Value: 75.00 DT per unit

Name: "Système Audio Portable"
Type: "Électronique"
Quantity: 2
Condition: Fair
Value: 500.00 DT
```

---

## 🎯 SUCCESS CRITERIA

All features working = ✅ Ready for production!

**What "Working" Means:**
- ✅ No PHP errors
- ✅ No database errors
- ✅ Images display correctly
- ✅ Forms validate properly
- ✅ Security checks pass
- ✅ Stock management works
- ✅ Cart checkout completes
- ✅ Responsive on mobile

---

*Generated: October 10, 2025*
*EcoEvents Testing Guide*
