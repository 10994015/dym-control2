@php
$modeArr = [0=>'當日預測', 1=>'風險控制-當日最大賠損'];
@endphp
<div id="modeRecord" class="modeRecord" wire:ignore.self>
    <div class="content">
        <a href="javascript:;" id="closeModeRecord"><i class="fas fa-times"></i></a>
        <div class="data">
            <div class="data-title">
                <div class="item">時間</div>
                <div class="item">變更前</div>
                <div class="item">變更後</div>
                <div class="item">操作帳號</div>
            </div>
            <div class="data-box">
                @foreach($operates as $item)
                <div class="data-list">
                    <div class="item">
                        <p>{{$item->created_at}}</p>
                    </div>
                    <div class="item">
                        <p>{{$modeArr[$item->before]}}</p>
                    </div>
                    <div class="item">
                        <p>{{$modeArr[$item->after]}}</p>
                    </div>
                    <div class="item">
                        <p>{{$item->user->email}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>