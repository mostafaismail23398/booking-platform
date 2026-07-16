<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()->with('service.provider')->latest()->paginate(10);

        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'scheduled_at' => ['required', 'date', 'after:now'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['client_id'] = $request->user()->id;
        $data['status'] = 'pending';

        $booking = Booking::create($data);

        return response()->json($booking, 201);
    }

    public function update(Request $request, Booking $booking)
    {
        abort_unless($booking->service->provider_id === $request->user()->id, 403);

        $data = $request->validate([
            'status' => ['required', 'in:accepted,completed,cancelled'],
        ]);

        $booking->update($data);

        return response()->json($booking);
    }
}
