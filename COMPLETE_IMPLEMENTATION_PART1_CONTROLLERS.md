# 🚀 Complete Implementation Code - Part 1: Controllers

## ✅ Status
- Sponsor Controller: ✅ COMPLETED
- Produit Controller: 📝 CODE BELOW
- Materiel Controller: 📝 CODE BELOW  
- Panier Controller: 📝 CODE BELOW

---

## 📝 ProduitController.php

Replace the content of `app/Http/Controllers/ProduitController.php` with:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    /**
     * Display a listing of products (Admin)
     */
    public function index()
    {
        $produits = Produit::with('sponsor')->latest()->paginate(15);
        return view('admin.produits.index', compact('produits'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $sponsors = Sponsor::active()->get();
        $categories = ['Merchandising', 'Équipement', 'Nourriture', 'Boissons', 'Accessoires', 'Autre'];
        return view('admin.produits.create', compact('sponsors', 'categories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string',
            'is_available' => 'boolean',
            'sponsor_id' => 'nullable|exists:sponsors,id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($validated);

        return redirect()->route('produits.index')
            ->with('success', 'Produit ajouté avec succès!');
    }

    /**
     * Display the specified product
     */
    public function show(Produit $produit)
    {
        $produit->load('sponsor');
        return view('admin.produits.show', compact('produit'));
    }

    /**
     * Show the form for editing the product
     */
    public function edit(Produit $produit)
    {
        $sponsors = Sponsor::active()->get();
        $categories = ['Merchandising', 'Équipement', 'Nourriture', 'Boissons', 'Accessoires', 'Autre'];
        return view('admin.produits.edit', compact('produit', 'sponsors', 'categories'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string',
            'is_available' => 'boolean',
            'sponsor_id' => 'nullable|exists:sponsors,id',
        ]);

        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($validated);

        return redirect()->route('produits.index')
            ->with('success', 'Produit mis à jour avec succès!');
    }

    /**
     * Remove the specified product
     */
    public function destroy(Produit $produit)
    {
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();

        return redirect()->route('produits.index')
            ->with('success', 'Produit supprimé avec succès!');
    }

    /**
     * Display products for public viewing
     */
    public function publicIndex(Request $request)
    {
        $query = Produit::with('sponsor')->available();

        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $produits = $query->latest()->paginate(12);
        $categories = Produit::distinct()->pluck('category');

        return view('produits.index', compact('produits', 'categories'));
    }

    /**
     * Show product details to public
     */
    public function publicShow(Produit $produit)
    {
        $produit->load('sponsor');
        $relatedProducts = Produit::where('category', $produit->category)
            ->where('id', '!=', $produit->id)
            ->available()
            ->limit(4)
            ->get();

        return view('produits.show', compact('produit', 'relatedProducts'));
    }
}
```

---

## 📝 MaterielController.php

Replace the content of `app/Http/Controllers/MaterielController.php` with:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterielController extends Controller
{
    /**
     * Display a listing of materials (Admin)
     */
    public function index()
    {
        $materiels = Materiel::with('event')->latest()->paginate(15);
        return view('admin.materiels.index', compact('materiels'));
    }

    /**
     * Show the form for creating a new material
     */
    public function create()
    {
        $events = Event::where('status', 'approved')->get();
        $types = ['Équipement', 'Mobilier', 'Électronique', 'Décoration', 'Sonorisation', 'Éclairage', 'Autre'];
        $conditions = ['good' => 'Bon état', 'fair' => 'État correct', 'poor' => 'Mauvais état'];
        
        return view('admin.materiels.create', compact('events', 'types', 'conditions'));
    }

    /**
     * Store a newly created material
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'condition' => 'required|in:good,fair,poor',
            'value' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
            'event_id' => 'nullable|exists:events,id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('materiels', 'public');
        }

        Materiel::create($validated);

        return redirect()->route('materiels.index')
            ->with('success', 'Matériel ajouté avec succès!');
    }

    /**
     * Display the specified material
     */
    public function show(Materiel $materiel)
    {
        $materiel->load('event');
        return view('admin.materiels.show', compact('materiel'));
    }

    /**
     * Show the form for editing the material
     */
    public function edit(Materiel $materiel)
    {
        $events = Event::where('status', 'approved')->get();
        $types = ['Équipement', 'Mobilier', 'Électronique', 'Décoration', 'Sonorisation', 'Éclairage', 'Autre'];
        $conditions = ['good' => 'Bon état', 'fair' => 'État correct', 'poor' => 'Mauvais état'];
        
        return view('admin.materiels.edit', compact('materiel', 'events', 'types', 'conditions'));
    }

    /**
     * Update the specified material
     */
    public function update(Request $request, Materiel $materiel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'condition' => 'required|in:good,fair,poor',
            'value' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
            'event_id' => 'nullable|exists:events,id',
        ]);

        if ($request->hasFile('image')) {
            if ($materiel->image) {
                Storage::disk('public')->delete($materiel->image);
            }
            $validated['image'] = $request->file('image')->store('materiels', 'public');
        }

        $materiel->update($validated);

        return redirect()->route('materiels.index')
            ->with('success', 'Matériel mis à jour avec succès!');
    }

    /**
     * Remove the specified material
     */
    public function destroy(Materiel $materiel)
    {
        if ($materiel->image) {
            Storage::disk('public')->delete($materiel->image);
        }

        $materiel->delete();

        return redirect()->route('materiels.index')
            ->with('success', 'Matériel supprimé avec succès!');
    }
}
```

---

## 📝 PanierController.php

Replace the content of `app/Http/Controllers/PanierController.php` with:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $paniers = Auth::user()->activePaniers()->with('produit')->get();
        $total = $paniers->sum('subtotal');
        
        return view('panier.index', compact('paniers', 'total'));
    }

    /**
     * Add product to cart
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $produit = Produit::findOrFail($validated['produit_id']);

        // Check stock
        if ($produit->stock < $validated['quantity']) {
            return back()->with('error', 'Stock insuffisant!');
        }

        // Check if product already in cart
        $existingPanier = Panier::where('user_id', Auth::id())
            ->where('produit_id', $produit->id)
            ->where('status', 'pending')
            ->first();

        if ($existingPanier) {
            // Update quantity
            $newQuantity = $existingPanier->quantity + $validated['quantity'];
            
            if ($produit->stock < $newQuantity) {
                return back()->with('error', 'Stock insuffisant!');
            }
            
            $existingPanier->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            Panier::create([
                'user_id' => Auth::id(),
                'produit_id' => $produit->id,
                'quantity' => $validated['quantity'],
                'price' => $produit->price,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('panier.index')
            ->with('success', 'Produit ajouté au panier!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, Panier $panier)
    {
        // Check ownership
        if ($panier->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check stock
        if ($panier->produit->stock < $validated['quantity']) {
            return back()->with('error', 'Stock insuffisant!');
        }

        $panier->update($validated);

        return back()->with('success', 'Panier mis à jour!');
    }

    /**
     * Remove item from cart
     */
    public function destroy(Panier $panier)
    {
        // Check ownership
        if ($panier->user_id !== Auth::id()) {
            abort(403);
        }

        $panier->delete();

        return back()->with('success', 'Produit retiré du panier!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Auth::user()->activePaniers()->delete();

        return back()->with('success', 'Panier vidé!');
    }

    /**
     * Checkout (place order)
     */
    public function checkout(Request $request)
    {
        $paniers = Auth::user()->activePaniers()->with('produit')->get();

        if ($paniers->isEmpty()) {
            return back()->with('error', 'Votre panier est vide!');
        }

        // Check stock for all items
        foreach ($paniers as $panier) {
            if ($panier->produit->stock < $panier->quantity) {
                return back()->with('error', "Stock insuffisant pour {$panier->produit->name}!");
            }
        }

        // Update stock and mark as ordered
        foreach ($paniers as $panier) {
            $produit = $panier->produit;
            $produit->decrement('stock', $panier->quantity);
            $panier->update(['status' => 'ordered']);
        }

        return redirect()->route('panier.index')
            ->with('success', 'Commande passée avec succès!');
    }
}
```

---

## ✅ Controllers Complete!

All 4 controllers are now fully implemented with:
- ✅ Full CRUD operations
- ✅ Image upload handling
- ✅ Validation
- ✅ Authorization checks
- ✅ Stock management (for products/cart)
- ✅ Public and admin views
- ✅ Relationship loading

**Next:** Routes configuration and Views creation

Continue to **COMPLETE_IMPLEMENTATION_PART2.md** for Routes and Views!
