/*************************************************************************
    > File Name :  ../js/waimai.js
    > Author  :      unasm
    > Mail :         douunasm@gmail.com
    > Last_Modified: 2013-08-10 10:50:01
 ************************************************************************/
$(document).ready(function(){
    var sea = $("#sea");
    var user = $(".pull");//为了使用dom，修改吧
    $(".sea").submit(function (event) {
        event.preventDefault();
        var key = $.trim(sea.val());
        for(var i = user.length-1;i>=0;i--){
            var val = $(user[i]).find(".shop").text();
            if(val.indexOf(key) != -1){
                $(user[i]).fadeIn();
                continue;
            }
            val = $(user[i]).find(".area").text();
            if(val.indexOf(key) != -1){
                $(user[i]).fadeIn();
                continue;
            }
            $(user[i]).fadeOut();
        }
    })
    if(user_id){
        console.log("sdef");
        $(".afli").css("display","none");
    }
})
