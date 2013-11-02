/*
author:         unasm
email:          douunasm@gmail.com
last_modefied:  2013/04/05 04:33:37 PM
//如果在这个时候，引入面向对象的一些东西，或许更好
*/

var passRight,np = $("#np"),dir = $("#dir"),dirUl = $("#dirUl");
var getData,chaPart;
//getdata autoload的实例化的对象,chaPart changePart的实例对象
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
/**
 *  输入对应的关键字得到数据，控制添加数据的入口
 *
 * 添加数据，控制数据的
 *
 * @param bool seaflag 搜索置位，seaFlag 中断其他的搜索，1为禁止，0为可以申请
 * @param int stp startpage 开始的页码，也是当前页码的编号,控制时序，避免页数颠倒
 * @param string seaIngkey 正在搜索的关键字，如果和当前的字不同，就要废弃掉申请来的结果
 */
function autoload() {
    var doc = document,$this = this,reg = /^\d+$/,noScroll,cont = $("#cont");
    /**
     * 上面的是私有属性，doc是为了效率的增加，$this 是为了this的避免替换，noScroll ,避免在不该滚动添加的时候，触发
     * timer 两个效果，一个是onscroll节流，另一个是控制，避免在不该触动的时候触动//暂时废弃
     */
    $this.init = function (val) {
        $this.seaIngkey = val;
        $this.stp = 0;
        noScroll = 1;
        $this.seaFlag = 0;//开始的时候，允许进行搜索
        cont.empty();//在开始申请数据之前，将之前的清空
        $this.append();//初始化之后，申请数据
    }
    $this.append = function autoAppend () {
        //担心不能充满屏幕而设置的
        var url = site_url+"/sea/index?key="+$this.seaIngkey+"&&pg="+($this.stp);
        $.ajax({
            url:url,dataType:"json",
            beforeSend:function(XHR){
                np.text("加载中");
                $this.seaFlag = 1;
            },
            complete:function  () {//无论之前的事件结果如何，这个，都必须添加这个事件
                back = true;
                $this.seaFlag = 0;
            },
            success:function  (data,textStatus) {
                console.log(data);
                if(textStatus == "success" && data){
                    if("flag" in data){
                        //这里应该是很多的列,formnavpg构成dom页面和事件的添加
                        np.css("display","none")
                        formNavPg(data);// 构成dom页面
                         // 来到这里，是因为需要进行，就是不再需要进行申请数据了，
                    }else{
                         // 这里进行的是搜索和底层的显示，东西要多哦,保留之前的设计,因为添加种类单一，所以不够的情况下自动添加,而且分页
                        formPage(data,$this.stp++);//构成页面的同时，选择将页码自加
                        if(doc.height <=$(window).height()&& ($this.stp<5)){
                            //如果页面高度没有屏幕高，再申请
                            autoAppend();
                        }
                        if (data.length == 0){
                            //在数据比较少的时候，下面关于np的处理还是比较合理的
                            np.css("display","inline-block").text("没有了..");
                            return false;
                        }
                        noScroll = 0;//允许scroll事件申请数据，在还有下一页的时候，
                        np.css("display","inline-block").text("下一页");
                    }
                }else{
                    np.css("display","inline-block").text("没有了");
                }
            },
            error:function(event,XMLHttpRequest){
                console.log(url);
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
    window.onscroll = function  () {
        if( ($this.seaFlag === 0) && (noScroll === 0)){
            if( ( $(window).scrollTop() + $(window).height() + 810 ) > $(doc).height()){//高度还有一部分的时候，开始申请数据
                if($this.seaFlag == 0){
                    console.log("开始申请");
                    getSea($this.seaIngkey,$this.stp++);
                }
            }
        }
    }
    np.click(function  () {
        //np nextpage，和滚动有差不多作用，只是一个是自动，一个是被动
        if($this.seaFlag === 0){//这里是普通的加载请求
            np.text("加载中..");
            getSea($this.seaIngkey,$this.stp++);//开始申请数据，
        }
    });
}
/**
 * 亮暗切换的函数，包括侧边栏的高光显示和二级菜单的显示隐藏
 *
 */
function highlight() {
    //切换的时候侧边栏的高光
    dirUl.delegate(".part","click",function(){
        dirUl.find(".liC").removeClass("liC");
        $(this).addClass("liC");
    })
    var parts = $(".part"),spg;
    var flag = 0;
    //第一次的时候的亮暗控制
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
    var lastDiv = false;
    //控制侧边栏的显隐，经过长时间的磨练，自己写这个越来越熟练了
    dirUl.delegate("li","mouseenter",function(){
        if(lastDiv)$(lastDiv).css("display","none");
        lastDiv = $(this).find(".dp");
        if(lastDiv.length > 0){
            lastDiv = lastDiv[0];
            $(lastDiv).css("display","block");
        }else lastDiv = false;
    })
}
/**
 * 修改内容的时候用,或者是刚刚进入页面的时候使用
 * @param string/undefined name，搜索的关键词,如果没有的话，就就地生成才
 */
function chaCon(name){
    var href = window.location.href.split("#");
    if(name == undefined){
        name = href.length > 1 ? href[1] : 0;
    }else{
        window.location.href = href[0]+"#"+name;
    }
    //处理url和搜索关键字的问题
    if(name == '0'){
        //首页的话，就展开幻灯片
        $("#flexslider").slideDown(800);
    }else {
        $("#flexslider").slideUp(800);
    }
    //$("#cont").empty();
    //$("#bottomDir ul li").detach();//hide的事件必须保留
    getData.init(decodeURI(name));
}
/**
 * 处理修改板块时候发生的事情
 *
 *  包括跳转到一个新的页面和返回之前一个页面两种情况，
 * back的成立条件是首先会冒泡的之前的delegate 的dir上，然后才会到hashchange上
 */
function changePart () {
    $this = this;
    $this.back = true ;
    //back 后退，为了添加后退的功能而添加的标志变量
    dirUl.delegate(".spg","click",function(event){
        $this.back = false ;
        //chrome中的结果是首先发生delegate，之后是hashchange
        //其实和点击一样，在后退的时候，也许要发生点击的事情，因此将后面的代码单独成立为函数，
        getData.seaFlag = 0;//后退的判断完毕之后，进行后退之前的处理，如颜色，url的更改
        var name = $(this).attr("name");
        if(getData.seaIngkey != name){
            chaCon(name);
        }
        event.preventDefault();//我想，如果这里阻止冒泡的话，估计就不会侦测到hashchange了吧
    });
    window.onhashchange =  function () {
    //如果是IE的话，就不管了，直接跳转吧，为了后退的功能不失效，算是优雅降级吧
    //history.length的方式不可靠，最长只有50，极限测试下，会挂的
        console.log("backing");
        if($this.back){
            chaCon();
        }else{
            $this.back = true;//如果不是后退的话，将back置位，不然下次难以判定
        }
    }
}
$(document).ready(function(){
    getData = new  autoload();
    passRight = 0;
    tse();//显隐控制
    init();//登陆的初始化
    /**************处理关于当前板块的东西************/
    chaCon();//刷新和开始的时候的加载也是chacon不是吗？
    highlight();
    /************当前板块的uri处理结束************/
    chaPart = new changePart();//切换板块的时候的事件处理
    showInfo();
    search();//搜索时候的函数
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
//貌似已经被遗弃了，永远的
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
                    getData.seaFlag = 1;
                    return false;
                }
                getData.seaFlag = 0;
                if(type != now_type)return false;
                formPage(data,partId);//生成页面dom
            }
            np.text("下一页");
        },
        error: function  (xml) {
            np.text("下一页");
            getData.seaFlag = 0;
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
    function regTest(){
        var len = arguments[1] - 0 +1;
        return "pg="+len;
    }
    var flag = 0,url;
    //flag为0的状态为没有请求状态，为1时候表示有，或者是还没有超时，当超过一定时间之后，会允许重新请求，那之前就被覆盖。
    $("#cont").delegate(".navMre","click",function(event){
        var evtNode = this;
        url = $(evtNode).attr("href");
        var node = parfind(evtNode);
        //既然url没有变，node也不会更改
        if(flag){
            return false;
        }
        flag = 1;
        $.ajax({
            url: url,
            dataType: 'json',
            complete: function (jqXHR, textStatus) {
                flag = 0;
            },
            success: function (data, textStatus, jqXHR) {
                if( ($(evtNode).attr("href") == url ) && ( textStatus == "success")){
                    $(evtNode).attr("href",url.replace(/pg=(\d+)/g,regTest));//将页码加一
                    appLine(data,node);
                    if(!data)
                        $.alet("浏览到最后了");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("错误");//要不要将错误传回，好进行检测判断,url和textstatus
            }
        })
        setTimeout(function(){
            //3s之后重发
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
        li = ulCreateLi(data[i]);
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
function ulCreateLi(data) {
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
    var last = null;
    $("#sea").focus(function  () {
        $("#seaatten").text("");
    }).blur(function  () {
        if(($.trim($("#sea").val()))=="")//只有去掉空格才可以，不然会出bug
            $("#seaatten").html("搜索<span class = 'seatip'>请输入关键字</span>")
    })
    //所有关于search操作的入口函数
    $("#seaform").submit(function  (event) {
        var keyword = $.trim($("#sea").val());
        if(keyword === last)return false;//担心用户的连击造成重复申请数据
        last = keyword;
        if(keyword.length == 0){
            $.alet("请输入关键字");
            return false;
        }
        chaPart.back = false;//虽然在改变url，但是不是后退，禁止onhashchange
        var temp = window.location.href.split("#");
        window.location.href = temp[0]+"#" + keyword;
        getData.init(keyword);
        return false;
    })
}
/**
 *  根据关键字和页码进行搜索
 *
 * 本意是针对搜索来进行的，后来根据架构的调整，几乎需要添加数据的地方都需要这个函数
 *
 * 将getSea独立于任何对象之外，因为调用它的地方可能很多;
 */
function getSea (keyword,page) {
    //在search触发之后，对key进行审查之后的开始搜索
    var enkey = encodeURI(keyword);
    var url = site_url+"/sea/index?key="+enkey+"&&pg="+page;
    console.log(url);
    $.ajax({
        url:url,dataType:"json",timeout:2000,
        beforeSend:function(XHR){
            getData.seaFlag = 1;
            np.text("加载中..");
        },
        success:function(data,textStatus){
            if(textStatus == "success"){
                if((data.length == 0)|| (!data)){
                    np.text("没有了..");
                    getData.seaFlag = 1;//没有了，就要停止
                }else if(keyword == getData.seaIngkey){
                    getData.seaFlag = 0;
                    np.text("下一页");
                    formPage(data,page);//将申请的数据直接用来添加，没有其他的功能
                }
            }
        },
        error:function  () {
            getData.seaFlag = 0;
            np.text("错误.");
        }
    });
}
