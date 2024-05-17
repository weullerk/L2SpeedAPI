<?php

namespace App\Traits;

use App\Models\Items;

trait RewardDeliver
{
    public function deliverReward($charId): void
    {
        $item = Items::where([
            'owner_id' => $charId,
            'item_id' => 6393,
            'loc' => 'WAREHOUSE',
        ])->first();

        if ($item) {
            $item->count = $item->count + 20000;
            $item->save();
        } else {
            $itemMaxId = Items::orderBy('object_id', 'desc')->first();
            Items::create([
                "owner_id" => $charId,
                "object_id" => $itemMaxId->object_id + 1000,
                "item_id" => 6393,
                "count" => 20000,
                "enchant_level" => 0,
                "loc" => "WAREHOUSE",
                "loc_data" => 0,
                "price_sell" => 0,
                "price_buy" => 0,
                "time_of_use" => null,
                "custom_type1" => 0,
                "custom_type2" => 0,
                "mana_left" => "-1"
            ]);
        }
    }
}
