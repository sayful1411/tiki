<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Constants\BookingStatus;

class BookingController extends Controller
{
    public function showSeats(Trip $trip)
    {
        // dd($trip);
        $bookedSeats = Booking::where('trip_id', $trip->id)->pluck('seat_numbers')->toArray();

        $bookedSeats = array_map('intval', explode(',', implode(',', $bookedSeats)));

        $totalSeats = $trip->bus->total_seats;

        $seatsPerRow = 6;

        // Calculate the total number of rows
        $totalRows = ceil($totalSeats / $seatsPerRow);

        return view('frontend.seats', compact('trip', 'bookedSeats', 'totalRows', 'seatsPerRow'));
    }

    public function bookSeats(Request $request, Trip $trip)
    {
        $this->validate($request, [
            'selectedSeats' => 'required|array|min:1|max:4',
        ]);

        $selectedSeats = $request->input('selectedSeats');

        $user = auth()->user();

        $seatNumbersString = implode(',', $selectedSeats);

        $totalFareAmount = count($selectedSeats) * $trip->fare_amount;

        // Perform the booking process (create Booking records)
        Booking::create([
            'user_id' => $user->id,
            'trip_id' => $trip->id,
            'seat_numbers' => $seatNumbersString,
            'total_price' => $totalFareAmount,
            'booking_date' => now(),
            'status' => BookingStatus::RECEIVED,
        ]);

        return redirect()->back()->with('success', 'Seats booked successfully!');
    }
}
