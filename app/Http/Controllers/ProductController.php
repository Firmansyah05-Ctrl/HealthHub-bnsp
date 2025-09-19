<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Cache categories with product counts for better performance
        $categories = Cache::remember('categories_with_count', 3600, function () {
            return Category::withCount('products')->orderBy('name')->get();
        });
        
        $selectedCategory = $request->category;
        $sortBy = $request->get('sort', 'newest');
        
        // Get total products count
        $totalProducts = Product::count();
        
        // Build optimized query with eager loading
        $productsQuery = Product::with('category')
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                return $query->whereHas('category', function ($q) use ($selectedCategory) {
                    $q->where('slug', $selectedCategory);
                });
            });
            
        // Apply sorting
        switch ($sortBy) {
            case 'price_low':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_high':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $productsQuery->paginate(12);

        return view('products.index', compact('products', 'categories', 'selectedCategory', 'totalProducts'));
    }

    /**
     * Show a specific product (future feature)
     */
    public function show(Product $product)
    {
        $product->load('category');
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Search products (future feature)
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return redirect()->route('products.index');
        }

        $products = Product::with('category')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->orderBy('name')
            ->paginate(12);

        $categories = Cache::remember('categories', 3600, function () {
            return Category::orderBy('name')->get();
        });

        return view('products.index', compact('products', 'categories', 'query'))
            ->with('selectedCategory', null);
    }
}