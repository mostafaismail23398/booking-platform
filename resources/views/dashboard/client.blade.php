@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
    <h1 class="text-2xl font-bold mb-6">My bookings</h1>

    <div class="space-y-3">
        @forelse ($bookings as $booking)
            <div class="border rounded-lg p-4 bg-white flex justify-between items-center">
                <div>
                    <p class="font-semibold">{{ $booking->service->title }}</p>
                    <p class="text-sm text-gray-500">
                        with {{ $booking->service->provider->name }} ·
                        {{ $booking->scheduled_at?->format('M d, Y H:i') }}
                    </p>
                </div>
                <span class="text-xs px-2 py-1 rounded
                    @class([
                        'bg-yellow-100 text-yellow-800' => $booking->status === 'pending',
                        'bg-blue-100 text-blue-800' => $booking->status === 'accepted',
                        'bg-green-100 text-green-800' => $booking->status === 'completed',
                        'bg-red-100 text-red-800' => $booking->status === 'cancelled',
                    ])">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>
        @empty
            <p class="text-gray-500">You haven't booked anything yet. <a href="{{ route('home') }}" class="text-blue-600">Browse services</a>.</p>
        @endforelse
    </div>
@endsection
