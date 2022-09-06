<?php

namespace App\Services;

use App\Models\Castle;
use Illuminate\Support\Facades\DB;

class CastlesServices {

    public function castles() {
        return Castle::orderBy('name')->select('clan_name', 'name', DB::raw('FROM_UNIXTIME(siegeDate/1000, "%d/%m/%Y %H:%i") as siege_date'))->leftJoin('clan_data', 'id', '=', 'hasCastle')->get();
    }
}
