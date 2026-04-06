@extends('layouts.admin')
@section('title', 'Purchases - Admin')
@section('page-title', 'Purchases')
@section('page-description', 'View and manage all purchase transactions')

@section('content')

{{-- Error/Success Messages --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-lg">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 px-4 py-3 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="mb-4 px-4 py-3 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Scanner Section --}}
    <div class="lg:col-span-2 bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
        <h3 class="text-lg font-bold text-white mb-4">📷 Scan QR Code (Mark Collected)</h3>
        
        <div id="reader" class="w-full bg-black rounded-lg overflow-hidden border border-gray-700" style="display: none;"></div>
        
        <div class="mt-4 flex gap-3">
            <button id="start-scan-btn" class="flex-1 py-2.5 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-xl hover:from-emerald-400 hover:to-cyan-400 transition-all text-sm">
                Start Camera Scanner
            </button>
            <button id="stop-scan-btn" class="flex-1 py-2.5 bg-red-500/20 text-red-400 hover:bg-red-500/30 border border-red-500/50 font-semibold rounded-xl transition-all text-sm" style="display: none;">
                Stop Scanner
            </button>
        </div>
    </div>

    {{-- Manual Entry Section --}}
    <div class="lg:col-span-1 bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
        <h3 class="text-lg font-bold text-white mb-4">✍️ Manual Entry</h3>
        <form method="POST" action="{{ route('admin.purchases.collect-by-slip') }}" id="manual-collect-form">
            @csrf
            <div>
                <label for="slip_id" class="block text-sm text-gray-400 mb-2">Slip ID</label>
                <input type="text" name="slip_id" id="slip_id" required placeholder="e.g. SLP-1234..."
                       class="w-full px-4 py-2.5 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                              focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all font-mono">
            </div>
            <button type="submit" class="w-full mt-4 py-2.5 bg-gray-800 border border-gray-700 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all text-sm">
                Mark Collected
            </button>
        </form>
    </div>
</div>

<div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800">
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Slip ID</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">User</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Fuel</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Vehicle</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Liters</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Amount</th>
                <th class="text-center py-4 px-6 text-gray-400 font-medium">Status</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchases as $purchase)
                <tr class="border-b border-gray-800/50 hover:bg-gray-800/30">
                    <td class="py-4 px-6 text-white font-medium">{{ $purchase->slip_id }}</td>
                    <td class="py-4 px-6 text-gray-300">{{ $purchase->user->name }}</td>
                    <td class="py-4 px-6 text-gray-300">{{ $purchase->product->name }}</td>
                    <td class="py-4 px-6 text-gray-300">{{ $purchase->vehicle->vehicle_number }}</td>
                    <td class="py-4 px-6 text-right text-white">{{ $purchase->liters }}</td>
                    <td class="py-4 px-6 text-right text-emerald-400 font-semibold">৳{{ number_format($purchase->amount_paid, 2) }}</td>
                    <td class="py-4 px-6 text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($purchase->status === 'paid') bg-emerald-500/10 text-emerald-400
                            @elseif($purchase->status === 'collected') bg-cyan-500/10 text-cyan-400
                            @elseif($purchase->status === 'cancelled') bg-red-500/10 text-red-400
                            @else bg-yellow-500/10 text-yellow-400
                            @endif">
                            {{ ucfirst($purchase->status) }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-right space-x-1">
                        <a href="{{ route('admin.purchases.show', $purchase) }}" class="px-3 py-1.5 text-cyan-400 hover:bg-cyan-500/10 rounded-lg text-xs font-medium transition-all">View</a>
                        @if($purchase->status === 'paid')
                            <form method="POST" action="{{ route('admin.purchases.collect', $purchase) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 text-amber-400 hover:bg-amber-500/10 rounded-lg text-xs font-medium transition-all">Collect</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="py-8 text-center text-gray-400">No purchases found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $purchases->links() }}</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const scannerContainer = document.getElementById('reader');
        const startBtn = document.getElementById('start-scan-btn');
        const stopBtn = document.getElementById('stop-scan-btn');
        const slipInput = document.getElementById('slip_id');
        const manualForm = document.getElementById('manual-collect-form');
        
        let html5QrcodeScanner = null;

        function onScanSuccess(decodedText, decodedResult) {
            // Stop the scanner
            html5QrcodeScanner.clear();
            scannerContainer.style.display = 'none';
            startBtn.style.display = 'block';
            stopBtn.style.display = 'none';
            
            // Set the value in the manual form and submit
            slipInput.value = decodedText;
            manualForm.submit();
        }

        function onScanFailure(error) {
            // Ignore failure, we will keep scanning
        }

        startBtn.addEventListener('click', function() {
            scannerContainer.style.display = 'block';
            startBtn.style.display = 'none';
            stopBtn.style.display = 'block';
            
            html5QrcodeScanner = new Html5Qrcode("reader");
            html5QrcodeScanner.start(
                { facingMode: "environment" }, 
                { fps: 10, qrbox: {width: 250, height: 250} },
                onScanSuccess,
                onScanFailure
            ).catch(err => {
                alert("Camera access failed or denied: " + err);
                startBtn.style.display = 'block';
                stopBtn.style.display = 'none';
                scannerContainer.style.display = 'none';
            });
        });

        stopBtn.addEventListener('click', function() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    startBtn.style.display = 'block';
                    stopBtn.style.display = 'none';
                    scannerContainer.style.display = 'none';
                }).catch(err => {
                    console.error("Failed to stop scanner.", err);
                });
            }
        });
    });
</script>
@endsection

