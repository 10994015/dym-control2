<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Game;
use App\Models\GameInfos;
use App\Models\Gametype;
use App\Models\Operate;
use App\Models\RiskBet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class GameManagement extends Component
{
    public $gameTypes = [];
    public $games = [];
    public $selectGameType;
    public $selectGame;
    public $drawResults = [];
    public $info = [];
    //飛機:23
    public $gameNumber = -1;
    public $changeResultArr = [];
    public $changeResultNumber;
    public $gameMode;
    public $oriResultArr;
    public $betRecord = [];
    public $max;
    public $totalBet;
    public $guessArr = [];
    public $focusId;
    public $operates = [];

    protected $listeners = ['changeSubmit'=>'changeSubmit'];

    public function mount(){
        $this->gameTypes = Gametype::all();
    }
    public function changeGameType(){
        if($this->selectGameType != "-1" ){
            $this->games = Game::where('gametype_id' , $this->selectGameType)->get();
        }
        
    }
    public function changeGame(){
        if($this->selectGame != "-1"){
            $this->dispatchBrowserEvent('openSearch', ['password'=>'1']);
        }else{
            $this->dispatchBrowserEvent('openSearch', ['password'=>'-1']);
        }
    }
    public function searchFn(){
        $this->gameNumber = -1;
        if($this->selectGameType == 2 && $this->selectGame == 3){
            $this->gameNumber = 23;
        }
        $this->info = GameInfos::where('gamenumber', $this->gameNumber)->first();
        $this->gameMode = $this->info->mode;
        // Log::info($this->gameMode);
    }
    public function viewDraw(){
        if($this->gameNumber == 23){
            $this->drawResults = Answer::where('bet_time', 'LIKE', date('Y-m-d H').'%')->get();
        }
    }
    public function openChangeResult($id){
        $answer = Answer::where('id', $id)->first();
        
        $this->changeResultArr = explode(',', $answer->ranking);
        $this->oriResultArr = str_replace(',', ' - ', $answer->ranking);
        // Log::info($this->oriResultArr);
        $this->changeResultNumber = $answer->number;
        $risk_bet = RiskBet::where('bet_number', $this->changeResultNumber)->orderBy('result', 'DESC')->get();
        $this->betRecord = $risk_bet;
        // Log::info( $this->betRecord);
        // Log::info($risk_bet);
        if(count($this->betRecord) > 0){
            Log::info("+++");
            $this->max = $risk_bet[0]->result;
            $this->totalBet = $risk_bet[0]->money;
            $this->focusId = $risk_bet[0]->id;
        }else{
            Log::info("---");
            $this->max = 0;
            $this->totalBet = 0;
        }
        
        // Log::info($this->changeResultNumber);
        $this->dispatchBrowserEvent('openChangeResultModal', ['bet_time'=>$answer->bet_time]);
    }
    public function recalculate(){
        $risk_bet = RiskBet::where('id', $this->focusId)->first();
        $this->guessArr = $risk_bet->guess;
        // Log::info($this->guessArr);
        $this->dispatchBrowserEvent('recalculate', ['guessArr'=>json_encode($this->guessArr)]);
    }
    public function changeSubmit($arr){
        $this->changeResultArr = $arr;
        $answer = Answer::where('number', $this->changeResultNumber)->first();
        // Log::info(implode(",", $this->changeResultArr));
        $answer->ranking = implode(",", $this->changeResultArr);
        $answer->save();
    }
    public function viewUserResult($id){
        $risk_bet = RiskBet::where('id', $id)->first();
        $this->max = $risk_bet->result;
        $this->totalBet = $risk_bet->money;
        $this->focusId = $risk_bet->id;
        $this->guessArr = $risk_bet->guess;
    }
    public function changeResultSubmit(){
        $this->max = 0;
        $this->totalBet = 0;
        $this->guessArr = [];
        $this->focusId = -1;
    }
    public function updateLock(){
        $gameInfo =  GameInfos::where('gamenumber', $this->gameNumber)->first();

        $operate = new Operate();
        $operate->gamenumber = $this->gameNumber;
        $operate->before = $gameInfo->mode;
        $operate->after = $this->gameMode;
        $operate->user_id = Auth::id();

        $gameInfo->mode = $this->gameMode;
        $gameInfo->save();
        $operate->save();    
    }
    public function modeRecord(){
        $operates = Operate::where('gameNumber', $this->gameNumber)->orderBy('id', 'DESC')->get();
        $this->operates = $operates;
    }
    public function render()
    {
        
        return view('livewire.game-management')->layout('livewire/layouts/base');
    }
}
