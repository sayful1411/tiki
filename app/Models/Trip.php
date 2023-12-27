<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id', 'route_id', 'trip_date', 'departure_time',
        'arrival_time', 'fare_amount', 'round_trip', 'return_date', 'status'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
