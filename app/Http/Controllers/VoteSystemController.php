<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Items;
use App\Models\VoteL2jBrasil;
use App\Models\VoteTop100Arena;
use App\Services\CastlesServices;
use App\Services\ServerServices;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Orchestra\Parser\Xml\Facade as XmlParser;
use App\Traits\RewardDeliver;

class VoteSystemController extends Controller
{
    use RewardDeliver;

    public function l2jbrasil() {
        $ip = request()->getClientIp();
        $char = request('char_name');

        $characterEntity = Character::where([
            'char_name' => $char
        ])->first();

        if (!$characterEntity) {
            return response()->json(['status' => false, 'message' => 'Char não encontrado.']);
        }

        $charId = $characterEntity->obj_Id;

        $client = new Client();
        $apiUrl = 'https://top.l2jbrasil.com/votesystem/?hours=12&ip=' . $ip . '&username=radiador22';

        $response = $client->get($apiUrl);
        $stream = $response->getBody()->getContents();
        $xml = XMLParser::extract($stream);
        $data = $xml->parse([
            'id' => ['uses' => 'vote.id'],
            'player_id' => ['uses' => 'vote.player_id'],
            'site_id' => ['uses' => 'vote.site_id'],
            'ip' => ['uses' => 'vote.ip'],
            'date' => ['uses' => 'vote.date'],
            'status' => ['uses' => 'vote.status'],
            'server_time' => ['uses' => 'vote.server_time'],
            'hours_since_vote' => ['uses' => 'vote.hours_since_vote'],
        ]);

        if ($data['status'] == '1') {
            $vote = VoteL2jBrasil::where([
                'date' => $data['date'],
                'ip' => $data['ip'],
                'account' => 'radiador22'
            ])->get();

            if ($vote->count() == 0) {
                $voteEntity = new VoteL2jBrasil();
                $voteEntity->date = $data['date'];
                $voteEntity->ip = $data['ip'];
                $voteEntity->account = 'radiador22';
                $voteEntity->save();

                $this->deliverReward($charId);

                return response()->json(['status' => true, 'message' => 'Recompensa entregue na warehouse do seu char, selecione-o novamente para aparecer na warehouse.']);
            } else {
                return response()->json(['status' => false, 'message' => 'A Recompensa já foi entregue.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Não foi detectado o voto.']);
        }
    }

    public function top100arenaPostback() {
        if (request()->ip() == '3.86.48.1163.86.48.116') {
            $account = request()->get('postback');
            $date = Carbon::now('America/Sao_Paulo');

            $voteEntity = new VoteTop100Arena();
            $voteEntity->account = $account;
            $voteEntity->date = $date;
            $voteEntity->claimed = false;
            $voteEntity->save();

            return response('', 200);
        }

        return response('', 403);
    }

    public function top100arena() {
        $date = Carbon::now(new DateTimeZone('America/Sao_Paulo'));

        $ip = '201.77.170.64';
        //$ip = request()->getClientIp();

        $char = 'Kreator1';
        //$char = request('char_name');

        $characterEntity = Character::where([
            'char_name' => $char
        ])->first();

        if (!$characterEntity) {
            return response()->json(['status' => false, 'message' => 'Char não encontrado.']);
        }

        $charId = $characterEntity->obj_Id;
    }


}
