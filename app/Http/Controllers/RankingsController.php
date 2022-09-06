<?php

namespace App\Http\Controllers;

use App\Services\CastlesServices;
use App\Services\HeroesServices;
use App\Services\RankingsServices;
use Illuminate\Http\Request;

class RankingsController extends Controller
{
    public function pvps(RankingsServices $rankingsServices) {
        return response()->json($rankingsServices->pvp());
    }

    public function pks(RankingsServices $rankingsServices) {
        return response()->json($rankingsServices->pk());
    }

    public function clans(RankingsServices $rankingsServices) {
        return response()->json($rankingsServices->clan());
    }

    public function olympiads(RankingsServices $rankingsServices) {
        return response()->json($rankingsServices->olympiads());
    }

    public function heroes(HeroesServices $heroesServices) {
        return response()->json($heroesServices->heroes());
    }

    public function castles(CastlesServices $castlesServices) {
        return response()->json($castlesServices->castles());
    }
}
