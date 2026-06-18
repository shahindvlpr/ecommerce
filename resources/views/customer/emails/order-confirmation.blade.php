<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { text-align: center; border-bottom: 2px solid #667eea; padding-bottom: 20px; }
        .logo { font-size: 28px; font-weight: bold; color: #667eea; }
        h2 { color: #1a1a2e; margin: 20px 0; }
        .order-details { background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #f3f4f6; }
        .total { font-size: 20px; font-weight: bold; color: #667eea; text-align: right; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 12px; }
        .btn { display: inline-block; padding: 10px 25px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; text-decoration: none; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🛍️ Ektamart</div>
            <p>Thank you for your order!</p>
        </div>

        <h2>Order #{{ $order->order_number }}</h2>
        <p>Dear {{ $order->name }},</p>
        <p>We're pleased to confirm your order. Here are the details:</p>

        <div class="order-details">
            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            <p><strong>Status:</strong> {{ $order->status_label }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p>Total: ${{ number_format($order->total, 2) }}</p>
        </div>

        <div style="text-align: center; margin: 25px 0;">
            <a href="{{ route('customer.orders.show', $order->id) }}" class="btn">View Order</a>
        </div>

        <div class="footer">
            <p>Need help? Contact us at support@ektamart.com</p>
            <p>&copy; {{ date('Y') }} Ektamart. All rights reserved.</p>
        </div>
    </div>
</body>
</html>