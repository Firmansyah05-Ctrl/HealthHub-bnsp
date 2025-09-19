<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tambahkan method index() yang missing
    public function index()
    {
        $cartItems = session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('products.index')->with('info', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }
        
        // Hitung subtotal
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // Hitung biaya tambahan sesuai dengan cart
        $shippingCost = $subtotal >= 1000000 ? 0 : 15000; // Gratis ongkir untuk pembelian >= 1 juta
        $adminFee = 2000; // Biaya admin tetap
        $tax = $subtotal * 0.01; // Pajak 1%
        
        // Total akhir
        $total = $subtotal + $shippingCost + $adminFee + $tax;
        
        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'adminFee', 'tax', 'total'));
    }

    public function store(Request $request)
{
    $cartItems = session()->get('cart', []);
    
    if (empty($cartItems)) {
        return redirect()->back()->with('error', 'Your cart is empty!');
    }
    
    // Hitung subtotal
    $subtotal = 0;
    foreach ($cartItems as $id => $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    
    // Hitung biaya tambahan sesuai dengan cart
    $shippingCost = $subtotal >= 1000000 ? 0 : 15000;
    $adminFee = 2000;
    $tax = $subtotal * 0.01;
    
    // Total akhir
    $totalAmount = $subtotal + $shippingCost + $adminFee + $tax;
    
    $order = Order::create([
        'user_id' => Auth::id(),
        'total_amount' => $totalAmount,
        'payment_method' => $request->payment_method,
        'status' => 'Pending',
    ]);
    
    foreach ($cartItems as $id => $item) {
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $id,
            'quantity' => $item['quantity'],
            'price_per_item' => $item['price'],
        ]);
    }
    
    session()->forget('cart');
    
    $pdf = Pdf::loadView('pdf.invoice', compact('order'));

    // Kirim email dengan PDF terlampir
    Mail::to($order->user->email)->send(new OrderInvoiceMail($order, $pdf));
    
    // Simpan PDF path untuk download later
    $pdfPath = 'invoice-'.$order->id.'.pdf';
    session()->put('download_invoice', [
        'pdf' => $pdf->output(),
        'filename' => $pdfPath,
        'order_id' => $order->id
    ]);
    
    // Redirect ke success page yang akan handle download dan redirect
    return redirect()->route('orders.success', $order->id)->with('success', 'Pesanan berhasil dibuat! Invoice akan didownload otomatis.');
}
    
    public function success(Order $order)
    {
        return view('orders.success', compact('order'));
    }
}