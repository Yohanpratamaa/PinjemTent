@auth
User logged in: {{ auth()->user()->name ?? 'No name' }}
Role: {{ auth()->user()->role ?? 'No role' }}
@else
Not logged in
@endauth