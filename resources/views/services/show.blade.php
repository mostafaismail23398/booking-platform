@extends('layouts.app')

@section('title', $service->title)

@section('content')
    <div class="grid md:grid-cols-3 gap-8">
        <div class="md:col-span-2">
            <span class="text-xs text-blue-600 font-medium">{{ $service->category->name }}</span>
            <h1 class="text-2xl font-bold mt-1">{{ $service->title }}</h1>
            <p class="text-gray-600 mt-4 whitespace-pre-line">{{ $service->description }}</p>
            <p class="text-sm text-gray-500 mt-4">Offered by <strong>{{ $service->provider->name }}</strong> ·
                delivery in {{ $service->delivery_days }} day(s)</p>
        </div>

        <div class="border rounded-lg p-5 bg-white h-fit">
            <p class="text-2xl font-bold mb-4">${{ number_format($service->price, 2) }}</p>

            @auth
                @if (auth()->id() !== $service->provider_id)
                    <form id="booking-form" action="{{ route('bookings.store', $service) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="text-sm font-medium block mb-1">Preferred date/time</label>
                            <input type="datetime-local" name="scheduled_at" required
                                   class="border rounded px-3 py-2 w-full">
                        </div>
                        <div>
                            <label class="text-sm font-medium block mb-1">Notes (optional)</label>
                            <textarea name="notes" rows="3" class="border rounded px-3 py-2 w-full"></textarea>
                        </div>
                        <button class="bg-blue-600 text-white w-full py-2 rounded hover:bg-blue-700">
                            Book this service
                        </button>
                    </form>
                @else
                    <p class="text-sm text-gray-500">This is your own service listing.</p>
                @endif
            @else
                <a href="{{ route('login') }}" class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                    Log in to book
                </a>
            @endauth
        </div>
    </div>

    <script>
        // Simple client-side guard: prevent picking a past date/time.
        const form = document.getElementById('booking-form');
        if (form) {
            form.addEventListener('submit', (e) => {
                const input = form.querySelector('input[name="scheduled_at"]');
                if (new Date(input.value) <= new Date()) {
                    e.preventDefault();
                    alert('Please choose a future date and time.');
                }
            });
        }
    </script>
@endsection
