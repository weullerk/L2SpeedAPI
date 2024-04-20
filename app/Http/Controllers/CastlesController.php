<?php

namespace App\Http\Controllers;

use App\Services\CastlesServices;
use Illuminate\Http\Request;

class CastlesController extends Controller
{
    public function castles(CastlesServices $castlesServices) {
        return response()->json($castlesServices->castles());
    }
}
