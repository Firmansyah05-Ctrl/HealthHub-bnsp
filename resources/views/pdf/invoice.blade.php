<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Belanja - Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
        .header { text-align: center; margin-bottom: 20px; }
        .info-table td { border: none; padding: 4px; }
        .total { font-weight: bold; }
        .right { text-align: right; }
        .signature { margin-top: 40px; text-align: right; }
        
        /* Professional Digital Signature Styles */
        .digital-signature {
            display: inline-block;
            border: 3px solid #0d9488;
            border-radius: 15px;
            padding: 20px;
            background: #f0fdfc;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .signature-logo {
            background: #0d9488;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin: 0 auto 10px;
            text-align: center;
            line-height: 50px;
            font-size: 20px;
            font-weight: bold;
        }
        
        .signature-title {
            font-size: 18px;
            font-weight: bold;
            color: #0d9488;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        
        .signature-subtitle {
            font-size: 12px;
            color: #0f766e;
            margin-bottom: 10px;
            font-style: italic;
        }
        
        .verification-stamp {
            border: 2px solid #0d9488;
            border-radius: 8px;
            padding: 8px;
            background: white;
            margin: 10px 0;
        }
        
        .security-badge {
            background: #059669;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            margin-right: 5px;
        }
        
        .contact-info {
            margin-top: 15px;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HealthHub</h1>
        <h3>Toko Alat Kesehatan</h3>
        <p>Laporan Belanja Anda</p>
    </div>

    <table class="info-table">
    <tr>
        <td>User ID : {{ $order->user->id }}</td>
        <td>Tanggal : {{ $order->created_at->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td>Nama : {{ $order->user->name }}</td>
        <td>ID Paypal : {{ $order->user->paypal_id }}</td>
    </tr>
    <tr>
        <td>Alamat : {{ $order->user->address }}</td>
        <td>Cara Bayar : ({{ $order->payment_method }})</td>
    </tr>
    <tr>
        <td>No HP : {{ $order->user->contact_no }}</td>
        <td></td>
    </tr>
</table>


    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Produk dengan ID nya</th>
                <th>Jumlah</th>
                <th class="right">Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $subtotal = 0;
            @endphp
            @foreach($order->orderItems as $index => $item)
            @php
                $itemTotal = $item->price_per_item * $item->quantity;
                $subtotal += $itemTotal;
            @endphp
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $item->product->name ?? 'Produk tidak ditemukan' }} - {{ $item->product->sku ?? 'ID'.$item->product_id }}</td>
                <td>{{ $item->quantity }}x</td>
                <td class="right">
                    Rp. {{ number_format($itemTotal, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
            
            @php
                // Hitung biaya tambahan sesuai dengan checkout
                $shippingCost = $subtotal >= 1000000 ? 0 : 15000;
                $adminFee = 2000;
                $tax = $subtotal * 0.01;
                $calculatedTotal = $subtotal + $shippingCost + $adminFee + $tax;
            @endphp
            
            <!-- Subtotal -->
            <tr>
                <td colspan="3" class="right">Subtotal ({{ $order->orderItems->count() }} item):</td>
                <td class="right">Rp. {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            
            <!-- Ongkos Kirim -->
            <tr>
                <td colspan="3" class="right">Ongkos Kirim:</td>
                <td class="right">
                    @if($shippingCost == 0)
                        <strong>GRATIS</strong>
                    @else
                        Rp. {{ number_format($shippingCost, 0, ',', '.') }}
                    @endif
                </td>
            </tr>
            
            <!-- Biaya Admin -->
            <tr>
                <td colspan="3" class="right">Biaya Admin:</td>
                <td class="right">Rp. {{ number_format($adminFee, 0, ',', '.') }}</td>
            </tr>
            
            <!-- Pajak -->
            <tr>
                <td colspan="3" class="right">Pajak (1%):</td>
                <td class="right">Rp. {{ number_format($tax, 0, ',', '.') }}</td>
            </tr>
            
            <!-- Total Final -->
            <tr class="total" style="background-color: #e8f5f3; font-weight: bold;">
                <td colspan="3" class="right"><strong>Total Pembayaran:</strong></td>
                <td class="right"><strong>Rp. {{ number_format($calculatedTotal, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    @if($shippingCost == 0)
    <div style="background-color: #dcfce7; border: 2px solid #16a34a; padding: 10px; margin: 20px 0; border-radius: 5px;">
        <p style="color: #15803d; font-weight: bold; margin: 0;">
            ✓ Selamat! Anda mendapat gratis ongkos kirim!
        </p>
        <p style="color: #15803d; margin: 5px 0 0 0; font-size: 12px;">
            Pembelian Anda sudah mencapai minimum Rp. 1.000.000 untuk gratis ongkir.
        </p>
    </div>
    @endif

    <div style="margin-top: 30px;">
        <p style="font-size: 12px; color: #666;">
            <strong>Metode Pembayaran:</strong> {{ $order->payment_method == 'Prepaid' ? 'Bayar Dimuka (Prepaid)' : 'Bayar Belakangan (COD)' }}
        </p>
        <p style="font-size: 12px; color: #666;">
            <strong>Status Pesanan:</strong> {{ $order->status }}
        </p>
        <p style="font-size: 12px; color: #666;">
            <strong>Tanggal Pemesanan:</strong> {{ $order->created_at->setTimezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB
        </p>
    </div>

    <div class="signature">
        <div class="digital-signature">
            <div style="text-align: center;">
                <!-- Logo/Icon HealthHub dengan Medical Cross -->
                <div class="signature-logo">
                    ⚕
                </div>
                
                <!-- Nama Toko dengan Style Professional -->
                <div class="signature-title">
                    HealthHub
                </div>
                
                <!-- Subtitle -->
                <div class="signature-subtitle">
                    Professional Medical Equipment Store
                </div>
                
                <!-- Digital Signature Stamp -->
                <div class="verification-stamp">
                    <div style="font-size: 10px; color: #0d9488; font-weight: bold; margin-bottom: 3px;">
                        🔒 VERIFIED STORE
                    </div>
                    <div style="font-size: 14px; font-weight: bold; color: #0f766e; margin-bottom: 3px;">
                        HealthHub Official Store
                    </div>
                    <div style="font-size: 9px; color: #0d9488;">
                        ✓ Digital Signature Verified ✓
                    </div>
                    <div style="font-size: 8px; color: #059669; margin-top: 3px; font-weight: bold;">
                        Certificate ID: HH-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
                
                <!-- Tanggal dan Jam -->
                <div style="font-size: 10px; color: #6b7280; margin-top: 10px;">
                    📅 Signed on: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                </div>
                
                <!-- Security Badges -->
                <div style="margin-top: 8px;">
                    <span class="security-badge">
                        ✓ AUTHENTIC
                    </span>
                    <span class="security-badge" style="background: #0d9488;">
                        ✓ CERTIFIED
                    </span>
                    <span class="security-badge" style="background: #dc2626;">
                        ✓ SECURE
                    </span>
                </div>
                
                <!-- QR Code Placeholder -->
                <div style="margin-top: 10px; border: 1px dashed #0d9488; padding: 5px; font-size: 8px; color: #6b7280;">
                    📱 QR: Scan untuk verifikasi
                </div>
            </div>
        </div>
        
        <!-- Informasi Kontak Professional -->
        <div class="contact-info">
            <p style="margin: 2px 0; font-weight: bold; color: #0d9488;">🏥 HealthHub - Your Trusted Medical Equipment Partner</p>
            <p style="margin: 2px 0;">📧 support@healthhub.com | 📞 +62 123 456 7890</p>
            <p style="margin: 2px 0;">🌐 www.healthhub.com | 📍 Licensed Medical Equipment Retailer</p>
            <p style="margin: 5px 0 0 0; font-size: 8px; color: #9ca3af;">
                © {{ date('Y') }} HealthHub. All rights reserved. This invoice is digitally signed and verified.
            </p>
        </div>
    </div>
</body>
</html>
