<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; }
        .header { text-align: center; border-bottom: 2px solid #667eea; padding-bottom: 20px; margin-bottom: 20px; }
        .company { font-size: 28px; color: #667eea; font-weight: bold; }
        .invoice-title { font-size: 22px; margin: 10px 0; }
        .details { margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #f8f9fa; }
        .total { text-align: right; font-size: 18px; margin-top: 20px; }
        .footer { text-align: center; margin-top: 40px; color: #999; font-size: 12px; }
        .badge { background: #667eea; color: white; padding: 4px 12px; border-radius: 20px; display: inline-block; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company">🛍️ EktaMart</div>
        <div class="invoice-title">INVOICE</div>
        <p>Invoice #: <strong>{{ $order->order_number }}</strong></p>
        <p>Date: {{ $order->created_at->format('d M Y') }}</p>
        <span class="badge">{{ ucfirst($order->status) }}</span>
    </div>

    <div class="details">
        <h3>Customer Details</h3>
        <p><strong>Name:</strong> {{ $order->user->name ?? 'Guest' }}</p>
        <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}</p>
        <p><strong>Address:</strong> {{ $order->shipping_address ?? 'N/A' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product->name ?? 'Product' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
        <p><strong>Shipping:</strong> ${{ number_format($order->shipping_cost ?? 0, 2) }}</p>
        <p><strong>Tax:</strong> ${{ number_format($order->tax ?? 0, 2) }}</p>
        <h3><strong>Total:</strong> ${{ number_format($order->total, 2) }}</h3>
    </div>

    <div class="footer">
        <p>Thank you for shopping with EktaMart!</p>
        <p>Visit us at: ektamart.com</p>
    </div>
</body>
</html>