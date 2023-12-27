<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Location;
use App\Models\Trip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'fromCity' => 'required',
            'toCity' => 'required',
            'departure-date' => 'required|date',
            'return-date' => 'nullable|date',
        ]);

        $fromCityName = $request->input('fromCity');
        $toCityName = $request->input('toCity');

        if ($fromCityName == $toCityName) {
            return redirect()->back()->with('error', 'City name must be different');
        }

        // Retrieve IDs based on city names
        $fromLocation = Location::where('name', $fromCityName)->first();
        $toLocation = Location::where('name', $toCityName)->first();

        $fromLocationId = $fromLocation->id;
        $toLocationId = $toLocation->id;

        $tripDate = $request->input('departure-date');
        $returnDate = $request->input('return-date');

        // dd($fromLocationId, $toLocationId, $tripDate);
        // dd($request->all());

        // Search for trips based on the criteria
        $trips = Trip::with('bus', 'route')
            ->whereHas('route', function ($query) use ($fromLocationId) {
                $query->where('origin', $fromLocationId);
            })
            ->whereHas('route', function ($query) use ($toLocationId) {
                $query->where('destination', $toLocationId);
            })
            ->where('trip_date', $tripDate)
            ->when($returnDate, function ($query) use ($returnDate) {
                return $query->where('return_date', $returnDate);
            })->get();

        // dd($trips);

        $tripResults = [];
        foreach ($trips as $trip) {
            $bookedSeatsArrays = Booking::where('trip_id', $trip->id)->pluck('seat_numbers')->toArray();

            $bookedSeatsArrays = array_map(function ($seatNumbers) {
                return explode(',', $seatNumbers);
            }, $bookedSeatsArrays);
            // dd($bookedSeatsArrays);
            // Merge all booked seat arrays into a single array
            $bookedSeats = array_merge(...$bookedSeatsArrays);

            $allSeats = range(1, $trip->bus->total_seats);

            $availableSeats = array_values(array_diff($allSeats, $bookedSeats));
            // dd($availableSeats);

            $tripResults[] = [
                'trip' => $trip,
                'bus' => $trip->bus,
                'route' => $trip->route,
                'available_seats' => $availableSeats,
            ];
        }

        // dd($tripResults);

        // Pass the results to the view
        return view('frontend.search_results', compact('tripResults'));
    }
}
