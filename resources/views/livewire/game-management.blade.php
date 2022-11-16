<div id="gameManagement" >
    <div class="title">遊戲設定</div>
    <div class="ivu-body">
        <div class="left">
            <div class="game-type">
                <p>遊戲類型</p>
                <select wire:model="selectGameType" wire:change="changeGameType">
                    <option value="-1" selected >遊戲類型</option>
                    @foreach($gameTypes as $type)
                    <option value="{{$type->id}}">{{$type->typename}}</option>
                    @endforeach
                </select>
            </div>
            <div class="game-name"  wire:change="changeGame">
                <p>遊戲名稱</p>
                <p wire:loading class="loading" wire:target="changeGame">Loading...</p>
                <select wire:model="selectGame" wire:loading.remove>
                    <option value="-1" selected>遊戲名稱</option>
                    @foreach($games as $game)
                    <option value="{{$game->id}}">{{$game->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="right">
        @if(!empty($info))
            <button class="search open" id="searchBtn"  wire:click="searchFn">搜尋</button>
            <button class="unlock open" id="unlock">解鎖編輯</button>
        @else
            <button class="search" id="searchBtn" disabled wire:click="searchFn">搜尋</button>
            <button class="unlock" id="unlock" disabled>解鎖編輯</button>
        @endif
            <button class="updatelock open" id="updatelock" wire:click="updateLock">更新鎖上</button>
            <button class="reduction open" id="reduction">還原</button>
        </div>
    </div>
    @if(!empty($info))
    <div class="content" id="pageContent" >
        <div class="gameName"><h2>{{$info->game_name}}</h2></div>
        <div class="tableBox">
            <table class="table table-bordered">
                <tr>
                    <td class="table-title">開彩資訊</td>
                    <td class="table-content ">
                        <div class="drawInfo">
                            <div class="left">
                                <h4>開彩模式</h4>
                                <select name="" id="modeSelect" disabled wire:model.defer="gameMode">
                                    <option value="0" selected>當日預知</option>
                                    <option value="1">風險控制-當日最大損賠</option>
                                </select>
                            </div>
                            <div class="center">
                                <button wire:click="viewDraw" id="viewDrawBtn">查看開彩結果</button>
                            </div>
                            <div class="right">
                                <button wire:click="modeRecord" id="modeRecordBtn">模式變更紀錄</button>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <script>
        const viewDrawBtn = document.getElementById('viewDrawBtn');
        const modeRecordBtn = document.getElementById('modeRecordBtn');
        const closeModeRecord = document.getElementById('closeModeRecord');
        viewDrawBtn.addEventListener('click', ()=>{
            theDayAnswerModal.style.display = "flex";
        });
        modeRecordBtn.addEventListener('click', ()=>{
            modeRecord.style.display = "flex";
        });
        closeModeRecord.addEventListener('click', ()=>{
            modeRecord.style.display = "none";
        });
    </script>
    @endif
    @include('/livewire/theDayModal')
    @include('livewire/changeResult')
    @include('livewire/modeRecord')
</div>
