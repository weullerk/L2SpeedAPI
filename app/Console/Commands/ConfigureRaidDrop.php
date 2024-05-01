<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConfigureRaidDrop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:configure_raid_drop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adiciona o drop dos raid boss';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $raidbosses = DB::table('raidboss_spawnlist')->get();
        foreach ($raidbosses as $raidboss) {
            $npc = DB::table('npc')->select('name')->where('id', $raidboss->boss_id)->first();
            echo $npc->name . "\n";
        }
    }
}
