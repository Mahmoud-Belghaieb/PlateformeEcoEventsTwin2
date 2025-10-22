<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    // Display user's cart
    public function index()
    {
        $paniers = Panier::with('produit')
            ->pending()
            ->forUser(Auth::id())
            ->get();

        $total = $paniers->sum(function ($item) {
            return $item->subtotal;
        });

        return view('panier.index', compact('paniers', 'total'));
    }

    // Add product to cart
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $produit = Produit::findOrFail($validated['produit_id']);

        // Check stock availability
        if ($produit->stock < $validated['quantity']) {
            return back()->with('error', 'Stock insuffisant pour ce produit.');
        }

        // Check if product already in cart
        $existingItem = Panier::where('user_id', Auth::id())
            ->where('produit_id', $validated['produit_id'])
            ->where('status', 'pending')
            ->first();

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->quantity + $validated['quantity'];

            if ($produit->stock < $newQuantity) {
                return back()->with('error', 'Stock insuffisant pour cette quantité.');
            }

            $existingItem->update([
                'quantity' => $newQuantity,
                'price' => $produit->price,
            ]);
        } else {
            // Create new cart item
            Panier::create([
                'user_id' => Auth::id(),
                'produit_id' => $validated['produit_id'],
                'quantity' => $validated['quantity'],
                'price' => $produit->price,
                'status' => 'pending',
            ]);
        }

        return back()->with('success', 'Produit ajouté au panier!');
    }

    // Update cart item quantity
    public function update(Request $request, Panier $panier)
    {
        // Check ownership
        if ($panier->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check stock availability
        if ($panier->produit->stock < $validated['quantity']) {
            return back()->with('error', 'Stock insuffisant pour cette quantité.');
        }

        $panier->update([
            'quantity' => $validated['quantity'],
            'price' => $panier->produit->price,
        ]);

        return back()->with('success', 'Quantité mise à jour!');
    }

    // Remove item from cart
    public function destroy(Panier $panier)
    {
        // Check ownership
        if ($panier->user_id !== Auth::id()) {
            abort(403);
        }

        $panier->delete();

        return back()->with('success', 'Produit retiré du panier!');
    }

    // Clear entire cart
    public function clear()
    {
        Panier::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->delete();

        return back()->with('success', 'Panier vidé!');
    }

    // Checkout - mark items as ordered
    public function checkout()
    {
        $paniers = Panier::with('produit')
            ->pending()
            ->forUser(Auth::id())
            ->get();

        if ($paniers->isEmpty()) {
            return back()->with('error', 'Votre panier est vide.');
        }

        // Check stock and update
        foreach ($paniers as $item) {
            if ($item->produit->stock < $item->quantity) {
                return back()->with('error', "Stock insuffisant pour {$item->produit->name}.");
            }

            // Decrease stock
            $item->produit->decrement('stock', $item->quantity);

            // Mark as ordered
            $item->update(['status' => 'ordered']);
        }

        return redirect()->route('panier.index')->with('success', 'Commande passée avec succès!');
    }

    // Admin Methods

    // Display all cart orders (admin)
    public function adminIndex()
    {
        $paniers = Panier::with(['user', 'produit'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total_orders' => Panier::where('status', 'ordered')->count(),
            'pending_carts' => Panier::where('status', 'pending')->count(),
            'total_revenue' => Panier::where('status', 'ordered')->get()->sum('subtotal'),
            'total_items' => Panier::sum('quantity'),
        ];

        return view('admin.panier.index', compact('paniers', 'stats'));
    }

    // Show cart order details (admin)
    public function adminShow(Panier $panier)
    {
        $panier->load(['user', 'produit']);

        return view('admin.panier.show', compact('panier'));
    }

    // Update order status (admin)
    public function updateStatus(Request $request, Panier $panier)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,ordered,cancelled',
        ]);

        $oldStatus = $panier->status;
        $panier->update(['status' => $validated['status']]);

        // If changing from ordered to cancelled, restore stock
        if ($oldStatus === 'ordered' && $validated['status'] === 'cancelled') {
            $panier->produit->increment('stock', $panier->quantity);
        }

        // If changing from cancelled to ordered, decrease stock
        if ($oldStatus === 'cancelled' && $validated['status'] === 'ordered') {
            if ($panier->produit->stock < $panier->quantity) {
                return back()->with('error', 'Stock insuffisant pour ce produit.');
            }
            $panier->produit->decrement('stock', $panier->quantity);
        }

        return back()->with('success', 'Statut mis à jour avec succès!');
    }

    // Delete cart order (admin)
    public function adminDestroy(Panier $panier)
    {
        // If order was ordered, restore stock
        if ($panier->status === 'ordered') {
            $panier->produit->increment('stock', $panier->quantity);
        }

        $panier->delete();

        return redirect()->route('admin.panier.index')->with('success', 'Commande supprimée avec succès!');
    }

    // Display user's order history (public)
    public function orders()
    {
        $orders = Panier::with('produit')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['ordered', 'cancelled'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $stats = [
            'total_orders' => $orders->where('status', 'ordered')->count(),
            'cancelled_orders' => $orders->where('status', 'cancelled')->count(),
            'total_spent' => $orders->where('status', 'ordered')->sum('subtotal'),
            'total_items' => $orders->where('status', 'ordered')->sum('quantity'),
        ];

        return view('panier.orders', compact('orders', 'stats'));
    }
}
