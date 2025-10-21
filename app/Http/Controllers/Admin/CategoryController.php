<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('events')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'description', 'color', 'icon']);
        
        // Generate slug from name
        $data['slug'] = Str::slug($request->name);
        
        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        // Handle is_active checkbox
        $data['is_active'] = $request->has('is_active') ? true : false;

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'description', 'color', 'icon']);
        
        // Update slug only if name changed
        if ($request->name !== $category->name) {
            $data['slug'] = Str::slug($request->name);
            
            // Ensure slug is unique (excluding current category)
            $originalSlug = $data['slug'];
            $counter = 1;
            while (Category::where('slug', $data['slug'])->where('id', '!=', $category->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }
        
        // Handle is_active checkbox
        $data['is_active'] = $request->has('is_active') ? true : false;

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has events
        if ($category->events()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category that has events associated with it.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
