<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id', 'starting_location_id', 'ending_location_id',
        'trip_date', 'starting_time', 'arrival_time', 'round_trip',
        'return_date'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function startingLocation()
    {
        return $this->belongsTo(Location::class, 'starting_location_id');
    }

    public function endingLocation()
    {
        return $this->belongsTo(Location::class, 'ending_location_id');
    }
}
