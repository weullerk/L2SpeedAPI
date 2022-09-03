<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {

    protected $table = 'accounts';
    protected $primaryKey = 'login';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
