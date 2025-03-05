<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Order #{{ $order->order_number }}</title>
    <style>
        @page {
            size: 80mm 210mm;
            /* Ukuran kertas thermal printer */
            margin: 0;
        }

        body {
            font-family: monospace;
            font-size: 12px;
            line-height: 1.5;
            padding: 10px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed black;
            margin: 5px 0;
        }

        .right {
            text-align: right;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
        }
        
        .nomerOrder {
            font-size: 14px;
            font-weight: bold;
            color: red;
        }
        
        .free-shipping {
            font-weight: bold;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="center">
        <h2>PT. Apotek Amanah</h2>
        <p>Jl. Ibu Apipah No. 06, Kota Tasikmalaya</p>
        <p>Telp: 085123456789</p>
        <p class="bold">*** STRUK PEMBELIAN ***</p>
    </div>

    <p>No. Order: <span class="bold nomerOrder">{{ $order->order_number }}</span></p>
    <p>Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p>Pelanggan: {{ optional($order->user)->name }}</p>

    <div class="divider"></div>

    <p class="bold">Detail Pembelian:</p>

    @foreach ($order->items as $item)
        <p>
            {{ $item->obat->nama }}
            <br> {{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }} =
            <span class="right">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </p>
    @endforeach

    <div class="divider"></div>

    <p>Subtotal <span class="right">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span></p>

    @if ($order->payment_method !== 'cop')
        <p>Ongkir 
            <span class="right">
                @if ($order->total_amount >= 100000)
                    <span class="free-shipping">Gratis Ongkir</span>
                @else
                    Rp{{ number_format($order->shipping_fee ?? 10000, 0, ',', '.') }}
                @endif
            </span>
        </p>
    @endif

    @if ($order->payment_method === 'cod')
        <p>Biaya COD <span class="right">Rp{{ number_format($order->handling_fee ?? 1000, 0, ',', '.') }}</span></p>
    @endif

    <div class="divider"></div>

    @php
        $shippingCost = ($order->payment_method !== 'cop') ? ($order->total_amount >= 100000 ? 0 : ($order->shipping_fee ?? 10000)) : 0;
        $handlingFee = ($order->payment_method === 'cod') ? ($order->handling_fee ?? 1000) : 0;
        $totalAmount = $order->total_amount + $shippingCost + $handlingFee;
    @endphp

    <p class="total">Total Bayar <span class="right">Rp{{ number_format($totalAmount, 0, ',', '.') }}</span></p>

    <div class="divider"></div>

    <p>Metode Pembayaran:
        <span class="bold">
            @if ($order->payment_method === 'cop')
                Cash On Pickup
            @elseif ($order->payment_method === 'cod')
                Cash On Delivery
            @else
                Transfer Bank
            @endif
        </span>
    </p>

    @if ($order->payment_method === 'transfer')
        <p class="bold">Silakan Transfer ke:</p>
        <p>Bank: BCA</p>
        <p>No. Rek: 1234567890</p>
        <p>Atas Nama: PT. Apotek Amanah</p>
        <p class="bold">Total: Rp{{ number_format($totalAmount, 0, ',', '.') }}</p>
        <p class="bold">* Gunakan nomor order ({{ $order->order_number }}) sebagai berita transfer</p>
    @endif

    @if ($order->payment_method === 'cod')
        <p class="bold">Pesanan akan dikirim ke:</p>
        <p>{{ $order->shipping_address ?? '-' }}</p>
        <p>Telp: {{ optional($order->user)->phone }}</p>
    @endif

    @if ($order->payment_method === 'cop')
        <p class="bold">Silakan ambil pesanan di:</p>
        <p>Apotek Amanah, Jalan Ibu Apipah No. 06</p>
        <p class="bold">Bawa nomor order Anda: <span class="nomerOrder"> {{ $order->order_number }} </span></p>
    @endif

    @if ($order->total_amount >= 100000 && $order->payment_method !== 'cop')
        <div class="divider"></div>
        <p class="center bold">* FREE SHIPPING untuk pembelian di atas Rp100.000 *</p>
    @endif

    <div class="divider"></div>

    <div class="center">
        <p>*** TERIMA KASIH ***</p>
        <p>Semoga Lekas Sembuh!</p>
    </div>

</body>

</html>