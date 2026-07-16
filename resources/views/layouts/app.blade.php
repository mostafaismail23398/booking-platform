<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Booking Platform')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 text-gray-900">
    <nav class="bg-white border-b shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="font-bold text-lg text-blue-600">BookingHub</a>
            <div class="space-x-4 text-sm">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Browse</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                    <a href="{{ route('dashboard.stats') }}" class="hover:text-blue-600">Stats</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="hover:text-blue-600">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-600">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700">Sign up</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
