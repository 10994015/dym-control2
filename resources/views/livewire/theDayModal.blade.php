<div class="theDayAnswerModal" id="theDayAnswerModal" wire:ignore.self>
        <div class="back"></div>
        <div class="content">
            <h5>開彩結果（風險控制-當日最大賠損）</h5>
            <a href="javascript:;" id="closetheDayAnswerModal"> <i class="fas fa-times"></i> </a>
            <div class="searchDiv">
                <div class="timeSearch">
                    <input type="time">
                    <button>時間查找</button>
                </div>
                <div class="numberSearch">
                    <input type="text" placeholder="請填入期號">
                    <button>期號查找</button>
                </div>
            </div>
            <div class="table">
                <div class="thead">
                    <div class="tr">
                        <div class="td">時間</div>
                        <div class="td">期號</div>
                        <div class="td">開彩結果</div>
                        <div class="td">操作</div>
                    </div>
                </div>
                <div class="tbody">
                    @foreach($drawResults as $drawResult)
                        <div class="tr">
                            <div class="td"> <p>{{$drawResult->bet_time}}:00 </p> </div>
                            <div class="td"> <p> {{$drawResult->number}} </p></div>
                            <div class="td"> 
                                @if($gameMode == 0)
                                <p>@php echo str_replace(',', '-', $drawResult->ranking) @endphp </p>
                                @else
                                    @if(date('Y-m-d H:i')>=$drawResult->bet_time)
                                        <p>@php echo str_replace(',', '-', $drawResult->ranking) @endphp</p>
                                    @else
                                        <p>尚未開彩</p>
                                    @endif
                                @endif
                             </div>
                            <div class="td">
                                @if(date('Y-m-d H:i')>=$drawResult->bet_time)
                                <button disable>無效</button>
                                @else
                                    @if($gameMode == 0)
                                        <button class="ok" wire:click="openChangeResult({{$drawResult->id}})" >更改結果</button>
                                    @else
                                        <button disabled class="no">更改結果</button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>