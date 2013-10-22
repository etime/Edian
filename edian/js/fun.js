/*************************************************************************
    > File Name :  ../../js/fun.js
    > Author  :      unasm
    > Mail :         douunasm@gmail.com
    > Last_Modified: 2013-09-19 23:33:44
 ************************************************************************/
window.onload = ready;
function ready(){
    var str = "";
    timeCal();
    for(var i = 0;i < 1000;i++){
        //$("body").append("<img class = 'snow'/>");
        str += "<img class = 'snow' \/>";
    }
    $("body").append(str);
    var imgs = $(".snow");
    for(var i = imgs.length;i >= 0;i--){
        var val = parseInt(Math.random()*3)+4;
        var dis = parseInt(Math.random()*2);
        if(dis%2){
            dis = -dis;
        }
        $(imgs[i]).css("width",val);
        $(imgs[i]).css("height",val+dis);
        $(imgs[i]).css("opacity",Math.random());
        var valw = parseInt(Math.random()*40);
        var dis = parseInt(Math.random()*40);
        if((dis%10)){
            dis = -dis;
        }
        var tt = parseInt(Math.random()*8);
        if(tt%2){
            tt = -tt;
        }
        var valh = 40+dis-valw;
        $(imgs[i]).css("top",valw+"%");
        $(imgs[i]).css("left",tt+valh+"%");
    }
    for(var i = parseInt(imgs.length/3);i >= 0;i--){
        var time = parseInt(Math.random()*100);
        fadeTime(imgs[i],time);
    }
    function fadeTime(node,time){
        setTimeout(function() {
            fade(node);
        }, time);
    }
    function fade(node){
        var time = parseInt(Math.random()*9000)+9000;
        var flag = 0;
        window.setInterval(function(){
            $(node).fadeToggle();
            if(flag)$(node).fadeToggle();
            else{
                if(time%2)$(node).fadeIn();
                else $(node).fadeOut();
            }
        },time);
    }
}
var time = 10;
function timeCal(){
    time--;
    if(time < 0){
        $(".cover").fadeOut();
    }else{
        $("#atten").text(time);
        setTimeout("timeCal()",1000);
    }
}
