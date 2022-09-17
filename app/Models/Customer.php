<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'name',
        'last_name',
        'email',
        'habeas_data',
        'cell_phone',
        'city_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
