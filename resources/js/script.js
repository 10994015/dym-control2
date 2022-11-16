const sideBarLink = document.getElementsByClassName('sideBarLink');
const searchBtn = document.getElementById('searchBtn');
const theDayAnswerModal = document.getElementById('theDayAnswerModal');
const closetheDayAnswerModal = document.getElementById('closetheDayAnswerModal');
const changeResult = document.getElementById('changeResult');
const closeChangeResult = document.getElementById('closeChangeResult');
const changeNumber = document.getElementsByClassName('changeNumber');
const changeResultSubmit = document.getElementById('changeResultSubmit');
let minutes = "";
let seconds = "";
let x = null;
let guessAirArray = {};
let nowAnswer = [];
const reWinValue = document.getElementById('reWinValue');
const unlock = document.getElementById('unlock');
const updatelock = document.getElementById('updatelock');
const reduction = document.getElementById('reduction');
if(window.location.pathname.includes('home')){
    sideBarLink[0].classList.add('focus');
}
if(window.location.pathname.includes('gameManagement')){
    sideBarLink[4].classList.add('focus');
}
window.addEventListener('openSearch', e=>{
    if(e.detail.password == '1'){
        searchBtn.classList.add('open');
        searchBtn.disabled = false;
    }else{
        searchBtn.classList.remove('open');
        searchBtn.disabled = true;
    }
})

function viewDrawFn(){
    theDayAnswerModal.style.display = "flex";
}
closetheDayAnswerModal.addEventListener('click', ()=>{
    theDayAnswerModal.style.display = "none";
})
window.addEventListener('openChangeResultModal', e=>{
    let nowTime = new Date(e.detail.bet_time).getTime();
    document.getElementById('seconds').innerHTML ="";
    document.getElementById('seconds').innerHTML = "";
    minutes = "";
    seconds = "";
    downTime(nowTime);
    reWinValue.value = 0;
    changeResult.style.display = "flex";
})
closeChangeResult.addEventListener('click',()=>{
    changeResult.style.display = "none";
    clearInterval(x);
})
cancelChangeResult.addEventListener('click', ()=>{
    changeResult.style.display = "none";
    clearInterval(x);
})

changeResultSubmit.addEventListener('click', ()=>{
    let result = new Set();
    let arr = [];
    for(let i=0;i<changeNumber.length;i++){
        if(!result.has(changeNumber[i].value)) {
            result.add(changeNumber[i].value)
        };
    }
    if(result.size < 10){
        Swal.fire(
            '警告',
            '排名請勿重複',
            'warning'
        )
        return;
    }
    arr = Array.from(result);
    // console.log(arr);
    
    window.Livewire.emit('changeSubmit', arr);
    Swal.fire(
        '更新成功',
        '',
        'success'
    )
    clearInterval(x);
})
unlock.addEventListener('click', ()=>{
    updatelock.style.display = "block";
    reduction.style.display = "block";
    unlock.disabled = true;
    unlock.style.display = "none";
    searchBtn.disabled = true;
    searchBtn.classList.remove('open')
    document.getElementById('modeSelect').classList.add('open');
    document.getElementById('modeSelect').disabled = false;
    document.getElementById('viewDrawBtn').disabled = true;
    document.getElementById('viewDrawBtn').classList.add('lock');
    document.getElementById('modeRecordBtn').disabled = true;
    document.getElementById('modeRecordBtn').classList.add('lock');
})
window.addEventListener('recalculate', e=>{
    let result = new Set();
    for(let i=0;i<changeNumber.length;i++){
        if(!result.has(changeNumber[i].value)) {
            result.add(changeNumber[i].value)
        };
    }
    if(result.size < 10){
        Swal.fire(
            '警告',
            '排名請勿重複',
            'warning'
        )
        return;
    }
    guessAirArray = JSON.parse(JSON.parse(e.detail.guessArr));
    nowAnswer = [];
    nowAnswerFn();
    // console.log(nowAnswer);
    reWinValue.value = calcBetFn();
    // console.log();
    
    
})
function downTime(nowTime){
    
    x = setInterval(()=>{
        let now = new Date().getTime();
        
        let distance = nowTime - now;
        
        
    
        minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
        document.getElementById('minutes').innerHTML = minutes;
        document.getElementById('seconds').innerHTML = seconds;
        if(nowTime < now){
            changeResult.style.display = "none";
            clearInterval(x);
        }
    },1000)
}
function nowAnswerFn(){
    for(let i=0;i<changeNumber.length;i++){
        nowAnswer.push(changeNumber[i].value);
    }
}
function calcBetFn(){
    let winMoney = 0;
    //賠率
    let odds = 2;
    for(let i=1;i<=10;i++){
        // console.log(guessAirArray[`no${i}`]);
        for(let j=1;j<=10;j++){
            if(guessAirArray[`no${i}`][`air${j}`]['money'] > 0){
                // console.log(guessAirArray[`no${i}`][`air${nowAnswer[i-1]}`]);
                if(j == nowAnswer[i-1]){
                    winMoney = winMoney + (guessAirArray[`no${i}`][`air${j}`]['money']*odds);
                }
            }
        }
    }

    return winMoney;
    // window.Livewire.emit('calcMoney', winMoney);

    
}


