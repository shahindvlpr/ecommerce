<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f8f9fa; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { text-align: center; border-bottom: 2px solid #8b5cf6; padding-bottom: 20px; margin-bottom: 20px; }
        .company { font-size: 28px; color: #8b5cf6; font-weight: bold; }
        .invoice-title { font-size: 22px; margin: 10px 0; }
        .badge { background: #8b5cf6; color: white; padding: 4px 12px; border-radius: 20px; display: inline-block; font-size: 12px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0; }
        .info-section h3 { font-size: 14px; color: #6b7280; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-section p { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; border: 1px solid #e5e7eb; text-align: left; }
        th { background: #f8fafc; font-weight: 600; }
        .text-end { text-align: right; }
        .total-row { font-weight: bold; }
        .grand-total { font-size: 20px; color: #8b5cf6; }
        .footer { text-align: center; margin-top: 30px; color: #9ca3af; font-size: 12px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <div class="company">🛍️ EktaMart</div>
            <div class="invoice-title">INVOICE</div>
            <p>
                <strong>Invoice #:</strong> {{ $order->order_number }}
                <span style="margin-left: 20px;">
                    <strong>Date:</strong> {{ $order->created_at->format('d M Y') }}
                </span>
                <span style="margin-left: 20px;">
                    <span class="badge">{{ ucfirst($order->status) }}</span>
                </span>
            </p>
        </div>

        {{-- Customer & Order Info --}}
        <div class="info-grid">
            <div class="info-section">
                <h3>Bill To</h3>
                <p><strong>{{ $order->user->name ?? 'Guest' }}</strong></p>
                <p>{{ $order->user->email ?? 'N/A' }}</p>
                <p>{{ $order->phone ?? 'N/A' }}</p>
                <p>{{ $order->shipping_address ?? 'N/A' }}</p>
            </div>
            <div class="info-section">
                <h3>Order Details</h3>
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status ?? 'pending') }}</p>
            </div>
        </div>

        {{-- Order Items --}}
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th class="text-end">Price</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name ?? 'Product' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-end">${{ number_format($item->price, 2) }}</td>
                    <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end">Subtotal</td>
                    <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">Shipping</td>
                    <td class="text-end">${{ number_format($order->shipping_cost ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">Tax</td>
                    <td class="text-end">${{ number_format($order->tax ?? 0, 2) }}</td>
                </tr>
                @if($order->discount > 0)
                <tr>
                    <td colspan="4" class="text-end">Discount</td>
                    <td class="text-end">-${{ number_format($order->discount, 2) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td colspan="4" class="text-end grand-total">Grand Total</td>
                    <td class="text-end grand-total">${{ number_format($order->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        {{-- Footer --}}
        <div class="footer">
            <p>Thank you for shopping with EktaMart!</p>
            <p>Visit us at: <a href="{{ route('home') }}">ektamart.com</a></p>
            <p style="margin-top: 5px;">
                <small>This is a system generated invoice. No signature required.</small>
            </p>
        </div>
    </div>
</body>
</html>