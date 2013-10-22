/*************************************************************************
    > File Name :  ../../js/item.js
    > Author  :      unasm
    > Mail :         douunasm@gmail.com
    > Last_Modified: 2013-09-18 20:34:27
 ************************************************************************/

$(document).ready(function(){
    pg();//集中了页面切换的操作
    det();//头部商品介绍
    comment();//评论的处理,还有分类没有处理
    login();//登录
})
function login(){
    var atten = $("#atten");
    var login = $("#login");
    if(!user_id){
        var flag = 0;
        atten.text("登陆");
        $(".lok").click(function(event){
            //购物车的登录
            console.log("testing");
            if(user_id){
                return false;
            }
            event.preventDefault();
            login.fadeToggle();
            if(flag == 0){
                flag = 1;//禁止发送多次，事件只绑定一次
                var url = login.attr("action")+"/1";
                login.submit(function(event){
                    var userName = login.find("input[name = 'userName']").val();
                    var passwd = login.find("input[name = 'passwd']").val();
                    if(!(userName && passwd))return false;
                    login.fadeOut();
                    $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: {"userName":userName,"passwd":passwd},
                            success: function (data, textStatus, jqXHR) {
                                console.log(data);//这里还没有进行测试
                                if(data["flag"]){
                                    user_id = data["user_id"];
                                    user_name = userName;
                                    atten.unbind("click");
                                    alogin();//alogin中处理登录之后的事情
                                    $.alet("登录成功");
                                }else{
                                    $.alet(data["atten"]);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                $.alet("登录失败了");
                            }
                        });
                    event.preventDefault();
                });
            }
        })
    }else{
        alogin();
    }
    /*
    function alogin(){
        atten.text("购物车");
        var cart = $("#cart");
        atten.click(function(){
            cart.slideToggle();
        })
        getCart();
        $("#order").delegate(".del","click",function(event){
            var href = $(this).attr("href");
            ajOper(href,delCart,this);
            event.preventDefault();
        })
    }
    */
    $("#cel").click(function(event){
        //cancel login
        login.fadeOut();
        event.preventDefault();
    })
}

function pg() {
    //pg切换有关的操作
    var temp,pg = $("#pg");//pg 页面切换的ul
    var des = $("#des"),dcom = $("#dcom");
    var last = des;//决定下面那个首先显示
    $("#judge").click(function () {
        var lis = pg.find("li");
        for (var i = lis.length - 1; i >= 0; i --) {
            temp = $(lis[i]).attr("class");//不知道所个class的时候，会不会出错呢
            if(temp == "cse")$(lis[i]).removeClass("cse");
            temp = $(lis[i]).attr("name");
            if(temp == "comment"){
                $(lis[i]).addClass("cse");
                last.css("display","none");
                last = dcom;
                last.fadeIn();
            }
        }
    });
    pg.delegate("li","click",function(){
        var name = $(this).attr("name");
        pg.find(".cse").removeClass("cse");
        $(this).addClass("cse");
        last.fadeOut(function(){
            if(name == "more"){
                last = des;
                last.fadeIn();
            }else if(name == "comment"){
                last = dcom;
                last.fadeIn();
            }
        })
    })
}
function det() {
    var total = $.trim($("#storeNum").text());
    var reg = /\d+$/;
    total = reg.exec(total);
    total = total[0];
    var buyNum = $("#buyNum"),num;
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
    var mImg = $("#mImg");
    void function(){
        //进入thumb则切换主图片
        $("#thumb").delegate("img","mouseenter",function () {
            mImg.attr("src",$(this).attr("src"));
        })
    }();
    void function(){
        //对attr进行处理,数据的初始化和事件的绑定,对应的动作
        nodeAttr = $(".attr");
        var temp,price = $("#price"),tStore = $("#tS"),len = Array();
        var info = attr.split(";");
        var ordinfo = Array();//保存属性值的，我想添加的时候方便吧
        function findIdx(node){
            var locx = $(node).find(".atv").attr("name");
            if(!locx)locx = $(node).attr("name");
            return locx;
            //如果找到img，就切换图片
        }
        function changeInfo(node) {
            var info = $(node).find(".atv").attr("title");
            if(!info){
                info = $(node).attr("title");
                info = spf(info);
            }
            return info;
        }
        for (var i = 0, l = nodeAttr.length; i < l; i ++) {
            //对第一个进行选择,在接下来的地方修改数值参数
            temp = $(nodeAttr[i]).attr("name",i).find(".atmk");
            len[i] = temp.length;
            $(temp[0]).addClass("atvC");
            temp = $(nodeAttr[i]).find(".atv");//atmk 是标记选择的地方，atv才是真正的值，atv是atmk的自身或子元素
            temp = $(temp[0]).attr("title");
            ordinfo[i] = spf(temp);
        }
        console.log(ordinfo);
        function spf(str){
            if(str){
                str = str.split(":");
                return str[0];
            }
            return false;
        }
        var ordNode = $("#info");//#info的js读取
        if(nodeAttr.length == 1){
            console.log("length 1");
            var locx = 0;
            for (var i = 0; i < len[0]; i ++) {
                info[i] = info[i].split(",");
            }
            total = info[locx][0];//修改总的值
            tStore.text(info[0][0]);
            price.text(info[0][1]);
            ordNode.val(ordinfo[0]);
            nodeAttr.delegate(".atmk","click",function(){
                locx = findIdx(this);
                var par = this.parentNode;
                $(par).find(".atvC").removeClass("atvC");
                $(this).addClass("atvC");
                tStore.text(info[locx][0]);
                total = info[locx][0];//修改总的值
                price.text(info[locx][1]);
                //#info中信息的修改，他对应被选择的属性的提交
                ordinfo[0] = changeInfo(this);
                ordNode.val(ordinfo[0]);
                var src = $(this).find("img").attr("src");
                if(src)mImg.attr("src",src);
                //info的初始化
            });
        }else if(nodeAttr.length == 2){
            var loc = Array(),cnt = 0;
            loc[0] = 0,loc[1] = 0;
            temp = Array();
            console.log(ordinfo[0]);
            ordNode.val(ordinfo[0]+"|"+ordinfo[1]);
            for(var i = 0;i < len[0];i++){
                temp[i] = new Array();
                for(var j = 0;j < len[1];j++){
                    temp[i][j] = info[cnt].split(",");
                    cnt++;
                }
            }
            info = temp;
            tStore.text(info[0][0][0]);//修改第一个对应的库存和价格
            total = info[0][0][0];
            price.text(info[0][0][1]);
            nodeAttr.delegate(".atmk","click",function(){
                var par = this.parentNode;
                /************添加标识*******************/
                $(par).find(".atvC").removeClass("atvC");
                $(this).addClass("atvC");
                var src = $(this).find("img").attr("src");//切换img图片
                if(src)mImg.attr("src",src);
                /************添加表示********************/
                var idx = $(par).attr("name");//表示是第几个属性
                loc[idx] = findIdx(this);//修改坐标
                tStore.text(info[loc[0]][loc[1]][0]);
                total = info[loc[0]][loc[1]][0];//修改总的数值
                price.text(info[loc[0]][loc[1]][1]);
                //对价格库存进行修改
                //读取#info所需要的信息，然后修改
                //ordinfo[idx] = $(this).attr("src") || $(this).text();
                ordinfo[idx] = changeInfo(this);
                ordNode.val(ordinfo[0]+"|"+ordinfo[1]);
            })
        }
    }();
    var inlimit = 0,flag;//时序控制
    var ts  = $("#tS");
    //short for form info
    $("#fmIf").delegate(".bton","click",function(){
        var dir = $(this).attr("name");
        var tsV = ts.text();
        $("#iprice").val($("#price").text());//将price保存到input中去,方便e点下单
        if(dir  == "cart"){
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
                    console.log("inner interval");
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
                var val = parseInt($("#buyNum").val());
                $("#buyNum").val(Math.min(tsV,val+1));
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
function deinfo(str) {
    if(str){
        var temp = str.split("|");
        var res = "",now;
        for (var i = 0, l = temp.length; i < l; i ++) {
            now = temp[i].split(":");
            if(i == 0){
                res+=now[0];
            }else{
                res+="|"+now[0];
            }
        }
        console.log(res);
        return res;
    }
    return false;
}
function sendOrd(){
    //发送订单,加入购物车,det中 fmIf调用
    var info = $("#info").val();
    info  =  deinfo(info);
    var buyNum = $("#buyNum").val();
    //var reg = /http\:\/\/[\/\.\da-zA-Z]*\.jpg/;
    var  cartHref = site_url+"/order/add/"+itemId;
    var price = $("#price").text();
    $.ajax({
        url: cartHref,
        type: 'POST',
        data: {"info":info,"buyNum":buyNum,"price":price},
        dataType:'json',
        success: function (data, textStatus, jqXHR) {
            console.log(data);//目前就算了吧，不做删除的功能,返回的id是为删除准备的
            if(data["flag"]){
                $.alet("成功加入购物车");
                //单纯的添加，计算的人物交给CalTot做
                //flag 表示有没有在原来的购物车中找到店家
                appNewItem(data,$("#mImg").attr("src"),info,price,itemId,buyNum);
                calTot();
            }else{
                $.alet(data["atten"]);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $.alet("加入购物车失败");
        }
    });
}

function comment(){
    //集中了和评论有关的操作，包括隐藏，添加，上传等等
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
function date() {
//获得本地的时间"2013-4-6 20:27:32"的形式
    var time=new Date();
    return time.getFullYear()+"-"+(time.getMonth()+1)+"-"+time.getDate();
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
