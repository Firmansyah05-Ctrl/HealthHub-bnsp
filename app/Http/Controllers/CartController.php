<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $total = 0;
        
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:99'
        ]);

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);
        $quantity = $request->quantity ?? 1;
        
        // Check if product already exists in cart
        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            if ($newQuantity > 99) {
                return redirect()->back()->with('error', 'Maximum quantity limit exceeded (99 items per product).');
            }
            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'image_url' => $product->image_url,
                'quantity' => $quantity,
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', "'{$product->name}' has been added to your cart!");
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            // Handle AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart quantity updated successfully!',
                    'cartCount' => count($cart),
                    'subtotal' => array_sum(array_map(function($item) {
                        return $item['price'] * $item['quantity'];
                    }, $cart))
                ]);
            }
            
            return redirect()->back()->with('success', 'Cart quantity updated successfully!');
        }
        
        // Handle AJAX request for error
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart!'
            ], 404);
        }
        
        return redirect()->back()->with('error', 'Product not found in cart!');
    }

    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Product removed from cart successfully!');
        }
        
        return redirect()->back()->with('error', 'Product not found in cart!');
    }
}