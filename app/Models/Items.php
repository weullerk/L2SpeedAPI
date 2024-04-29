<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model {

    protected $table = 'items';
    protected $primaryKey = 'object_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ["owner_id", "object_id", "item_id", "count", "enchant_level", "loc", "loc_data", "price_sell", "price_buy", "time_of_use", "custom_type1", "custom_type2", "mana_left"];
}
