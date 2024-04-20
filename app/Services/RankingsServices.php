<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Clan;
use App\Models\ClassList;
use App\Models\OlympiadNobles;

class RankingsServices {

    public function pvp() {
        return Character::select(['char_name', 'pvpkills'])->orderByDesc('pvpkills')->take(10)->get();
    }

    public function pk() {
        return Character::select(['char_name', 'pvpkills'])->orderByDesc('pvpkills')->take(10)->get();
    }

    public function clan() {
        return Clan::select(['clan_name', 'reputation_score'])->orderByDesc('reputation_score')->take(10)->get();
    }

    public function olympiads() {
        return OlympiadNobles::select('olympiad_points', 'class_list.class_name', 'characters.char_name')->leftJoin('characters', 'obj_Id', '=', 'charId')->leftJoin('class_list', 'class_id', '=', 'id')->orderByDesc('olympiad_points')->take(10)->get();
    }
}
