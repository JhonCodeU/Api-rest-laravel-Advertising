<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Departament;
use Illuminate\Http\Request;

class CityController extends Controller
{
    function index()
    {
        return City::all();
    }
}
