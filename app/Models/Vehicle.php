<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'registration_number',
        'bus_number',
        'entree_date',
    ];

    public function driver()
    {
        return $this->hasOne(Driver::class, 'vehicle_id');
    }
}
