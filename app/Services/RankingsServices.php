<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Clan;
use App\Models\OlympiadNobles;

class RankingsServices {

    public function pvp() {
        return Character::orderByDesc('pvpkills')->take(10)->get();
    }

    public function pk() {
        return Character::orderByDesc('pvpkills')->take(10)->get();
    }

    public function clan() {
        return Clan::orderByDesc('reputation_score')->take(10)->get();
    }

    public function olympiads() {
        return OlympiadNobles::orderByDesc('olympiad_points')->take(10)->get();
    }
}
