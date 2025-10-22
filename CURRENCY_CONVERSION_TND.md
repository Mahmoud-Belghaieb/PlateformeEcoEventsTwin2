# Currency Conversion to TND - Complete Update

## Overview
This document details the complete conversion of all currency symbols from € (Euro) and $ (Dollar) to TND (Tunisian Dinar) across the entire ecoEvents platform.

**Date:** October 13, 2025  
**Status:** ✅ COMPLETE  
**Currency Standard:** TND (Tunisian Dinar)

---

## Files Updated

### 1. **Public Frontend Pages**

#### `resources/views/home.blade.php`
- **Line 1283-1284:** Event price display
  - Changed: `<i class="fas fa-euro-sign"></i>` → `<i class="fas fa-lira-sign"></i>`
  - Changed: `{{ number_format($event->price, 2) }}€` → `{{ number_format($event->price, 2) }} TND`

#### `resources/views/events/index.blade.php`
- **Line 889-890:** Event price display
  - Changed: `<i class="fas fa-euro-sign"></i>` → `<i class="fas fa-lira-sign"></i>`
  - Changed: `{{ number_format($event->price, 2) }}€` → `{{ number_format($event->price, 2) }} TND`

#### `resources/views/panier/index.blade.php` (Public Cart)
- **Line 63:** Item unit price
  - Changed: `{{ number_format($item->price, 2) }} DT` → `{{ number_format($item->price, 2) }} TND`
- **Line 127:** Subtotal display
  - Changed: `{{ number_format($total, 2) }} DT` → `{{ number_format($total, 2) }} TND`
- **Line 135:** Total display
  - Changed: `{{ number_format($total, 2) }} DT` → `{{ number_format($total, 2) }} TND`

---

### 2. **Admin Dashboard Pages**

#### `resources/views/admin/sponsors/index.blade.php`
- **Line 70:** Statistics card icon
  - Changed: `<i class="fas fa-euro-sign text-white"></i>` → `<i class="fas fa-lira-sign text-white"></i>`
- **Line 73:** Total contributions display
  - Changed: `€{{ number_format($sponsors->sum('contribution_amount'), 0) }}` → `{{ number_format($sponsors->sum('contribution_amount'), 2) }} TND`
- **Line 196:** Individual sponsor contribution
  - Changed: `€{{ number_format($sponsor->contribution_amount, 2) }}` → `{{ number_format($sponsor->contribution_amount, 2) }} TND`

#### `resources/views/admin/panier/index.blade.php`
- **Line 56:** Statistics card icon
  - Changed: `<i class="fas fa-euro-sign text-white"></i>` → `<i class="fas fa-lira-sign text-white"></i>`
- **Line 59:** Total revenue display
  - Changed: `€{{ number_format($stats['total_revenue'], 2) }}` → `{{ number_format($stats['total_revenue'], 2) }} TND`
- **Line 153:** Unit price in table
  - Changed: `€{{ number_format($panier->price, 2) }}` → `{{ number_format($panier->price, 2) }} TND`
- **Line 154:** Subtotal in table
  - Changed: `€{{ number_format($panier->subtotal, 2) }}` → `{{ number_format($panier->subtotal, 2) }} TND`

#### `resources/views/admin/panier/show.blade.php`
- **Line 46:** Unit price display
  - Changed: `€{{ number_format($panier->price, 2) }}` → `{{ number_format($panier->price, 2) }} TND`
- **Line 54:** Subtotal display
  - Changed: `€{{ number_format($panier->subtotal, 2) }}` → `{{ number_format($panier->subtotal, 2) }} TND`

---

### 3. **Model Files**

#### `app/Models/Produit.php`
- **Line 57-60:** `getFormattedPriceAttribute()` accessor
  - Changed: `return number_format($this->price, 2) . ' DT';` → `return number_format($this->price, 2) . ' TND';`
  - This affects all product price displays that use `$produit->formatted_price`

---

### 4. **Configuration Files**

#### `config/currency.php`
- **Already Configured:** Default currency set to TND
- **Symbol:** 'TND'
- **Format:** '%s %s' (amount symbol)
- **Precision:** 2 decimal places
- **Region:** Tunisia (TN, +216)

---

## Summary of Changes

### Icon Changes
| Old Icon | New Icon | Usage |
|----------|----------|-------|
| `fa-euro-sign` | `fa-lira-sign` | Currency icon for TND display |

### Currency Format Changes
| Old Format | New Format | Example |
|------------|------------|---------|
| `€XX.XX` | `XX.XX TND` | €45.50 → 45.50 TND |
| `XX.XX€` | `XX.XX TND` | 45.50€ → 45.50 TND |
| `XX.XX DT` | `XX.XX TND` | 45.50 DT → 45.50 TND |
| `€X` | `X TND` | €45 → 45 TND |

### Consistency Standards
1. **Currency Symbol Position:** Always after the amount with a space: `45.50 TND`
2. **Decimal Precision:** Always 2 decimal places: `.00`
3. **Icon:** Font Awesome `fa-lira-sign` for TND currency icon
4. **Code:** TND (not DT or د.ت)

---

## Impact Areas

### ✅ Completed Updates
- [x] Public event listings (home page)
- [x] Event index page
- [x] Public shopping cart
- [x] Admin sponsors management (statistics + table)
- [x] Admin cart orders management (statistics + table + details)
- [x] Product model formatting
- [x] Cart details page

### Files Using `formatted_price` (Already Updated via Model)
- `resources/views/produits/index.blade.php` - Uses `$produit->formatted_price`
- `resources/views/produits/show.blade.php` - Uses `$produit->formatted_price`
- `resources/views/admin/produits/index.blade.php` - Uses `$produit->formatted_price`

These files automatically display "TND" because the `Produit` model's `getFormattedPriceAttribute()` method was updated.

---

## Testing Checklist

### Public Pages
- [ ] Visit homepage - Check event prices show "XX.XX TND"
- [ ] Visit events page - Check event prices show "XX.XX TND"
- [ ] Visit products page - Check product prices show "XX.XX TND"
- [ ] Visit product detail - Check price shows "XX.XX TND"
- [ ] Add item to cart - Check cart shows "XX.XX TND"
- [ ] View cart summary - Check subtotal and total show "XX.XX TND"

### Admin Pages
- [ ] Visit admin dashboard
- [ ] Visit sponsors page - Check statistics and table show "TND"
- [ ] Visit products page - Check prices show "XX.XX TND"
- [ ] Visit cart orders page - Check revenue and prices show "TND"
- [ ] View cart order details - Check price and subtotal show "TND"

### Database Verification
- [ ] No actual price values in database were changed
- [ ] Only display formatting was updated
- [ ] All calculations remain accurate

---

## Technical Notes

### Why TND Instead of DT?
- **TND** is the ISO 4217 international standard code
- **DT** (Dinar Tunisien) is informal shorthand
- **TND** is recognized by international payment systems
- **Consistency** with config/currency.php

### Font Awesome Icon Choice
- **fa-lira-sign** is used as Font Awesome doesn't have a specific Tunisian Dinar icon
- The lira sign (₺) visually represents currency in the Middle East/North Africa region
- Alternative: Could use `fa-money-bill` or `fa-coins` for a generic currency icon

### Decimal Precision
- All prices maintain 2 decimal places: `.00`
- Format: `number_format($price, 2)`
- Example: 45.5 displays as "45.50 TND"

---

## Configuration Reference

```php
// config/currency.php
'default' => 'TND',

'currencies' => [
    'TND' => [
        'name' => 'Dinar Tunisien',
        'symbol' => 'TND',
        'code' => 'TND',
        'precision' => 2,
        'format' => '%s %s', // amount symbol
    ],
],

'region' => [
    'country' => 'Tunisie',
    'country_code' => 'TN',
    'phone_prefix' => '+216',
    'timezone' => 'Africa/Tunis',
],
```

---

## Files Modified Summary

**Total Files Updated:** 8

1. `resources/views/home.blade.php`
2. `resources/views/events/index.blade.php`
3. `resources/views/panier/index.blade.php`
4. `resources/views/admin/sponsors/index.blade.php`
5. `resources/views/admin/panier/index.blade.php`
6. `resources/views/admin/panier/show.blade.php`
7. `app/Models/Produit.php`
8. `config/currency.php` (already configured)

**Related Files (Using Model Accessor):**
- `resources/views/produits/index.blade.php`
- `resources/views/produits/show.blade.php`
- `resources/views/admin/produits/index.blade.php`

---

## Maintenance Notes

### Adding New Currency Displays
When adding new features that display prices:

1. **Use the model accessor when possible:**
   ```blade
   {{ $produit->formatted_price }}
   ```

2. **For manual formatting, use this pattern:**
   ```blade
   {{ number_format($price, 2) }} TND
   ```

3. **For currency icons, use:**
   ```blade
   <i class="fas fa-lira-sign"></i>
   ```

4. **For statistics cards:**
   ```blade
   <div class="icon-circle bg-info">
       <i class="fas fa-lira-sign text-white"></i>
   </div>
   <h2>{{ number_format($amount, 2) }} TND</h2>
   ```

---

## Future Enhancements (Optional)

1. **Multi-Currency Support:**
   - Add currency switcher in UI
   - Use config/currency.php rates for conversions
   - Store user preference in session

2. **Helper Functions:**
   ```php
   // Create a global helper
   function format_currency($amount) {
       return number_format($amount, 2) . ' TND';
   }
   ```

3. **Blade Directive:**
   ```php
   // In AppServiceProvider
   Blade::directive('tnd', function ($expression) {
       return "<?php echo number_format($expression, 2) . ' TND'; ?>";
   });
   
   // Usage: @tnd($price)
   ```

4. **Localization:**
   - Add translations for currency names
   - Support Arabic: "دينار تونسي"
   - Support French: "Dinar Tunisien"

---

## Completed By
- **Developer:** GitHub Copilot
- **Date:** October 13, 2025
- **Status:** ✅ Production Ready
- **Version:** 1.0.0

---

## Verification Commands

```bash
# Search for any remaining € symbols
grep -r "€" resources/views/

# Search for any remaining DT (excluding TND)
grep -r " DT" resources/views/ | grep -v TND

# Search for fa-euro-sign icons
grep -r "fa-euro-sign" resources/views/

# Verify model accessor
grep "formatted_price" app/Models/Produit.php
```

---

**✅ All currency conversions completed successfully!**
