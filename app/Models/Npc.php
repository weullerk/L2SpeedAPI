<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Npc extends Model {

    protected $table = 'raidboss_spawnlist';
    public $incrementing = false;
    public $timestamps = false;
}
