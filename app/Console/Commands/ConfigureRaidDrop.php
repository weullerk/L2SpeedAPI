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

        $raidbosses = [
            [25299,148154,-73782,-4364,  'Ketra\'s Hero Hekaton (lv80)'],
            [25302,145553,-81651,-5464,  'Ketra\'s Commander Tayr (lv84)'],
            [25305,144997,-84948,-5712,  'Ketra\'s Chief Braki (lv87)'],
            [25309,115537,-39046,-1940,  'Varka\'s Hero Shadith (lv80)'],
            [25312,109296,-36103,-648,   'Varka\'s Commander Mos (lv84)'],
            [25315,105654,-42995,-1240,  'Varka\'s Chief Horus (lv87)'],
            [25319,185700,-106066,-6184, 'Ember (lv85)'],
            [25514,79635,-55612,-5980,   'Spiked stakato Queen Shyeed (lvl80)'],
            [25517,112793,-76080,286,     'Master Anays (lvl87)'],
            [29062,-16373,-53562,-10197, 'High Priestess van Halter (lvl87)'],
            [25283,185060,-9622,-5104,   'Lilith (lvl80)'],
            [25286,185065,-12612,-5104, 'Anakim (lvl80)'],
            [25306,142368,-82512,-6487,  'Nastron, Spirit of Fire (lvl87)'],
            [25316,105452,-36775,-1050,  'Ashutar, Spirit of water (lvl87)'],
            [25527,3776,-6768,-3276, 'Uruka (lvl86)'],
            [29065,26528,-8244,-2007, 'Sailren (lvl87)']
       ];

        foreach ($raidbosses as $raidboss) {
            DB::table('custom_teleport')->insert([
                'description' => $raidboss[4],
                'id' => $raidboss[0],
                'loc_x' => $raidboss[1],
                'loc_y' => $raidboss[2],
                'loc_z' => $raidboss[3],
                'price' => null,
                'fornoble' => 0
            ]);
        }
    }
}
