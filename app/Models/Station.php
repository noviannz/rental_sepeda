<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_name', 'location', 'capacity'
    ];

    public function machineLogs()
    {
        return $this->hasMany(MachineLog::class);
    }
}
