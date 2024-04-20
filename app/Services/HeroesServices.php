<?php

namespace App\Services;

use App\Models\Heroes;

class HeroesServices {

    public function heroes() {
        return Heroes::select('class_list.class_name', 'characters.char_name')->leftJoin('characters', 'obj_Id', '=', 'charId')->leftJoin('class_list', 'class_id', '=', 'id')->orderByDesc('class_list.class_name')->get();
    }
}
