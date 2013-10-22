/*************************************************************************
    > File Name :  ../js/phone.js
    > Author  :      unasm
    > Mail :         douunasm@gmail.com
    > Last_Modified: 2013-08-07 20:16:49
 ************************************************************************/
/*
 * 这里集成了我对手机端的探索,以后再说吧
 */
function mouse () {
    //睡觉了，下面就是关于位置的判断http://www.neoease.com/tutorials/cursor-position/
    var dirstate = 1;//前后三次，对比是否是水平滑动-》角度在30度以内的2*y>x
    //dir 表示侧边栏的状态，1表示上次向右，已经展开，2向左，闭合的状态，初始状态为打开，为1
    var sp = {x:0,y:0},ep = {x:0,y:0},doc = document;
    var botDir = $("#bottomDir");
    if(doc.addEventListener){
        doc.addEventListener("touchstart",first,false);
        doc.addEventListener("touchmove",move,false);
    }
    function first (event) {
        botDir.css("display","none");//将底部边框移动 的时候，有它影响不好
        event = event.touches[0];
        sp.x = event.clientX;
        sp.y = event.clientY;
    }
    var ulCont = $("#ulCont");
    var hiA = $("#hiA");
    var block = 0;//阻塞move的检测
    function move (event) {
        if(event.touches.length>1)return;
        //双指时候，不该触发的。
        if(block)return;
        block = 1;
        var ev = event.touches[0];
        ep.x = ev.clientX;
        ep.y = ev.clientY;
        var y = Math.abs(ep.y-sp.y);
        var x = ep.x - sp.x;
        if((dirstate == 1)&&(2*y<(-x))){//x 小于0代表左滑动，关闭
            event.preventDefault();
            hide();
            dirstate = 2;
        }else if((dirstate == 2)&&(2*y<x)){//大于0向右滑动，打开，dir为2，状态
            event.preventDefault();
            dirstate = 1;
            dir.css("top",$(window).scrollTop());//平板上，宽度或许会大于970px，而position还是fixed的状态，需要下面的修改
            dir.css("position","absolute");
            show();
        }
        setTimeout(function  () {
            block = 0;
        },500);
    }
    function show () {
        //控制边栏的显隐和主要区域的移动
        dir.css("display","block");
        ulCont.animate({
            "margin-left":"250px"
        },300);
        hiA.text("隐藏");
    }
    function hide () {
        hiA.text("显示");
        ulCont.animate({
            "margin-left":"0px"
        },300);
        dir.fadeOut(200);
    }
    //控制边框的显示隐藏和旁边body的显示margin,效果一般，不绚烂，漂亮的将来作吧
    //整合到dir.js中
    var flag = 1;//1 表示还在显示，0表示正在隐藏中
    if(isPc==0){
        hiA.css("display","inline");
        $("#hiA").click(function  () {
            flag?hide():show();
            flag = 1-flag;
        });
    }
    doc.ontouchend = function  () {
        botDir.fadeIn(999);
    };

}
