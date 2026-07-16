@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="max-w-md mx-auto bg-white border rounded-lg p-6">
        <h1 class="text-xl font-bold mb-4">Log in</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-3">
            @csrf
            <div>
                <label class="text-sm font-medium block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="border rounded px-3 py-2 w-full">
            </div>
            <div>
                <label class="text-sm font-medium block mb-1">Password</label>
                <input type="password" name="password" required class="border rounded px-3 py-2 w-full">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <button class="bg-blue-600 text-white w-full py-2 rounded hover:bg-blue-700">Log in</button>
        </form>
        <p class="text-sm text-gray-500 mt-4">No account? <a href="{{ route('register') }}" class="text-blue-600">Sign up</a></p>
    </div>
@endsection
