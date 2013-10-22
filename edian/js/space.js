$(document).ready(function  () {
    //var mastId = getmast();
    /*
    if(mastId == user_id){
        getJoin(user_id);
    }
    */
    spSendOrd();//发送订单的功能，登录之后才可以
    if(user_id){
        alogin();
    }else{
        $("#botmenu").css("display","none");
    }
    search();
});
function search(){
    var sea = $("#sea");
    var detail = $(".detail");
    $("#keySea").submit(function (event) {
        event.preventDefault();
        var key = $.trim(sea.val());
        if(!key){
            $.alet("请输入关键词");
            return false;
        }
        for(var i = detail.length-1;i>=0;i--){
            var temp = detail[i];
            var val = $(temp).attr("name");
            if(val.indexOf(key) != -1){
                show(user[i]);
                continue;
            }
            val = $(temp).text();
            if(val.indexOf(key) != -1){
                show(temp);
                continue;
            }
            hide(temp);
        }
    })
    function show(node){
        node = fdShop(node);
        $(node).fadeIn();
    }
    function hide(node){
        node = fdShop(node);
        $(node).fadeOut();
    }
    function fdShop(node){
        console.log($(node).attr("class"));
        while(node && ($(node).attr("tagName") != "LI")){
            node = node.parentNode;
        }
        console.log(node);
        return node;
    }
}
function spSendOrd(){
    //这个函数是下单后发送下单请求的函数
    var  cartHref,price,itemId,img;
    $("#recent").delegate(".item","click",function(event){
        itemId = $(this).attr("name");
        price = $(this).attr("title");
        if(!user_id){
            $.alet("请登录后选购");
            return false;
        }
        img = this.parentNode.parentNode;
        img = $(img).find("img").attr("src");
        console.log("sdf");
        cartHref = site_url+"/order/add/"+itemId;
        $.ajax({
            url: cartHref,
            type: 'POST',
            data: {"buyNum":1,"price":price},//呵呵，特殊情况下，不能这里添加数目
            dataType:'json',
            success: function (data, textStatus, jqXHR) {
                console.log(data);//目前就算了吧，不做删除的功能,返回的id是为删除准备的
                if(data["flag"]){
                    debugger;
                    $.alet("成功加入购物车");
                    appNewItem(data,img,"",price,itemId);//没有具体的info添加
                    //appNewItem (img,info,price,itemId,buyNum);//标准的样式
                    calTot();
                }else{
                    $.alet(data["atten"]);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alet("加入购物车失败");
            }
        });
    })
}
function getJoin (userId) {
    //获得我参与的板块的数据，因为考虑到隐私？服务器，数据量等问题，用户只允许看自己参与的帖子动态
    $.getJSON(site_url+"/space/getJoin/"+userId,function  (data,status){
        if(status == "success"){
            console.log(data);
            var div = document.createElement("div");
            $(div).attr("id","join").append("<p class = 'partT'><span>我<span class = 'direc'>参</span>与的</span></p>")
            var ul = document.createElement("ul");
            $(ul).addClass("clearfix content");
            for (var i = 0; i < data.length; i++) {
                $(ul).append(creLi(data[i]));
            };
            $(div).append(ul);
            $("body").append(div);
        }else console.log(xhr);
    });
}
function creLi (data) {
    var li = document.createElement("li");
    $(li).addClass("block").append("<a title = "+data["title"]+" href = "+site_url+"/showart/index/"+data["art_id"]+"><img class = 'block liImg' src = "+base_url+"upload/"+data["img"]+" /></a>");
    $(li).append("<a class = 'detail' href = "+site_url+"/showart/index/"+data["art_id"]+">"+data["title"]+"</a>");
    $(li).append("<p class = 'user clearfix'><span class = 'part'>￥:"+data["price"]+"</span><a href = "+site_url+"/space/index/"+data["author_id"]+"><span class = 'master tt'>店主:"+data["name"]+"</span></a></p>");
    $(li).append("<p class = 'user'>浏览:"+data["visitor_num"]+"/回复:"+data["comment_num"]+"<span class = 'time'>"+data["time"]+"</span></p>");
    return li;
}
