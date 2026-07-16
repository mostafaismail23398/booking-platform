@extends('layouts.app')

@section('title', 'Browse Services')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Find a service</h1>

    <form method="GET" class="flex flex-wrap gap-3 mb-8">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search services..."
               class="border rounded px-3 py-2 flex-1 min-w-[200px]">
        <select name="category" class="border rounded px-3 py-2">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
    </form>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($services as $service)
            <a href="{{ route('services.show', $service) }}" class="block border rounded-lg p-4 bg-white hover:shadow-md transition">
                <span class="text-xs text-blue-600 font-medium">{{ $service->category->name }}</span>
                <h2 class="font-semibold text-lg mt-1">{{ $service->title }}</h2>
                <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $service->description }}</p>
                <div class="flex justify-between items-center mt-4 text-sm">
                    <span class="text-gray-500">by {{ $service->provider->name }}</span>
                    <span class="font-bold text-gray-900">${{ number_format($service->price, 2) }}</span>
                </div>
            </a>
        @empty
            <p class="text-gray-500">No services found.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $services->links() }}
    </div>
@endsection
