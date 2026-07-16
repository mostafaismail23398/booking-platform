<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, Service $service)
    {
        $request->validate([
            'scheduled_at' => ['required', 'date', 'after:now'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking = Booking::create([
            'service_id' => $service->id,
            'client_id' => $request->user()->id,
            'scheduled_at' => $request->scheduled_at,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Booking request sent to the provider.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        // Only the provider who owns the service can change its status.
        abort_unless($booking->service->provider_id === $request->user()->id, 403);

        $request->validate([
            'status' => ['required', 'in:accepted,completed,cancelled'],
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('status', 'Booking updated.');
    }
}
