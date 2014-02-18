/*************************************************************************
    > File Name :  ../../js/item.js
    > Author  :      unasm
    > Mail :         douunasm@gmail.com
    > Last_Modified: 2013-09-18 20:34:27
 ************************************************************************/
$(document).ready(function(){
    pg();//集中了页面切换的操作
    //det();//头部商品介绍
    //comment();//评论的处理,还有分类没有处理
    //login();//登录
    //setOrder();
})

/*
 * pg切换有关的操作,tab 切换
 * 包括页面的评论和缩略图
 */
function pg() {
    var img = $("#mainImg");
    //缩略图和主图直接的切换
    $("#thumb").delegate("img" ,  'mouseenter' , function () {
        console.log("tsing");
        img.prop('src' , $(this).prop("src"));
    })
    // 评论和商品详情之间的切换
    $("#ittab").delegate('li' , 'click' , function () {
        var name = $(this).attr('name');
        if(name === 'good'){
            $("#ucom").css('display' , 'none');
            $("#good").fadeIn();
        } else {
            $("#good").css('display' , 'none');
            $("#ucom").fadeIn();
        }
    })
}


function date() {
//获得本地的时间"2013-4-6 20:27:32"的形式
    var time=new Date();
    return time.getFullYear()+"-"+(time.getMonth()+1)+"-"+time.getDate();
}

/**
 * det detail的操作和处理，就是进行下单的处理
 */
function det() {
    attrControl();
    //var attr = $("#attr").val();
    var total = $.trim($("#storeNum").text());
    var reg = /\d+$/;
    total = reg.exec(total);
    total = total[0];
    var buyNum = $("#buyNum"),num;
    //加减购买数量,目前不做，因为没有足够的空间
    /*
    $("#numCon").delegate("button","click",function (event) {
        var dir = $(this).attr("class");
        num = parseInt(buyNum.val());
        if(dir == "inc"){
            num = Math.min(num+1,total);
            buyNum.val(num);
        }else if(dir == "dec"){
            num = Math.max(num-1,1);
            buyNum.val(num);
        }
        event.preventDefault();
    })
    */
    var mImg = $("#mImg");
    //进入thumb则切换主图片
    $("#thumb").delegate("img","mouseenter",function () {
        $("#mImg").attr("src",$(this).attr("src"));
    })
    //对attr进行处理,数据的初始化和事件的绑定,对应的动作

    var inlimit = 0,flag;//时序控制
    console.log("ab");
    // 对用户的下单进行操
    $("#fmIf").delegate(".bton","click",function(){
        var dir = $(this).attr("name");
        $("#iprice").val($("#price").text());//将price保存到input中去,方便e点下单
        if(dir  === 'cart'){
            //e点购买的情况下其实不用js操作，直接就是了
            /*
             * 0.5s之内，连续点击则添加数量，之后发送请求
             */
            if(!user_id){
                $.alet("请首先登录，若已经登录，请刷新页面");
                $("#login").fadeIn();
                event.preventDefault();
                return false;
            }
            if(inlimit == 0){
                inlimit = 1;
                flag = setInterval(function(){
                    if(inlimit == 1){//为1 代表500ms内没有添加，2表示有，延迟500ms
                        clearInterval(flag);
                        sendOrd();
                        inlimit = 0;
                    }else{
                        inlimit=1;
                    }
                },300);
            }else{
                inlimit=2;
                var val = parseInt($("#buyNum").val(), 10);
                $("#buyNum").val(val+1);
            }
            event.preventDefault();
        }else if(dir == "inst"){
            if(!user_id){
                $.alet("请登录后点击购买");
                $("#login").fadeIn();
                event.preventDefault();
            }
        }
    })
}
