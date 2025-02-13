<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Items;
use App\Models\VoteL2jBrasil;
use App\Models\VoteL2Votes;
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
                'account' => $characterEntity->account_name
            ])->get();

            if ($vote->count() == 0) {
                $voteEntity = new VoteL2jBrasil();
                $voteEntity->date = $data['date'];
                $voteEntity->ip = $data['ip'];
                $voteEntity->account = $characterEntity->account_name;
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
        if (request()->ip() == '3.86.48.116') {
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
        $char = request('char_name');

        $characterEntity = Character::where([
            'char_name' => $char
        ])->first();

        if (!$characterEntity) {
            return response()->json(['status' => false, 'message' => 'Char não encontrado.']);
        }

        $charId = $characterEntity->obj_Id;
        $accountName = $characterEntity->account_name;

        $votos = VoteTop100Arena::where(['account' => $accountName, 'claimed' => false])->get();

        if ($votos->count() > 0) {
            foreach ($votos as $voto) {
                $this->deliverReward($charId);

                $voto->claimed = true;
                $voto->save();
            }
            return response()->json(['status' => true, 'message' => 'Recompensa entregue na warehouse do seu char, selecione-o novamente para aparecer na warehouse.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Não foi detectado o voto.']);
        }
    }

    public function l2votes() {
        $ip = request()->getClientIp();
        //$ip = '201.77.166.231';
        $char = request('char_name');

        $characterEntity = Character::where([
            'char_name' => $char
        ])->first();

        if (!$characterEntity) {
            return response()->json(['status' => false, 'message' => 'Char não encontrado.']);
        }

        $charId = $characterEntity->obj_Id;

        $client = new Client();
        $apiUrl = 'https://l2votes.com/api.php?apiKey=1382e7197a_056169dbbf_74177ec396_1a&ip=' . $ip;

        $response = $client->get($apiUrl);

        $votes = json_decode($response->getBody()->getContents(), true);

        $newVotes = 0;

        foreach ($votes as $vote) {
            if ($vote['status'] == '1') {
                $voteRegistered = VoteL2Votes::where([
                   'account' => $characterEntity->account_name,
                    'date' => $vote['date'],
                    'ip' => $vote['ip']
                ])->first();

                if (!$voteRegistered) {
                    $voteEntity = new VoteL2Votes();
                    $voteEntity->ip = $vote['ip'];
                    $voteEntity->date = $vote['date'];
                    $voteEntity->account = $characterEntity->account_name;
                    $voteEntity->save();

                    $this->deliverReward($charId);

                    $newVotes++;
                }
            }

            if ($newVotes) {
                return response()->json(['status' => true, 'message' => 'Recompensa entregue na warehouse do seu char, após relogar ela estará na sua warehouse.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Não foi encotrado nenhum voto, ou talvez você já tenho votado na última 24 hora.']);
            }
        }
    }

    public function gtop100postback() {
        $voterIP = request('VoterIP');
        $success = request('success'); // 1 or 0
        $pingUsername = request('pingUsername');
        $pingbackKey = request('pingbackkey');

        if ($pingbackKey == 'yrUwYeRGES' && $pingUsername == 'radiador22' && $success == 1) {


            return response()->status(200);
        }
    }
}
