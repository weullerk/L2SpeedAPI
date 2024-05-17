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
[25035,180968,12035,-2720,   'Shilen\'s Messenger Cabrio (lv70)'],
[25054,113432,16403,3960,    'Kernon (lv75)'],
[25092,116151,16227,1944,    'Korim (lv70)'],
[25109,152660,110387,-5520,  'Cloe, Priest of Antharas (lv74)'],
[25126,116263,15916,6992,    'Longhorn Golkonda (lv79)'],
[25143,113102,16002,6992,    'Shuriel, Fire of Wrath (lv78)'],
[25163,130500,59098,3584,    'Roaring Skylancer (lv70)'],
[25198,102656,157424,-3735,  'Fafurion\'s Messenger Loch Ness (lv70)'],
[25199,108096,157408,-3688,  'Fafurion\'s Seer Sheshark (lv72)'],
[25202,119760,157392,-3744,  'Crokian Padisha Sobekk (lv74)'],
[25205,123808,153408,-3671,  'Ocean\'s Flame Ashakiel (lv76)'],
[25220,113551,17083,-2120,   'Death Lord Hallate (lv73)'],
[25229,137568,-19488,-3552,  'Storm Winged Naga (lv75)'],
[25235,116400,-62528,-3264,  'Vanor Chief Kandra (lv72)'],
[25244,187360,45840,-5856,   'Last Lesser Giant Olkuth (lv75)'],
[25245,172000,55000,-5400,   'Last Lesser Giant Glaki (lv78)'],
[25248,127903,-13399,-3720,  'Doom Blade Tanatos (lv72)'],
[25249,147104,-20560,-3377,  'Palatanos of the Fearsome Power (lv75)'],
[25252,192376,22087,-3608,   'Palibati Queen Themis (lv70)'],
[25266,188983,13647,-2672,   'Bloody Empress Decarbia (lv75)'],
[25269,123504,-23696,-3481,  'Beast Lord Behemoth (lv70)'],
[25276,154088,-14116,-3736,  'Death Lord Ipos (lv75)'],
[25281,151053,88124,-5424,   'Anakim\'s Nemesis Zakaron (lv70)'],
[25282,179311,-7632,-4896,   'Death Lord Shax (lv75)'],
[25293,134672,-115600,-1216, 'Hestia, Guardian Deity of the Hot Springs (lv78)'],
[25325,91008,-85904,-2736,   'Barakiel, the Flame of Splendor (lv70)'],
[25328,59331,-42403,-3003,   'Eilhalder Von Hellman (lv71)'],
[25447,113200,17552,-1424,   'Immortal Savior Mardil (lv71)',
[25450,113600,15104,9559],   'Cherub Galaxia (lv79)'],
[25453,156704,-6096,-4185,   'Minas Anor (lv70)'],
[25524,144143,-5731,-4722,   'Flamestone Giant (lvl76)']
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
