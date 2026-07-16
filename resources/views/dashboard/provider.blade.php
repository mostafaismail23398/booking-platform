@extends('layouts.app')

@section('title', 'Provider Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Your services</h1>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
        @forelse ($services as $service)
            <div class="border rounded-lg p-4 bg-white">
                <p class="font-semibold">{{ $service->title }}</p>
                <p class="text-sm text-gray-500">${{ number_format($service->price, 2) }} · {{ $service->bookings_count }} bookings</p>
            </div>
        @empty
            <p class="text-gray-500">You haven't listed any services yet.</p>
        @endforelse
    </div>

    <h2 class="text-xl font-bold mb-4">Incoming bookings</h2>
    <div class="space-y-3">
        @forelse ($bookings as $booking)
            <div class="border rounded-lg p-4 bg-white flex justify-between items-center flex-wrap gap-3">
                <div>
                    <p class="font-semibold">{{ $booking->service->title }}</p>
                    <p class="text-sm text-gray-500">
                        client: {{ $booking->client->name }} · {{ $booking->scheduled_at?->format('M d, Y H:i') }}
                    </p>
                </div>

                @if ($booking->status === 'pending')
                    <div class="flex gap-2">
                        <form action="{{ route('bookings.update', $booking) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="accepted">
                            <button class="text-sm bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700">Accept</button>
                        </form>
                        <form action="{{ route('bookings.update', $booking) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button class="text-sm bg-gray-200 px-3 py-1.5 rounded hover:bg-gray-300">Decline</button>
                        </form>
                    </div>
                @elseif ($booking->status === 'accepted')
                    <form action="{{ route('bookings.update', $booking) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button class="text-sm bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700">Mark completed</button>
                    </form>
                @else
                    <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700">{{ ucfirst($booking->status) }}</span>
                @endif
            </div>
        @empty
            <p class="text-gray-500">No bookings yet.</p>
        @endforelse
    </div>
@endsection
