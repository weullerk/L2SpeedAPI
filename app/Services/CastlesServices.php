<?php

namespace App\Services;

use App\Models\Castle;

class CastlesServices {

    public function castles() {
        return Castle::orderBy('castle_name')->get();
    }
}
