<!DOCTYPE html>
<html>
<head>
    <title>Manual Cart Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, textarea, select { width: 100%; padding: 8px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .result { margin-top: 20px; padding: 10px; border: 1px solid #ccc; background: #f9f9f9; }
        .error { background: #f8d7da; border-color: #f5c6cb; color: #721c24; }
        .success { background: #d4edda; border-color: #c3e6cb; color: #155724; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manual Cart Test</h1>

        @auth
            <p><strong>User:</strong> {{ auth()->user()->name }} ({{ auth()->user()->role }})</p>

            <form id="cartTestForm">
                <div class="form-group">
                    <label for="unit_id">Unit:</label>
                    <select name="unit_id" id="unit_id" required>
                        <option value="">-- Pilih Unit --</option>
                        @foreach(\App\Models\Unit::where('status', 'tersedia')->get() as $unit)
                            <option value="{{ $unit->id }}">
                                {{ $unit->nama_unit }} - Stock: {{ $unit->available_stock }} - Rp {{ number_format($unit->harga_sewa_per_hari, 0, ',', '.') }}/hari
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai:</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_selesai">Tanggal Selesai:</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>

                <div class="form-group">
                    <label for="notes">Notes:</label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Optional notes..."></textarea>
                </div>

                <button type="submit">Add to Cart</button>
                <button type="button" onclick="getCartCount()">Get Cart Count</button>
                <button type="button" onclick="clearCart()">Clear Cart</button>
            </form>

            <div id="result" class="result" style="display: none;"></div>

            <script>
                const baseUrl = '{{ url('') }}';
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                document.getElementById('cartTestForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const resultDiv = document.getElementById('result');

                    // Show loading
                    resultDiv.style.display = 'block';
                    resultDiv.className = 'result';
                    resultDiv.innerHTML = 'Loading...';

                    console.log('Sending request to:', baseUrl + '/user/cart/add');
                    console.log('Form data:', Object.fromEntries(formData));

                    fetch(baseUrl + '/user/cart/add', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', [...response.headers.entries()]);

                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }

                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);

                        if (data.success) {
                            resultDiv.className = 'result success';
                            resultDiv.innerHTML = `
                                <h3>Success!</h3>
                                <p>${data.message}</p>
                                <p><strong>Cart Count:</strong> ${data.cart_count}</p>
                                <pre>${JSON.stringify(data, null, 2)}</pre>
                            `;
                        } else {
                            resultDiv.className = 'result error';
                            resultDiv.innerHTML = `
                                <h3>Error!</h3>
                                <p>${data.message}</p>
                                <pre>${JSON.stringify(data, null, 2)}</pre>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resultDiv.className = 'result error';
                        resultDiv.innerHTML = `
                            <h3>Network Error!</h3>
                            <p>${error.message}</p>
                        `;
                    });
                });

                function getCartCount() {
                    const resultDiv = document.getElementById('result');

                    resultDiv.style.display = 'block';
                    resultDiv.className = 'result';
                    resultDiv.innerHTML = 'Getting cart count...';

                    fetch(baseUrl + '/user/cart/count', {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        resultDiv.className = 'result success';
                        resultDiv.innerHTML = `
                            <h3>Cart Count</h3>
                            <p><strong>Count:</strong> ${data.count}</p>
                        `;
                    })
                    .catch(error => {
                        resultDiv.className = 'result error';
                        resultDiv.innerHTML = `<h3>Error getting cart count!</h3><p>${error.message}</p>`;
                    });
                }

                function clearCart() {
                    const resultDiv = document.getElementById('result');

                    if (!confirm('Are you sure you want to clear the cart?')) return;

                    resultDiv.style.display = 'block';
                    resultDiv.className = 'result';
                    resultDiv.innerHTML = 'Clearing cart...';

                    fetch(baseUrl + '/user/cart', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            resultDiv.className = 'result success';
                            resultDiv.innerHTML = `<h3>Cart Cleared!</h3><p>${data.message}</p>`;
                        } else {
                            resultDiv.className = 'result error';
                            resultDiv.innerHTML = `<h3>Error!</h3><p>${data.message}</p>`;
                        }
                    })
                    .catch(error => {
                        resultDiv.className = 'result error';
                        resultDiv.innerHTML = `<h3>Error clearing cart!</h3><p>${error.message}</p>`;
                    });
                }
            </script>
        @else
            <p>Please <a href="{{ route('login') }}">login</a> first.</p>
        @endauth
    </div>
</body>
</html>
