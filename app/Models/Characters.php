<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Characters extends Model {

    protected $table = 'characters';
    protected $primaryKey = 'obj_Id';
    public $incrementing = false;
    public $timestamps = false;
}
