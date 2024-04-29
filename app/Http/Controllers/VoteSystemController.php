<?php

namespace App\Http\Controllers;

use App\Services\CastlesServices;
use App\Services\ServerServices;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function usersOnline(ServerServices $serverServices) {
        return response()->json($serverServices->onlineUsers());
    }
}
