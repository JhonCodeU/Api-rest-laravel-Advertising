<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'departament_id'
    ];

    public function departament()
    {
        return $this->belongsTo(Departament::class);
    }
}
