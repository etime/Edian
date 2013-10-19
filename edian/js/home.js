/*
author:         unasm
email:          douunasm@gmail.com
last_modefied:  2013/04/05 04:33:37 PM
//如果在这个时候，引入面向对象的一些东西，或许更好
*/

var seaFlag,passRight,back,np = $("#np"),dir = $("#dir"),dirUl = $("#dirUl");
var getData;
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
function autoload() {
    var height,doc = document,$this = this;
    //stp startpage 开始的页码，也是当前页码的编号,控制时序，避免页数颠倒
    var reg = /^\d+$/;
        //正在搜索的关键字，如果和当前的字不同，就要废弃掉申请来的结果
    $this.init = function (val) {
        $this.seaIngkey = val;
        $this.stp = 0;
        $this.append();
    }
    $this.append = function autoAppend () {
        //担心不能充满屏幕而设置的
        var url = site_url+"/sea/index?key="+$this.seaIngkey+"&&pg="+($this.stp);
        $.ajax({
            url:url,dataType:"json",
            beforeSend:function(XHR){
                np.text("加载中");
                seaFlag = 1;
                console.log($this.seaIngkey);
                console.log("上面是seaingkey");
            },
            complete:function  () {//无论之前的事件结果如何，这个，都必须添加这个事件
                back = true;
                seaFlag = 0;
            },
            success:function  (data,textStatus) {
                if(textStatus == "success"){
                    if(data["flag"]){
                        //这里应该是很多的列,formnavpg构成dom页面和事件的添加
                        np.css("display","none")
                        formNavPg(data);//
                         // 来到这里，是因为需要进行，就是不再需要进行申请数据了，
                         // 所以没有必要绑定scroll事件，但是需要添加的是新的添加内容
                    }else{
                         // 这里进行的是搜索和底层的显示，东西要多哦,保留之前的设计,因为添加种类单一，所以不够的情况下自动添加,而且分页
                        formPage(data,$this.stp++);//构成页面的同时，选择将页码自加
                        //生成页面dom;
                        if(doc.height <=$(window).height()&& ($this.stp<5)){
                            //如果页面高度没有屏幕高，再申请
                            autoAppend();
                            seaFlag = 1;
                        }
                        if (data.length == 0){
                            //在数据比较少的时候，下面关于np的处理还是比较合理的
                            np.css("display","inline-block").text("没有了..");
                            return false;
                        }
                        np.css("display","inline-block").text("下一页");
                    }
                }
            },
            error:function(event,XMLHttpRequest){
                console.log(event);
                console.log(XMLHttpRequest);
                //为什么会将正常的数据变成错误的处理呢？需要查看错误原因
                np.text("出错..");
            }
        });
    }
    /**
     *  对搜索，底层，需要滚动添加内容的时候，需要进行添加的事件
     *  在系统初始化的时候，就绑定好这个函数，反正早晚也是需要的，绑定好，就不再添加改变了
     *  @timer 对申请的控制
     */
    var timer = 0;
    window.onscroll = function  () {
        if((timer === 0) && (seaFlag === 0)){
            timer = 1;
            //!timer貌似有漏洞,每次只允许一个申请,貌似是因为多线程引起的，因为多次绑定了scroll事件
            setTimeout(function  () {//一种情况下会引起bug，就是用户的两次点击在0.3s的情况，不处理
                height = $(window).scrollTop()+$(window).height();
                if((height+810)> $(doc).height()){//高度还有一部分的时候，开始申请数据
                    if(seaFlag == 0){
                        console.log("开始申请");
                        seaFlag = 1;//禁止成功之前的请求
                        getSea($this.seaIngkey,$this.stp++);
                    }
                }
                timer = 0;
            },300);
        }
    }
    $("#np").click(function  () {
        //np nextpage，和滚动有差不多作用，只是一个是自动，一个是被动
        //首先添加申请中符号,有待改进符号问题,然后判断是否已经申请了
        if(seaFlag === 0){//这里是普通的加载请求
            np.text("加载中..");
            seaFlag = 1; //屏蔽之后的请求
            getSea($this.seaIngkey,stp++);//开始申请数据，
        }
    });
}
function highlight(key) {
    //侧边栏的高光
    dirUl.delegate(".part","click",function(){
        dirUl.find(".liC").removeClass("liC");
        $(this).addClass("liC");
    })
    console.log(getData.seaIngkey);
    var parts = $(".part"),spg;
    var flag = 0;
    for (var i = 0, l = parts.length; i < l; i ++) {
        spg = $(parts[i]).find(".spg");
        for (var j = 0, lj = spg.length; j < lj; j ++) {
            temp =  $(spg[j]).attr("name");
            if(temp == getData.seaIngkey){
                flag = 1;
                $(parts[i]).addClass("liC");
            }
        }
        if(flag)break;
    }
}
function urlChange () {
    //控制url的跳转，更改，就是为了不使用iframe的情况下进行后退不失效
    //history.length的方式不可靠，最长只有50，极限测试下，会挂的
    //back的成立条件是首先会冒泡的之前的delegate 的dir上，然后才会到hashchange上
    if(back){
        var href = window.location.href.split("#");
        if(href.length > 1){
            href = href[1];
        }else href = "0";
        chaCon(href);
    }
    return false;
}
function chaCon(name){
    console.log(name);
    //name，搜索的关键词
    //修改内容的时候用
    var href = window.location.href.split("#");
    href = href[0];
    window.location.href = href+"#"+name;
    if(name == '0'){
        //首页的话，就展开幻灯片
        $("#flexslider").slideDown(800);
    }else {
        $("#flexslider").slideUp(800);
    }
    $("#cont").empty();
    $("#bottomDir ul li").detach();//hide的事件必须保留
    getData.init(name);
}
function changePart () {
    //处理修改板块时候发生的事情
    //如果是IE的话，就不管了，直接跳转吧，为了后退的功能不失效，算是优雅降级吧
    dirUl.delegate(".spg","click",function(event){
        back = false ;
        //chrome中的结果是首先发生delegate，之后是hashchange
        //其实和点击一样，在后退的时候，也许要发生点击的事情，因此将后面的代码单独成立为函数，
        seaFlag = 0;//后退的判断完毕之后，进行后退之前的处理，如颜色，url的更改
        var name = $(this).attr("name");
        if(getData.seaIngkey != name){
            chaCon(name);
        }
        event.preventDefault();//我想，如果这里阻止冒泡的话，估计就不会侦测到hashchange了吧
    });
    /********作用高亮当前板块***********/
}
$(document).ready(function(){
    window.onhashchange = urlChange;
    getData = new  autoload();
    passRight = 0;
    var  partId = 1;//partId标示浏览板块的页数
    seaFlag = 0;//开始必须初始化为0，就是不在申请，也不在搜索状态，搜索状态必然在getsea时候检查
    tse();//显隐控制
    init();//登陆的初始化
    search();//搜索时候的函数
    /**************处理关于当前板块的东西************/
    var href = window.location.href.split("#");
    if(href.length>1)
        href = href[1];
    else href = 0;
    chaCon(href);//在这里高亮侧边栏，调用autoload,刷新和开始的时候的加载也是chacon不是吗？
    highlight(href);
    /************当前板块的uri处理结束************/
    changePart();//切换板块的时候的事件处理
    /***********之前的dir，下面就是对第二级的菜单进行控制的函数***********/
    showInfo();
});
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
                if (data.length == 0){
                    np.text("没有了..");
                    seaFlag = 1;
                    return false;
                }
                seaFlag = 0;
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
    })
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
/**
 * 形成有导航的栏目页面
 * 2013-10-08 08:49:02 unasm
 */
function formNavPg(data) {
    (function (pgData) {
        //构成page 需要的data
        var li,cont,ul;
        //page的作用，就是标记那些是内容
        var contDiv = $("#cont");
        for(var arr in pgData){
            if(arr != "flag"){
                var page = document.createElement("div");
                console.log(data[arr]);
                cont = data[arr];
                ul = document.createElement("ul");//对ul进行分行
                $(ul).addClass("clearfix");
                for (var i = 0, l = cont.length; i < l; i ++) {
                    li = ulCreateLi(cont[i]);
                    $(ul).append(li);
                }
                $(page).append(ul);//每个page下面很多ul，构成基础
                $(page).append("<p class = 'pageDir'><span class = 'smk'>"+arr+"</span><a href = '"+site_url+"/sea/index?key="+arr+"&pg=1&app=1"+"' class = 'navMre' name = '1'>更多</a></p>");
                //name表示page，因为每个栏目的页码都不同，所以尽量在页码
                $(page).addClass("ulLine");
                contDiv.append(page);
            }
        }
    })(data);
    /**
     * 开始准备时间的调用
     * 2013-10-08 08:46:42 unasm
     */
    function regTest(){
        var len = arguments[1] - 0 +1;
        return "pg="+len;
    }
    var flag = 0,url;
    //flag为0的状态为没有请求状态，为1时候表示有，或者是还没有超时，当超过一定时间之后，会允许重新请求，那之前就被覆盖。
    $("#cont").delegate(".navMre","click",function(event){
        var evtNode = this;
        if(flag){
            return false;
        }
        flag = 1;
        url = $(evtNode).attr("href");
        //$(evtNode).attr("href").replace("/pg=(\d)/","$1"+1);
        //var flag = 2;
        console.log(url);
        var node = parfind(evtNode);
        //既然url没有变，node也不会更改
        (function(dataUrl){
            //通过闭包决定传入的参数
            $.ajax({
                url: dataUrl,
                dataType: 'json',
                complete: function (jqXHR, textStatus) {
                    flag = 0;
                    console.log("flag = 0");
                },
                success: function (data, textStatus, jqXHR) {
                    if((dataUrl  === url) && textStatus == "success"){
                        for (var value in data) {
                            //其实标准的来说，只有一个吧
                            appLine(data[value],node);
                        }
                        if(value)
                            $(evtNode).attr("href",url.replace(/pg=(\d+)/g,regTest));
                        else $.alet("浏览到最后了");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("错误");//要不要将错误传回，好进行检测判断,url和textstatus
                }
            })
        })(url);
        setTimeout(function(){
            flag = 0;
        },3000);
        return false;
    });
    // 向每一line添加数据
    function appLine(data,node) {
        var frag = document.createDocumentFragment();
        //其实如果早点知道添加碎片的话，就会好很多，至少不会多一些不应该的结构
        for(var i = 0,l = data.length;i < l;i++){
            //将urlCreateLi返回的li添加到碎片中
            frag.appendChild(ulCreateLi(data[i]));
        }
        $(node).append(frag);
    }
    function parfind(node){
        while(node && $(node).attr("tagName")!="HTML"){
            if($(node).attr("class") != "ulLine"){
                node = node.parentNode;
            }else{
                node = $(node).find("ul");
                return node[0];
            }
        }
        return false;
    }
}
function formPage (data,partId) {
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
    $(p).html("第<a name = "+partId+">"+(parseInt(partId)+1)+"</a>页");
    $("#cont").append(page).append(p);
    $("#bottomDir ul").append("<a href = #"+(partId-1)+"><li class = 'block botDirli'>"+partId+"</li></a>");
}
function showInfo () {
    //控制用户信息悬浮的函数I;
    var noOpen = 0,last,inArea = 0;//last 为上个显示的内容在结束的时候，之后为本次显示的二级目录
    //noopen = 0 为关闭状态，1则是打开状态
    dirUl.delegate(".diri","click",function(){
        if(noOpen == 0)
            show(this);
        else close();
    }).mouseleave(function(){
        ulCont.css("z-index",0);
    }).mouseenter(function(){
        ulCont.css("z-index",-1);
    })
    /*
       .delegate(".diri","mouseenter",function () {
       show(this);
       }).delegate(".diri","mouseleave",function(){
       close();
       inArea = 0;
       })
       */
    var ulCont = $("#ulCont");
    function close(){
        setTimeout(function() {
            if(inArea == 0){
                console.log("uping");
                $(last).css("display","none");
                ulCont.css("z-index",0);
                noOpen = 0;
            }
        }, 100);
    }
    function show(node){
        inArea = 1;
        if(noOpen == 0){
            noOpen = 1;
            console.log("downing");
            ulCont.css("z-index",-1);
            //$(".dp").css("height",$(document).height());
            last = $(node).find(".dp");
            $(last).css("display","block");
        }
    }
}
function ulCreateLi(data,search) {
    //这个文件创建一个li，并将其中的节点赋值,psea有待完成,photo还位使用
    //肮脏的代码，各种拼字符串
    var doc = document;
    var li=doc.createElement("li");
    $(li).addClass("block");
    var num  = "",addr = "",link;
    if((parseInt(data["comment_num"]) > 0) && (data["judgescore"])){
        num = data["judgescore"] / data["comment_num"];
        num = "<span class = 'ut'>评分"+num+"</span>";
    }
    if(data["addr"]){
        addr = "<span class = 'ut'>"+data["addr"]+"</span>";
    }
    if(getData.seaIngkey == "1"){
        //如果当前在搜二手专区，就showart，不然就是item
        link = site_url+"/showart/index/"+data["art_id"];
    }else{
        link = site_url+"/item/index/"+data["art_id"];
    }
    $(li).append("<a class = 'aImg' href = '"+link+"' ><img  class = 'imgLi block' src = '"+base_url+"thumb/"+data["img"]+"' alt = '商品压缩图' title = "+data["user"]["user_name"]+"/></a>");
    var dom = "<div class = 'lid'><a class = 'detail' href = '"+link+"'>"+data["title"]+"</a><p class = 'user tt'><span class = 'time'>￥:"+data["price"]+"</span>浏览:"+data["visitor_num"]+"/评论:"+data["comment_num"]+num+"</p><p class = 'user tt'><a href = "+site_url+"/space/index/"+data["author_id"]+"><span class = 'sl'>店家:"+data["user"]["user_name"]+"</span>"+addr+"</a></p></div>";
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
        var temp = window.location.href.split("#");
        window.location.href = temp[0]+"#"+encodeURI(keyword);
        getData.init(keyword);
        return false;
    })
}
function getSea (keyword,page) {
    //在search触发之后，对key进行审查之后的开始搜索
    var enkey = encodeURI(keyword);
    if(page == undefined)page =  0;
    //console.log(site_url+"/sea/index?key="+enkey+"&&pg="+page);
    var url = site_url+"/sea/index?key="+enkey+"&&pg="+page;
    $.ajax({
        url:url,dataType:"json",timeout:2000,
        beforeSend:function(XHR){
            np.text("加载中..");
        },
        complete:function(){
            np.text("下一页");
        },
        success:function(data,textStatus){
            back = true;
            if(textStatus == "success"){
                if((data.length == 0)|| (!data)){
                    np.text("没有了..");
                    seaFlag = 1;//没有了，就要停止
                }else if(keyword == getData.seaIngkey){
                    seaFlag = 0;
                    formPage(data,page);//将申请的数据直接用来添加，没有其他的功能
                }
            }
        },
        error:function  () {
            seaFlag = 0;
            back = true;
            np.text("错误.");
        }
    });
}
