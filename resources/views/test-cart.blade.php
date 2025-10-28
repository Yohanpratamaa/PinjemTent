<!DOCTYPE html>
<html>
<head>
    <title>Test Cart Functionality</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test Cart Add</h1>
    
    @auth
        <p>Logged in as: {{ auth()->user()->name }} ({{ auth()->user()->role }})</p>
        
        <form id="testForm">
            <input type="hidden" name="unit_id" value="1">
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="tanggal_mulai" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="tanggal_selesai" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
            <input type="hidden" name="notes" value="Test from debug page">
            
            <button type="submit">Test Add to Cart</button>
        </form>
        
        <div id="result"></div>
        
        <script>
            document.getElementById('testForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const resultDiv = document.getElementById('result');
                
                console.log('Sending request to:', '{{ route('user.cart.store') }}');
                console.log('Form data:', Object.fromEntries(formData));
                
                fetch('{{ route('user.cart.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    resultDiv.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultDiv.innerHTML = '<pre>Error: ' + error.message + '</pre>';
                });
            });
        </script>
    @else
        <p>Please login first</p>
        <a href="{{ route('login') }}">Login</a>
    @endauth
</body>
</html>