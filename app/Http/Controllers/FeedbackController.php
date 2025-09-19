<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Form create feedback untuk order tertentu.
     */
    public function create(Order $order)
    {
        // Pastikan order milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Pastikan order dapat menerima feedback
        if (!$order->canReceiveFeedback()) {
            return redirect()->route('dashboard')
                ->with('error', $order->hasFeedback() ? 'Anda sudah memberikan feedback untuk pesanan ini.' : 'Feedback hanya dapat diberikan untuk pesanan yang sudah diterima atau selesai.');
        }

        // Load order items untuk ditampilkan di form
        $order->load('orderItems.product');
        
        return view('feedback.create', compact('order'));
    }

    /**
     * Simpan feedback dari user.
     */
    public function store(Request $request, Order $order)
    {
        // Pastikan order milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Pastikan order dapat menerima feedback
        if (!$order->canReceiveFeedback()) {
            return redirect()->route('dashboard')
                ->with('error', $order->hasFeedback() ? 'Anda sudah memberikan feedback untuk pesanan ini.' : 'Feedback hanya dapat diberikan untuk pesanan yang sudah diterima atau selesai.');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Feedback::create([
            'order_id' => $order->id,
            'user_id'  => Auth::id(),
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Terima kasih! Feedback berhasil dikirim.');
    }

    /**
     * Tampilkan feedback yang sudah diberikan untuk order tertentu.
     */
    public function show(Order $order)
    {
        // Pastikan order milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Pastikan feedback ada
        if (!$order->feedback) {
            return redirect()->route('dashboard')
                ->with('error', 'Feedback tidak ditemukan untuk pesanan ini.');
        }

        $order->load(['orderItems.product', 'feedback']);
        
        return view('feedback.show', compact('order'));
    }
}
