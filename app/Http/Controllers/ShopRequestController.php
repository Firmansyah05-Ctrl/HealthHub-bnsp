<?php

namespace App\Http\Controllers;

use App\Models\ShopRequest;
use Illuminate\Http\Request;

class ShopRequestController extends Controller
{
    /**
     * Tampilkan semua shop request milik user yang login.
     */
    public function index()
    {
        $requests = ShopRequest::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('shop_requests.index', compact('requests'));
    }

    /**
     * Form untuk ajukan request baru.
     */
    public function create()
    {
        return view('shop_requests.create');
    }

    /**
     * Simpan request baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ShopRequest::create([
            'user_id'     => auth()->id(),
            'shop_name'   => $request->shop_name,
            'description' => $request->description,
            'status'      => 'pending',
        ]);

        return redirect()->route('shop-requests.index')
            ->with('success', 'Permintaan pembuatan toko berhasil diajukan, menunggu persetujuan admin.');
    }
}
