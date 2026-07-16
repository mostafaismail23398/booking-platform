@extends('layouts.app')

@section('title', 'Sign up')

@section('content')
    <div class="max-w-md mx-auto bg-white border rounded-lg p-6">
        <h1 class="text-xl font-bold mb-4">Create an account</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-3">
            @csrf
            <div>
                <label class="text-sm font-medium block mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="border rounded px-3 py-2 w-full">
            </div>
            <div>
                <label class="text-sm font-medium block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="border rounded px-3 py-2 w-full">
            </div>
            <div>
                <label class="text-sm font-medium block mb-1">Password</label>
                <input type="password" name="password" required class="border rounded px-3 py-2 w-full">
            </div>
            <div>
                <label class="text-sm font-medium block mb-1">Confirm password</label>
                <input type="password" name="password_confirmation" required class="border rounded px-3 py-2 w-full">
            </div>
            <div>
                <label class="text-sm font-medium block mb-1">I want to...</label>
                <select name="role" class="border rounded px-3 py-2 w-full">
                    <option value="client">Book services (Client)</option>
                    <option value="provider">Offer services (Provider)</option>
                </select>
            </div>
            <button class="bg-blue-600 text-white w-full py-2 rounded hover:bg-blue-700">Sign up</button>
        </form>
        <p class="text-sm text-gray-500 mt-4">Already have an account? <a href="{{ route('login') }}" class="text-blue-600">Log in</a></p>
    </div>
@endsection
