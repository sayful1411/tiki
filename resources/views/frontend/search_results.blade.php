@extends('layouts.frontend')

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1 class="my-4">Search Results</h1>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Bus Info</th>
                            <th scope="col">Dep. Time</th>
                            <th scope="col">Arr. Time</th>
                            <th scope="col">Seat Available</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tripResults as $tripResult)
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td><b>{{ str()->ucfirst($tripResult['bus']->name) }}</b></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">{{ $tripResult['bus']->bus_type }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Route:</b> {{ $tripResult['route']->originLocation->name }} to
                                                {{ $tripResult['route']->destinationLocation->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Starting Point:</b> {{ $tripResult['route']->originLocation->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Ending Point:</b> {{ $tripResult['route']->destinationLocation->name }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($tripResult['trip']->starting_time)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($tripResult['trip']->arrival_time)->format('h:i A') }}</td>
                                <td>
                                    @if (count($tripResult['available_seats']) > 0)
                                        {{ count($tripResult['available_seats']) }}
                                    @else
                                        No available seats
                                    @endif
                                </td>
                                <td>{{ $tripResult['trip']->fare_amount }}</td>
                                <td>
                                    <a href="{{ route('show.seats', $tripResult['trip']->id) }}">
                                        <button class="btn btn-sm btn-primary">Book</button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">There is no bus available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
