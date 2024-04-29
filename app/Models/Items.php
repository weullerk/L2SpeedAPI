<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Characters extends Model {

    protected $table = 'characters';
    protected $primaryKey = 'object_id';
    public $incrementing = false;
    public $timestamps = false;
}
