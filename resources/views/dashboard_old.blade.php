@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-6">
    <h1 class="text-3xl font-bold text-green-700 mb-6">Dashboard Saya</h1>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-100 border border-green-200 text-green-700 p-3">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-md bg-red-100 border border-red-200 text-red-700 p-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('shop-requests.index') }}"
           class="inline-block px-5 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
            Ajukan Toko Baru
        </a>
    </div>
    
    {{-- Orders Table --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Produk</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Total</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->created_at->format('d/m/Y') }}</td>
                        
                        {{-- Produk --}}
                        <td class="px-6 py-4 text-sm text-gray-700">
                            @if($order->orderItems->count())
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($order->orderItems as $item)
                                        <li>
                                            {{ $item->product->name ?? 'Produk dihapus' }} 
                                            <span class="text-gray-500">(x{{ $item->quantity }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-sm">
                            @if($order->status === 'Pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                    {{ $order->status }}
                                </span>
                            @elseif($order->status === 'Processing')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-700">
                                    {{ $order->status }}
                                </span>
                            @elseif($order->status === 'Cancelled')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-700">
                                    {{ $order->status }}
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-700">
                                    {{ $order->status }}
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-center">
                            @if(in_array($order->status, ['Pending','Shipped']))
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" 
                                    onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                        Batalkan
                                    </button>
                                </form>
                            @elseif($order->status === 'Delivered')
                                @if(!$order->feedbacks)
                                    <a href="{{ route('feedback.create', $order->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                        Beri Feedback
                                    </a>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-700">
                                        Sudah Feedback
                                    </span>
                                @endif
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada order.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
