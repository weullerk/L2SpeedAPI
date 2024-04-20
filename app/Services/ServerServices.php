<?php

namespace App\Services;

use App\Models\Castle;
use App\Models\Character;
use Illuminate\Support\Facades\DB;

class ServerServices {

    public function onlineUsers() {
        return Character::where('online', '=', '1')->select('online')->count();
    }
}
