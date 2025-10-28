<!DOCTYPE html>
<html>
<head>
    <title>Simple Cart Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Simple Cart Test</h1>

    @auth
        <p>Logged in as: {{ auth()->user()->name }}</p>

        <h2>Available Units:</h2>
        <ul>
            @foreach(\App\Models\Unit::where('status', 'tersedia')->get() as $unit)
                <li>
                    {{ $unit->nama_unit }} - Available: {{ $unit->available_stock }}
                    @if($unit->available_stock > 0)
                        <button onclick="testAddToCart({{ $unit->id }}, '{{ $unit->nama_unit }}', {{ $unit->harga_sewa_per_hari }}, {{ $unit->available_stock }})">
                            Add to Cart
                        </button>
                    @endif
                </li>
            @endforeach
        </ul>

        <div id="status"></div>

        <script>
            function testAddToCart(unitId, unitName, unitPrice, availableStock) {
                const statusDiv = document.getElementById('status');
                statusDiv.innerHTML = 'Adding ' + unitName + ' to cart...';

                const formData = new FormData();
                formData.append('unit_id', unitId);
                formData.append('quantity', 1);
                formData.append('tanggal_mulai', '{{ date('Y-m-d') }}');
                formData.append('tanggal_selesai', '{{ date('Y-m-d', strtotime('+1 day')) }}');
                formData.append('notes', 'Test from simple page');

                fetch('{{ url('/user/cart/add') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status + ': ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        statusDiv.innerHTML = '<span style="color: green;">SUCCESS: ' + data.message + ' (Cart count: ' + data.cart_count + ')</span>';
                    } else {
                        statusDiv.innerHTML = '<span style="color: red;">ERROR: ' + data.message + '</span>';
                    }
                })
                .catch(error => {
                    statusDiv.innerHTML = '<span style="color: red;">NETWORK ERROR: ' + error.message + '</span>';
                });
            }
        </script>
    @else
        <p>Please <a href="{{ route('login') }}">login</a> first.</p>
    @endauth
</body>
</html>
