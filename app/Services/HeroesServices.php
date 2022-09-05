<?php

namespace App\Services;

use App\Models\Heroes;

class HeroesServices {
    public function heroes() {
        return Heroes::where('active', 1)->get();
    }
}
