<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    // Admin: List all products
    public function index(Request $request)
    {
        $query = Produit::with('sponsor');

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Stock status filter
        if ($request->has('stock_status') && $request->stock_status) {
            if ($request->stock_status === 'in_stock') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock', '=', 0);
            }
        }

        $produits = $query->paginate(10)->withQueryString();
        $categories = Produit::select('category')->distinct()->pluck('category');
        
        return view('admin.produits.index', compact('produits', 'categories'));
    }

    // Admin: Show create form
    public function create()
    {
        $sponsors = Sponsor::where('is_active', true)->get();
        return view('admin.produits.create', compact('sponsors'));
    }

    // Admin: Store new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sponsor_id' => 'nullable|exists:sponsors,id',
            'is_available' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($validated);

        return redirect()->route('admin.produits.index')->with('success', 'Produit créé avec succès!');
    }

    // Admin: Show single product
    public function show(Produit $produit)
    {
        $produit->load('sponsor');
        return view('admin.produits.show', compact('produit'));
    }

    // Admin: Show edit form
    public function edit(Produit $produit)
    {
        $sponsors = Sponsor::where('is_active', true)->get();
        return view('admin.produits.edit', compact('produit', 'sponsors'));
    }

    // Admin: Update product
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sponsor_id' => 'nullable|exists:sponsors,id',
            'is_available' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($validated);

        return redirect()->route('admin.produits.index')->with('success', 'Produit mis à jour avec succès!');
    }

    // Admin: Delete product
    public function destroy(Produit $produit)
    {
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }
        
        $produit->delete();

        return redirect()->route('admin.produits.index')->with('success', 'Produit supprimé avec succès!');
    }

    // Public: List products for customers
    public function publicIndex(Request $request)
    {
        $query = Produit::available()->inStock()->with('sponsor');

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by sponsor
        if ($request->has('sponsor_id') && $request->sponsor_id) {
            $query->where('sponsor_id', $request->sponsor_id);
        }

        $produits = $query->paginate(12);
        $categories = Produit::select('category')->distinct()->pluck('category');
        $sponsors = Sponsor::where('is_active', true)->get();

        return view('produits.index', compact('produits', 'categories', 'sponsors'));
    }

    // Public: Show single product
    public function publicShow(Produit $produit)
    {
        $produit->load('sponsor');
        $relatedProducts = Produit::available()
            ->inStock()
            ->where('category', $produit->category)
            ->where('id', '!=', $produit->id)
            ->limit(4)
            ->get();

        return view('produits.show', compact('produit', 'relatedProducts'));
    }
}
