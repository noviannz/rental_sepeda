<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'bike_id', 'station_id', 'log_time', 'event'
    ];

    public function bike()
    {
        return $this->belongsTo(Bike::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
