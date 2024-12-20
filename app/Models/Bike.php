<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    use HasFactory;

    protected $fillable = [
        'bike_code', 'status', 'location'
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function machineLogs()
    {
        return $this->hasMany(MachineLog::class);
    }
}
