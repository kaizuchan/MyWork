function setFig(num) {
    // 桁数が1桁だったら先頭に0を加えて2桁に調整する
    var ret;
    if( num < 10 ) { ret = "0" + num; }
    else { ret = num; }
    return ret;
}

function showClock() {

    const youbi = ["日","月","火","水","木","金","土"];
    
    var now = new Date();
    var nowYear = now.getFullYear();
    var nowMonth  = now.getMonth() + 1;
    var nowDate  = now.getDate();
    var nowDay  = now.getDay();
    var nowHour = setFig(now.getHours());
    var nowMin  = setFig(now.getMinutes());
    var nowSec  = setFig(now.getSeconds());
    var nowDays = nowYear + "/" + nowMonth + "/" + nowDate + "(" + youbi[nowDay] + ")";
    var nowTime = nowHour + ":" + nowMin + ":" + nowSec;
    document.getElementById("nowDate").innerHTML = nowDays;
    document.getElementById("nowTime").innerHTML = nowTime;
}
setInterval('showClock()',1000);

// 勤務状況の背景色の変更
window.addEventListener("load", function myWork () {
    
    var color = document.getElementsByClassName('userLabel');
    for(var i = 0; i < color.length; i++){
        
        if(color.item(i).textContent == '勤務中') {
            color.item(i).style.backgroundColor = '#9BE9AD';
        }
        if(color.item(i).textContent == '休憩中') {
            color.item(i).style.backgroundColor = '#A3B1D8';
        }
        if(color.item(i).textContent == '退勤') {
            color.item(i).style.backgroundColor = '#E6A3A3';
        }
    }

});