<div id="changeResult" class="changeResult" wire:ignore.self>
    <div class="back"></div>
    <div class="content">
        <a href="javascript:;" id="closeChangeResult"> <i class="fas fa-times"></i> </a>
        <h4>更改結果</h4>
        <div class="newBet">
            <p>最新一期下注: {{$changeResultNumber}}</p>
            @foreach($betRecord as $item)
            <a href="javascript:;" wire:click="viewUserResult({{$item->id}})">{{$item->user->name}}</a>
            @endforeach
        </div>
        <div class="timeleft">
            <p>操作剩餘時間</p>
            <p><span id="minutes">--</span>:<span id="seconds">--</span></p>
        </div>
        <div>
            <p>下注總碼量</p>
            <input type="number" disabled value="0" wire:model="totalBet">
        </div>
        <div>
            <p>原開獎結果</p>
            <p>{{$oriResultArr}}</p>
        </div>
        <div>
            <p>原結果輸贏</p>
            <input type="number" disabled value="0" wire:model="max">
        </div>
        <div>
            <p>欲更改結果</p>
            @foreach($changeResultArr as $key=>$item)
                <input type="number" class="change changeNumber" min="1" max="10" value="{{$item}}"> @if($key!=9) <span>-</span> @endif
            @endforeach
        </div>
        <div>
            <button class="reCalcBtn" wire:click="recalculate">重新計算</button>
        </div>
        <div>
            <p>更改後輸贏</p>
            <input type="number" id="reWinValue" disabled value="0">
        </div>
        <div class="btnList">
            <button class="cancel" id="cancelChangeResult">取消</button>
            <button class="submit" id="changeResultSubmit" wire:click="changeResultSubmit">確定</button>
        </div>
    </div>
</div>