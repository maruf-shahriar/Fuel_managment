<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fuel Slip - {{ $purchase->slip_id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
        .slip { max-width: 500px; margin: 0 auto; border: 2px solid #10b981; border-radius: 12px; overflow: hidden; }
        .header { background: linear-gradient(135deg, #10b981, #06b6d4); color: white; text-align: center; padding: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0; font-size: 12px; opacity: 0.9; }
        .body { padding: 24px; }
        .slip-id { text-align: center; font-size: 20px; font-weight: bold; padding: 16px 0; border-bottom: 1px dashed #ddd; margin-bottom: 16px; }
        .row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f3f4f6; }
        .row:last-child { border-bottom: none; }
        .label { color: #6b7280; font-size: 13px; }
        .value { font-weight: 600; font-size: 14px; }
        .total { background: #f0fdf4; padding: 16px; border-radius: 8px; margin-top: 16px; text-align: center; }
        .total .amount { font-size: 28px; font-weight: bold; color: #10b981; }
        .footer { text-align: center; padding: 16px; color: #9ca3af; font-size: 11px; border-top: 1px dashed #ddd; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="slip">
        <div class="header">
            <h1>⚡ Fuel Purchase Slip</h1>
            <p>FuelStation Digital Receipt</p>
        </div>

        <div class="body">
            <div class="slip-id">
                <p style="margin: 0 0 10px 0;">{{ $purchase->slip_id }}</p>
                <img src="data:image/svg+xml;base64,{!! base64_encode(QrCode::format('svg')->size(100)->generate($purchase->slip_id)) !!}" alt="QR Code">
            </div>

            <div class="row">
                <span class="label">Customer</span>
                <span class="value">{{ $purchase->user->name }}</span>
            </div>
            <div class="row">
                <span class="label">Email</span>
                <span class="value">{{ $purchase->user->email }}</span>
            </div>
            <div class="row">
                <span class="label">Fuel</span>
                <span class="value">{{ $purchase->product->name }}</span>
            </div>
            <div class="row">
                <span class="label">Category</span>
                <span class="value">{{ $purchase->product->category->name }}</span>
            </div>
            <div class="row">
                <span class="label">Vehicle Type</span>
                <span class="value">{{ $purchase->vehicle->vehicle_type }}</span>
            </div>
            <div class="row">
                <span class="label">Vehicle Number</span>
                <span class="value">{{ $purchase->vehicle->vehicle_number }}</span>
            </div>
            <div class="row">
                <span class="label">Quantity</span>
                <span class="value">{{ $purchase->liters }} Liters</span>
            </div>

            @if($purchase->payment)
            <div class="row">
                <span class="label">Transaction ID</span>
                <span class="value">{{ $purchase->payment->transaction_id }}</span>
            </div>
            <div class="row">
                <span class="label">Payment Status</span>
                <span class="value" style="color: #10b981;">{{ ucfirst($purchase->payment->payment_status) }}</span>
            </div>
            @endif

            <div class="row">
                <span class="label">Date</span>
                <span class="value">{{ $purchase->created_at->format('d M Y, h:i A') }}</span>
            </div>

            <div class="total">
                <p style="margin: 0; color: #6b7280; font-size: 13px;">Total Amount Paid</p>
                <p class="amount">৳{{ number_format($purchase->amount_paid, 2) }}</p>
            </div>

            <div class="footer">
                <p>Present this slip at the fuel station for collection.</p>
                <p>Status: {{ ucfirst($purchase->status) }}</p>
            </div>
        </div>
    </div>
</body>
</html>
