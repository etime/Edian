/**
 * @name        ../js/comment.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-18 21:30:01
*/
/**
 * 集中了和评论有关的操作，包括隐藏，添加，上传等等
 */
function comment(){
    $("#com").delegate(".reCom","click",function(event){
        console.log(event.srcElement);
        if(!user_id){
            $.alet("请首先登录");
            return false;
        }
        var ftr = this;
        var node = event.srcElement;
        var name = $(node).attr("name");
        console.log(name);
        if(name == "comRe"){
            $(ftr).find("form").slideToggle();//.slideDown();
        }else if(name == "sub"){
            //这里是提交
            var cont = $.trim($(ftr).find("textarea").val());
            var action = $.trim($(ftr).find("form").attr("action"));
            if(cont.length < 2){
                $.alet("呵呵,别这么短嘛");
                return false;
            }
            var id = $(node).attr("id");
            upCom(action,cont,appcom,id);
            event.preventDefault();
        }else if(name == "context"){
            $(node).animate({
                height:"80px"
            })
        }
    })
    $("#comForm").submit(function(){
        console.log("开始处理上传之前的事情");
        if(!user_id){
            $.alet("请首先登录哦");
            return false;
        }
        var context = $.trim($("#context").val());
        if(context.length < 5){
            $.alet("字数少，显示不出诚意嘛");
            return false;
        }
        var score = $("#score").val();
        upCom(site_url+"/item/newcom/"+itemId,context,newComBack,score);
        event.preventDefault();
    })
    $("#context").focus(function(){
        $(this).animate({
            height:"100px"
        })
    })
    /***************处理评分显示的问题*********************/
    var mks = $(".mk"),temp,mark = new  Array(0,0,0,0);
    for (var i = 0, l = mks.length; i < l; i ++) {
        temp = parseInt($(mks[i]).text());
        console.log(temp);
        if(temp== 10){
            mark[0]++;
        }else if(temp > 5){
            mark[1]++;
        }else if(temp){
            mark[2]++;
        }else{
            mark[3]++;
        }
    }
    mks = $("#coms span");
    for(var i = 0,l = mks.length;i < l;i++){
        $(mks[i]).text(mark[i]);
    }
    /******************评分结束*************************/
    $("#coms").delegate("a","click",function(event){
        var name = $(this).attr("name");
        if(name == "a"){
            showAge(0,10);
        }else if(name == "h"){
            showAge(10,10);
        }else if(name == "m"){
            showAge(5,9)
        }else if(name == "l"){
            showAge(1,4);
        }else if(name == "w"){
            showAge(0,0);
        }
        event.preventDefault();
    })
    var comli = $("#com li");
    function showAge(low,high){
        var val;
        for(var i = 0,l = comli.length;i< l;i++){
            val = parseInt($(comli[i]).find(".mk").text());
            if((val<=high) && (low <= val)){
                $(comli[i]).fadeIn();
            }else{
                $(comli[i]).fadeOut();
            }
        }
    }
    /**********添加评论时候评分的处理***********************/
    var txts = $("#txts"),score = $("#score"),mkImg = $("#mark img");
    $("#mark").delegate("img","click",function(event){
        var name = parseInt($(this).attr("name"));
        txts.text(name);
        score.val(name);
        for(var i = 0;i <= name;i++){
            $(mkImg[i]).removeClass("no");
        }
        for(var i = name+1;i <= 10;i++){
            $(mkImg[i]).addClass("no");
        }
    })
    /***********************************/
}


function newComBack(context,score) {
    var tar = $("#com li").first();
    var str = "<li><p class = 'cp'><span>评分:</span><span class = 'sp'>"+score+"</span><span>"+user_name+"</span><span>"+date()+"</span></p><blockquote>"+context+"</blockquote><div class = 'reCom' ><span name = 'comRe' class = 'comRe'>回复</span><form action="+site_url+'/item/appcom/'+itemId+" method='post' accept-charset='utf-8' enctype = 'multipart/form-data' style = 'display:none'><textarea  name = 'context' placeholder = '评论...' ></textarea><input type='submit' name='sub'  value='回复' /></form></div></li>";
    $(tar).before(str);
    console.log(str);
    $("#context").val("");
    $("#context").animate({
        "height":"33px"
    })
}
function appcom(cont,id){
    var node = document.getElementById(id);
    node = node.parentNode;
    $(node).slideUp();//将form隐藏
    node = node.parentNode;//插入到recom之前
    var str = "<div class = 'reCom'><p>"+cont+"</p><span>"+user_name+"</span><span>"+date()+"</span></div>";
    $(node).before(str);
    var area = $(node).find("textarea");
    $(area).val("");
}

function upCom(href,con,callback,score) {
    $.ajax({
        url: href,
        type: 'POST',
        dataType: 'json',
        data:{"context":con,"score":score},
        complete: function (jqXHR, textStatus) {
            console.log(textStatus);
        },
        success: function (data, textStatus, jqXHR) {
            //success callback;
            if(data["flag"] == -1){
                $.alet($data["atten"]);
            }else{
                $.alet("评论成功");
                callback(con,score,data["flag"]);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $.alet("评论失败");
            // error callback
        }
    });
}

