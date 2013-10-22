/*
author:         unasm
email:          douunasm@gmail.com
last_modefied:  2013/04/05 04:33:37 PM
*/

var seaFlag,passRight,hisLen,back,np = $("#np"),dir = $("#dir"),tot=Array(),isPc;
//back 后退，为了添加后退的功能而添加的标志变量

function tse(){
    var val;//控制页面点击消失提示字的函数,移动到dir.js中
    $(".valTog").focus(function(){
        val = $(this).val();
        $(this).removeAttr("value");
    }).blur(function(){
        if($(this).val()==""){
            $(this).attr("value",val);
        }
    });
    var ent = $("#ent"),tip = $("#lotip");
    $("#showsub").click(function  (event) {
        checkUserName();
        ent.animate({
            opaacity:'toggle',
            height:'toggle'
        },400);
        tip.text("显示登陆");
        event.preventDefault();
    });
}

function urlChange () {
    //控制url的跳转，更改，就是为了不使用iframe的情况下进行后退不失效
    //history.length的方式不可靠，最长只有50，极限测试下，会挂的
    //back的成立条件是首先会冒泡的之前的delegate 的dir上，然后才会到hashchange上
    if(back){
        var ans = window.location.href.split("#");
        if((ans.length>1)&&(ans[1]!="")){
            ans = ans[1];
        }else ans = "";
        if(ans){
            getSea(ans);
            /*
            reg = /^\d+$/;
            if(reg.exec(ans)){
                if(ans>99){//如果是数字，并且大于100，是跳转，不然只是业内跳转
                    ans = parseInt(ans/100)-1;
                    reg = /\d+$/;
                    $(".part").each(function  () {
                        if(reg.exec(this.href) == ans){
                            chaCon(this);
                            return ;
                        }
                    });
                }
            }else{//不是数字就是搜索
                getSea(ans);
            }
            */
        }
    }
    return false;
}
function chaCon (node) {
    //在后退和前进都需要使用到的函数，独立出来的,但是IE就不会用到这个函数
    seaFlag = 0;//后退的判断完毕之后，进行后退之前的处理，如颜色，url的更改
    var reg = /\d+$/;
    temp = reg.exec(node.href);
    if(temp!=now_type){
        var href = window.location.href.split("#");
        if(href.length>1)
            href = href[0];
        if(temp == 0){
            $("#flexslider").slideDown();
        }else {
            $("#flexslider").slideUp();
        }
        window.location.href = href+"#"+(parseInt(temp)+1)*100;
        //刷新的时候，是不会将uri的信息给服务器的，所以给出的信息不是当前页面的,是bug
        $.cookie("uri",temp,{expires:1});//IE是不会通过url的，所以去掉IE
        //var fornow = href.replace("#?(/\d*)$/g",temp);
        $("#cont").empty();
        $("#bottomDir ul li").detach();//hide的事件必须保留
        now_type = temp;
        autoload(now_type,0);
    }
}
function changePart () {
    //处理修改板块时候发生的事情
    //如果是IE的话，就不管了，直接跳转吧，为了后退的功能不失效，算是优雅降级吧
    document.cookie = "c";
    $("#dirUl").delegate(".part","click",function(event){
        back = false ;
        $("#seaMore").removeAttr("id").attr("id","np");//seamore是通过将np的id修改成的，不搜索的时候，改回来
        $("#sea").val("");//之所以清空，是因为如果之后点击的时候 ，会因为last 和keyword相同发生bug，所以清除
        //chrome中的结果是首先发生delegate，之后是hashchange
        //其实和点击一样，在后退的时候，也许要发生点击的事情，因此将后面的代码单独成立为函数，
        if((navigator.appName == "Netscape")&&(document.cookie.indexOf("c")!=-1)){
            //从IE的例子来看，如果不支持cookie的话，就会造成首页内容错误的bug，要避免
            chaCon(this);
            np.text("下一页");
            event.preventDefault();//我想，如果这里阻止冒泡的话，估计就不会侦测到hashchange了吧
        }
    });
    /********作用高亮当前板块***********/
    var reg = /(\d+)$/;
    if(now_type == undefined || now_type == "")now_type =0;
    $("#dirUl a").each(function  () {
        if(reg.exec(this.href) == now_type){
            //$(this).find("span").addClass("tran");
            $(this).removeClass("dirmenu").addClass("liC");
            return false;
        }
    });
    /**************/
}
$(document).ready(function(){
    mouse();
    hisLen = history.length;
    window.onhashchange = urlChange;
    passRight = 0;
    getCon = getTotal = null;
    var  partId = 1;//partId标示浏览板块的页数
    seaFlag = 0;//开始必须初始化为0，就是不在申请，也不在搜索状态，搜索状态必然在getsea时候检查
    tse();//显隐控制
    init();//登陆的初始化
    search();//搜索时候的函数
    /**************处理关于当前板块的东西************/
    var temp = window.location.href.split("#");//url的情况比较复杂，有正常的不加#的IE系列，#和加数字+关键字的搜索系列
    var reg = /^\d+$/;
    if((temp.length == 2)&&(temp[1]!="")){
        temp = temp[1];
        if(reg.exec(temp)){
            if(temp>99)temp=(temp/100)-1;
            now_type = temp;
            autoload(now_type);
        }else{
            seaFlag = 1;
            getSea(temp);
        }
    }else{
        reg = /\d+$/;
        temp = reg.exec(window.location.href);
        if(temp){
            now_type = temp[0]  ;
        }else {
            temp = $.cookie("uri");
            if(temp)now_type = temp;
            else now_type = 0;
        }
        autoload(now_type);
    }
    /************当前板块的uri处理结束************/
    changePart();
    mess();
    isPc = function Pc () {
        var p = navigator.platform;
        if(p.indexOf("Win"))return 1;
        if(p.indexOf("X11"))return 1;
        if(p.indexOf("Mac"))return 1;
        if(p.indexOf("Linux"))return 1;
        return 0;
    }();
    /***********之前的dir，下面就是对第二级的菜单进行控制的函数***********/
    showInfo();
    $("#dirUl").delegate(".spg","click",function(){
        var name = $(this).attr("name");
        var temp = window.location.href.split("#");
        //dir.css("top","0px");
        temp = temp[0];
        back = false;
        location.href = temp+"#"+decodeURI(name);
        getSea(name);
        event.preventDefault();
    })
    /******************************/
});
function mess () {
    var temp = "<form class = 'block msgA' action = "+site_url+"/message/add method = 'post' accept-charset = 'utf-8'><input type = 'text' name = 'title' class = 'msgt' placeholder = '标题'/><input type = 'button' name = 'cc' value = '取消'/>";
    var left = "<input type = 'submit' name = 'sub' value = '发送'/><textarea name = 'cont' placeholder = '内容...'></textarea></form>";
    var reg = /\d+\/?/,name,id,msga,flag;
    $("#cont").delegate(".mess","click",function  (event) {
        if(msga){
            flag = msga;
            flag.fadeOut();
        }
        name = this.name;
        id = reg.exec(this.href);
        if(id)id = id[0];
        var fat = this.parentNode.parentNode;
        msga = $(fat).siblings(".msgA");
        if(msga.length){
            msga.fadeIn();
        }else{
            $(fat).before(temp+"<input type = 'text' name = 'geter' value = "+name+"("+id+")"+">"+left) ;
            msga = $(fat).siblings(".msgA");
        }
        event.preventDefault();
    }).delegate("input","click",function  (event) {
        var tp = event.target.type;
        if(tp === "button"){
            flag = msga;
            flag.fadeOut();
            msga = null;
        }else if(tp === "submit"){
            var tit = $.trim($(this).siblings("input[name = 'title']").val());
            var geter = $.trim($(this).siblings("input[name = 'geter']").val());
            var text = $($(this).siblings("textarea")).val();
            return;
            if(tit.length == 0){
                $.alet("标题是要有的哦");
                return false;
            }
            var fater = this.parentNode;
            var url = fater.action+"/1";
            $.ajax({
                url:url,dataType:"json",type:"POST",timeout:2000,
                data:{"geter":geter,"cont":text,"title":tit},
                success:function  (data) {
                    (data == "1")?$.alet("发送成功"):$.alet(data);
                }
            })
            $(fater).css("display","none");//发送完毕隐藏
        }
        event.preventDefault();
    })
}
function checkUserName () {
    //通过ajax检验用户的名称，获得对应的密码
    $("#ent input[name='userName']").blur(
        function () {
        var name=$.trim($(this).val());
        if((name == "")||(name =="用户名")||(name == undefined)){
            return;
        }
        $.ajax({
            url:site_url+"/reg/get_user_name",type:"POST",
            data:{"userName":name},
            success:function  (data) {
                user_id=data.getElementsByTagName('id');//这里曾经出现过错误，看来错误处理其实也需要呢,好像是找不到user——id
                user_id=$(user_id[0]).text();
                if(user_id!="0"){
                    user_name = name;
                    $("#atten").html("<b class ='safe'>用户名正确</b>");
                    var pass = $("#passwd").val();
                    ((pass != undefined)&&(pass!="密码") &&(pass !=""))?checkPasswd(user_id,pass):checkUserPasswd();
                }
                else {
                    $("#atten").html("<b class='danger'>用户名错误</b>");
                }
            },
            error: function  () {
                $("#atten").html("<b class = 'danger'>失败了，请检查网络 </b>")
            }
        });
    }
    );
}
function checkPasswd (userId,pass) {
    $.ajax({
        url:site_url+"/reg/getPass/"+userId+"/"+encodeURI(pass),dataType:"json",
        success:function(data){
            if(data == '1'){
                $("#atten").html("<b class = 'safe'>密码正确</b>");
                passRight = 1;//需要监听enter事件
            }
            else {
                $("#atten").html("<b class = 'danger'>密码错误</b>");
                passRight = 0;
            }
        },
        error:function  () {
            passRight = 0;
        }
    });
}
function checkUserPasswd () {
    //只有在获得与user_name相对应的密码的时候才可以帮绑定事件
    $("#ent input[name='passwd']").blur(function(){
        var sec=$(this).val();
        if((sec == "")||(sec =="密码"))return;
        checkPasswd(user_id,sec);
    });
}
function ALogin (user_name,user_id,passwd) {
    //对登陆验证正确之后，进行各种处理，比如，隐藏登陆按钮，更新cookie,首先生成服务端的session，成功就生成cookie
    //生成注销的按钮还有待完成
    //第二次通信，在服务端生成真正的session
    $.ajax({
        url:$("#ent")[0].action+"/1",dataType:"json",type:"POST",timeout:2000,data:{"userId":user_id,"passwd":passwd},
        success:function(data){//返回数组，方便将来扩展
            if(data["flag"]){
                cre_zhuxiao(data["photo"],user_name,data["mailNum"],data["comNum"]);
                $("#atten").hide();
                $.cookie("user_name",user_name,{expires:7});//cookie用在登陆地方了
                $.cookie("user_id",user_id,{expires:7});
            }
            else {
                $("#atten").html("<b class = 'danger'>登陆失败,用户名活密码错误</b>");
            }
        },
        error:function  (xml) {
            $("#atten").html("<b class = 'danger'>登陆失败</b>");
        }
    });
}
function cre_zhuxiao (photo,name,mail,com) {
    //登陆之后的按钮处理，注销的事件绑定//发现photo太占地方了，目前取消
    $("#ent").detach();
    $("#denter").empty();
    var temp="邮件";
    if(mail>0) temp+= "<sup>"+mail+"</sup>";
    if(com>0) comChar="<sup>新"+com+"</sup>";
    else comChar = "";
    $("#denter").append("<a href = "+site_url+"/space/index/"+user_id+" ><img class = 'block' src = "+base_url+"upload/"+photo+" /></a>");
    $("#denter").append("<p><a href = "+site_url+"/space/index/"+user_id+" >空间"+comChar+"</a><a   href = "+site_url+"/write/index"+">新品</a><a id = 'zhu' href = "+site_url+"/destory/zhuxiao"+">注销</a><a  target = '_blank' href = "+site_url+"/message/index"+">"+temp+"</a></p>");
    $("#zhu").click(function  (e) {//为注销添加事件，注销成功则生成登陆按钮
        $.ajax({
            url:site_url+"/destory/zhuxiao",
            success:function  (data) {
                if (data == 1){
                    window.location.reload();//刷新的按钮
                }
            }
        });
        return false;
    });
}

function getInfo (type,partId) {
    np.text("加载中..");
    //var url = site_url+"/mainpage/infoDel/"+key;
    var url = site_url+"/mainpage/infoDel/"+type+"/"+partId+"/1"
    //var url = site_url+"/sea/";
    $.ajax({
        url:url,dataType:"json",timeout:2000,
        success:function  (data,textStatus) {
            if(textStatus == "success"){
                seaFlag = 0;
                if (data.length == 0){
                    np.text("没有了..");
                    return false;
                }
                if(type != now_type)return false;
                formPage(data,partId);//生成页面dom
            }
            np.text("下一页");
        },
        error: function  (xml) {
            np.text("下一页");
            seaFlag = 0;
        }
    })
}
function autoload(id,page) {
    //这里是进行自动加载的，根据用户的鼠标而改变，id表示当前浏览的版块，
    //之所以出现bug的原因，是因为没有清空之前板块的请求
    var timer = 0,height,stp=0,pageNum = 30,doc = document;
    var reg = /^\d+$/;
    if(!reg.exec(id)){
        return;//id不是数字的情况下，就返回无视
    }
    reg = /\d+$/;
    var last = $("#dirUl").find(".liC");
    $(last).removeClass("liC");
    (page == undefined)?(stp = 1):(stp = page);//从ready中调用，则是从1，其他的时候则是为0
    $("#np").click(function  () {
        //np nextpage，和滚动有差不多作用，只是一个是自动，一个是被动
        //首先添加申请中符号,有待改进符号问题,然后判断是否已经申请了
        if(seaFlag === 0){//这里是普通的加载请求
            np.text("加载中..");
            seaFlag = 1; //屏蔽之后的请求
            getInfo(id,++stp);//开始申请数据，
        }
    });
    if(tot[id] == undefined){
        $.ajax({
            url:site_url+"/mainpage/getTotal/"+id,type:"json",
            success:function  (data,textStatus) {
                if ((textStatus=="success")&&(id == now_type)) {
                    tot[id] = data;
                }
            }
        });
    }
    //在搜索的时候，没有必要发起下面的函数
    if(!seaFlag)
        autoAppend();//控制时序，避免页数颠倒
    function autoAppend () {
        $.ajax({
            url:site_url+"/home/infoDel/"+id+"/"+(++stp)+"/1",dataType:"json",
            complete:function  () {//无论之前的事件结果如何，这个，都必须添加这个事件
                back = true;
                seaFlag = 0;
            },
            success:function  (data,textStatus) {
                console.log(data);
                if(id!=now_type)return false;
                if(textStatus == "success"){
                    if (data.length == 0) return false;
                    if(formPage(data,stp)){//生成页面dom;
                        if(doc.height <=$(window).height()&& (stp<5)){
                            //如果页面高度没有屏幕高，再申请
                            autoAppend();
                            seaFlag = 1;
                        }
                    }
                }
            }
        });
        var block = 0;
        $(window).scroll(function  () {
            if((timer === 0) && (seaFlag === 0)){//!timer貌似有漏洞,每次只允许一个申请
                setTimeout(function  () {//一种情况下会引起bug，就是用户的两次点击在0.3s的情况，不处理
                    height = $(window).scrollTop()+$(window).height();
                    if((height+810)> $(doc).height()){//高度还有一部分的时候，开始申请数据
                        if(((pageNum*stp) > tot[id])&&(tot[id] != undefined)){
                            //因为需要是异步加在，所以或许已经change_part这边还是没有修改过来变量，执行的，依旧是之前的id
                            if(id == now_type){
                                np.text("没有了");
                                seaFlag = 1;//因为没有了，就拒绝所有的请求
                            }
                            return  false;
                        }else if(seaFlag == 0){
                            seaFlag = 1;//禁止成功之前的请求
                            getInfo(id,++stp);
                        }
                    }
                    timer = 0;
                },300);
            }
            if(!block){
                block = 1;
                setTimeout(function  () {
                    block = 0;
                    adDir();
                },850);
            }
        });
    }
}
function  init(){
    $("#ent").submit(function(){
        //通过密码验证才可以登陆
        if(passRight == 0){
            $("#atten").html("<b class = 'danger'>请正确输入用户名密码</b>");
            return false;
        }
        var name = $.trim($("#ent input[name = 'userName']").val());
        var pass = $.trim($("#ent input[name = 'passwd']").val());
        ALogin(name,user_id,pass);//算是直接登陆了，只是再服务端还有判断
        return false;
    });
    if((user_id !="")){
        cre_zhuxiao(userPhoto,user_name,mail,com);//既然已经存在了，就没有必要再次登陆了吧
    }
    else {//通过cookie 登陆
        var userId = $.cookie("user_id");
        var userName = $.cookie("user_name");
        if((userId != null)&&(userId != undefined)){
            $("#userName").val(userName);//因为担心和之前绑定的冲突，所以我觉得还是在username  focus的时候，就取消掉这个密码检测
            $("#passwd").blur(function  () {
                var password = $.trim($(this).val());
                user_id = userId;
                if(password.length){
                    checkPasswd(userId,password);
                }
            });
            $("#userName").focus(function  () {$('#passwd').unbind('blur')});//unsername 在试图修改的时候，取消掉密码检测
        }
        //这里设置成 ^_^没有登陆，cookie补全，获得密码后和id一起发送登陆
    }
};
function formPage (data,partId,search) {
    //在search和getInfo中都可以用到的东西，给一个data的函数，形成页，添加到页面中
    var page=document.createElement("div")  ,li;
    $(page).addClass("page");
    for (var i = 0,len = data.length; i < len; i++) {
        if(search === undefined)
            li = ulCreateLi(data[i]);
        else li = ulCreateLi(data[i],search);
        $(page).append(li);
    }
    var p = document.createElement("p");
    $(p).addClass("pageDir");
    $(p).html("第<a name = "+partId+">"+partId+"</a>页");
    $("#cont").append(page).append(p);
    $("#bottomDir ul").append("<a href = #"+(partId-1)+"><li class = 'block botDirli'>"+partId+"</li></a>");
}
function showInfo () {
    //控制用户信息悬浮的函数I;
    var noOpen = 0,last,inArea = 0;//last 为上个显示的内容在结束的时候，之后为本次显示的二级目录
    //noopen = 0 为关闭状态，1则是打开状态
    $("#dirUl").delegate(".diri","click",function(){
        if((inArea = 0)||(noOpen == 0))
            show(this);
        else close();
    }).delegate(".diri","mouseenter",function () {
        show(this);
    }).delegate(".diri","mouseleave",function(){
        close();
        inArea = 0;
    })
    function close(){
        setTimeout(function() {
            if(inArea == 0){
                $(last).css("display","none");
                noOpen = 0;
            }
        }, 100);
    }
    function show(node){
        inArea = 1;
        if(noOpen == 0){
            noOpen = 1;
            $(".dp").css("height",$(document).height());
            var last = $(node).find(".dp");
            $(last).css("display","block");
            chg(node);
        }else{
            chg(node);
        }
    }
    function chg(node){
        $(last).css("display","none");
        last = $(node).find(".dp");
        $(last).css("display","block");
    }
}
function ulCreateLi(data,search) {
    //这个文件创建一个li，并将其中的节点赋值,psea有待完成,photo还位使用
    //肮脏的代码，各种拼字符串
    var doc = document;
    console.log(data);
    var li=doc.createElement("li");
    $(li).addClass("block");
    var num;
    if( parseInt(data["comment_num"]) > 0){
        console.log(data["comment_num"]);
        console.log(data["judgescore"]);
        num = data["judgescore"] / data["comment_num"];
        num = "<span class = 'ut'>评分"+num+"</span>";
    }else num = "";
    var addr = "";
    if(data["addr"]){
        addr = "<span class = 'ut'>"+data["addr"]+"</span>";
    }
    $(li).append("<a class = 'aImg' href = '"+site_url+"/showart/index/"+data["art_id"]+"' ><img  class = 'imgLi block' src = '"+base_url+"thumb/"+data["img"]+"' alt = '商品压缩图' title = "+data["user"]["user_name"]+"/></a>");
    var dom = "<div class = 'lid'><a class = 'detail' href = '"+site_url+"/item/index/"+data["art_id"]+"'>"+data["title"]+"</a><p class = 'user tt'><span class = 'time'>￥:"+data["price"]+"</span>浏览:"+data["visitor_num"]+"/评论:"+data["comment_num"]+num+"</p><p class = 'user tt'><a href = "+site_url+"/space/index/"+data["author_id"]+"><span class = 'sl'>店家:"+data["user"]["user_name"]+"</span>"+addr+"</a></p></div>";
    $(li).append(dom);
    return li;
}
function search () {
    $("#sea").focus(function  () {
        $("#seaatten").text("");
    }).blur(function  () {
        if(($.trim($("#sea").val()))=="")//只有去掉空格才可以，不然会出bug
            $("#seaatten").html("搜索<span class = 'seatip'>请输入关键字</span>")
    })
    //所有关于search操作的入口函数
    $("#seaform").submit(function  () {
        var keyword = $.trim($("#sea").val());
        if(keyword == last)return false;//担心用户的连击造成重复申请数据
        if(keyword.length == 0){
            $.alet("请输入关键字");
            return false;
        }
        back = false;
        dir.css("top","0px");//对应侧边栏滑动的情况，这种时候，清空top
        var temp = window.location.href.split("#");
        temp = temp[0];
        window.location.href = temp+"#"+encodeURI(keyword);
        getSea(keyword);
        return false;
    })
}
var last;
function getSea (keyword) {
    //在search触发之后，对key进行审查之后的开始搜索
    last = keyword;
    seaFlag = 1;
    now_type = -1;
    var enkey = encodeURI(keyword);
    console.log(site_url+"/sea/index?key="+enkey);
    //$.getJSON(site_url+"/search/index?key="+enkey,function  (data,status) {
    $.ajax({
        url:site_url+"/sea/index?key="+enkey,dataType:"json",timeout:2000,
        success:function(data,textStatus){
            back = true;
            console.log(data);
            if(textStatus == "success"){
                if(data == "0"){
                    $.alet("没有对应信息");
                }else{
                    $("#cont").empty();
                    $("#bottomDir ul li").detach();
                    var last = $("#dirUl").find(".liC");
                    $(last).removeClass("liC");
                    formPage(data,1,1);
                    $("#np").removeAttr("id").attr("id","seaMore");
                    //$("#content").append("<p style = 'text-align:center'><button id = 'seaMore'>更多....</button></p>")
                    getNext();
                }
            }
        },
        error:function  () {
            back = true;
        }
    });
    function getNext () {//获得搜索下一页的函数
        var page = 1,seaing = 0;
        var more = $("#seaMore");
        more.click(function  () {
            if(seaing == 0){
                seaing = 1;
                more.text("加载中..");
                $.getJSON(site_url+"/search/index/"+(page)+"?key="+enkey,function  (data,status,xhr) {
                    if(status == "success"){
                        if(!data){
                            $.alet("抱歉,没有对应的信息了");
                            more.text("没有了");
                        }else{
                            seaing = 0;
                            formPage(data,++page,1);
                            (data.length<16)?(more.text("没有了")):(more.text("下一页"));
                        }
                    }else{
                        alert("tesitng error");
                        seaing = 0;
                    }
                });
            }
        });
    }
}
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
function adDir () {
    return;
    //这里出现bug
    /*
       var top = dir.css("top"),sctop = $(window).scrollTop(),reg = /^\d+/;
       reg  = reg.exec(top);
       top = reg[0];
       console.log(top);
       console.log(sctop);
       var dis = Math.abs(top-sctop);
       if( dis > 370){
       dir.animate({"top":sctop+"px"},600);
       }
       */
}
$(function(){
  var toggles = $('.toggle a'),
      codes = $('.code');
/*
  toggles.bind("click", function(event){
    console.log("dsfasd");
    event.preventDefault();
    var $this = $(this);

    if (!$this.hasClass("active")) {
      toggles.removeClass("active");
      $this.addClass("active");
      codes.hide().filter(this.hash).show();
    }
  });
  */
  toggles.first().click();
});
