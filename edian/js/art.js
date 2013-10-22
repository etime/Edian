var isPc,showUp;
function loginA (name,data) {
    //loginAlready 登陆之后的工作
        user_name = name;
        user_id = data["user_id"];
        var temp="<a href = "+site_url+"/space/index/"+data["user_id"]+" ><img src = "+base_url+"upload/"+data["photo"]+" /></a><p><a href = "+site_url+"/space/index/"+data["user_id"]+" >空间";
        temp+=((data["comNum"] > 0)?("<sup>"+data["comNum"]+"</sup></a>"):("</a>"));
        temp+= "<a target = '_blank' href = "+site_url+"/write/index >新帖</a><a id = 'zhu' href = "+site_url+"/destory/zhuxiao >注销</a><a href = "+site_url+"/message/index >邮箱";
        temp+=(data["mailNum"] > 0)?("<sup>"+data["mailNum"]+"</sup>"):("");
        temp+="</a></p>";
        $("#denter").append(temp);
        $("#zhu").click(function  (e) {//为注销添加事件，注销成功则生成登陆按钮
        $.ajax({
            url:site_url+"/destory/zhuxiao",
            success:function  (data) {
                if (data == 1){
                    user_id = null;
                    $("#denter").empty();
                    $("#change").hide();
                //window.location.reload();//刷新的按钮
                }
            }
        })
        return false;
    });
}
$(document).ready(function(){
    isPc = Pc();
    mouse();
    dir();
    user_id = $.trim(user_id);
    if(user && user_id)loginA(user_name,eval(user));
    var reg = /\d+$/,art_id;
    /*特殊情况呢
     * http://www.edian.cn/index.php/showart/index/88?sea=&sub=
     */
    art_id = reg.exec(window.location.href)[0];
    $("#dirUl a").each(function  () {
        var temp = reg.exec(this.href);
        if(temp){
            if(now_type == temp[0]){
                $(this).find("li").removeClass("dirmenu").addClass("liC");
                //$(this).find("span").addClass("tran");
                return false;
            }
        }
    })
    getCom(art_id);
    tse();                          //控制input text中的显隐
    subCom();                       //下面评论的提交
    com();                            //控制评论区域的显隐
    $("#face").delegate("img","click",function(){
        temp=getName(this.src);
        var content=document.getElementsByName("com")[0];
        content.value=content.value+"[face:"+temp+"]";
    });
    user_id = $.trim(user_id);
    if(user_id.length){                     //注销事件的绑定
        $("#after").show();
        $("#dir input[name = 'zhu']").click(function  () {//为注销添加事件，注销成功则生成登陆按钮
            $.ajax({
                url:site_url+"/destory/zhuxiao",
                success:function  (data) {
                    if (data == 1){
                        //window.location.reload();//刷新的按钮
                        $("#after").hide();
                    }
                }
            });
        });
    }
    $("#msg").click(function  () {
        var userId = reg.exec(this.href);
        if(userId){
            userId = userId[0];
        }else return true;
        $("#cc").click(function  () {//cancel
            msgcc();
        });
        $("#msgt").focus(function  (){              //控制标题的显示隐藏
            $(".plab").hide();
        }).blur(function  () {
            if($.trim($(this).val()).length==0){
                $(".plab").show()   ;
            }
        })
        $("#msgA form").submit(function  () {
            var tit = $.trim($(this).find("input[name = 'title']").val());
            var geter = $.trim($(this).find("input[name = 'geter']").val());
            var cont = document.getElementById("cont");
            cont = $.trim(cont.value);
            if(tit.length == 0){
                $.alet("标题是要有的哦");
                return false;
            }
            var url = this.action+"/1";
            $.ajax({
                url:url,dataType:"json",type:"POST",
                data:{"geter":geter,"cont":cont,"title":tit},
                success:function  (data) {
                    (data == "1")?$.alet("发送成功"):$.alet(data);
                }
            })
            msgcc();//无论成功，或者失败，都要消失
            return false;
        })
        if(user_id.length==0){//先绑定之前对应的时间，然后决定是否显示隐藏
            $.alet("请登陆后发信");
            denglu(showMsg);
            return false;
        }
        showMsg();//将那块区域显示出来
        return false;
    })
});
function msgcc() {
    $("#msgatten").removeClass("high");
    $("#msgA").fadeOut();
}
function tse(){
    var val;//控制页面点击消失提示字的函数
    $(".valTog").focus(function(){
        val = $(this).val();
        $(this).removeAttr("value");
    }).blur(function(){
        if($(this).val()==""){
            $(this).attr("value",val);
        }
    });
}
function showMsg () {
    $("#comcon").animate({//不管是为了纠错什么的也好，这个开启的时候，下面貌似没有必要大开呢
        height:"33px"
    });
    $("#msgatten").addClass("high");
    $("#msgA").fadeIn();
}
function denglu (callback) {
    //关于登陆的控制js
    $("#denglu").fadeIn();
    $("#denglu").submit(function  (event) {
        var name = $.trim($(this).find("input[name = 'userName']").val());
        var passwd = $.trim($(this).find("input[name = 'passwd']").val());
        console.log("testing");
        if(passwd  == "")return false;
        $.ajax({
            url:site_url+"/reg/dc/1",dataType:"json",type:"POST",data:{"userName":name,"passwd":passwd},
            success:function  (data,textStatus) {//登陆成功，返回用户id的方法貌似不错呢，或许可以修改mainpage的一些东西
                //既然显示登录区域，就代表加载了js，不必通过跳转的方式提交了
                if(textStatus == "success"){
                    if(data["user_id"] == 0)
                        $.alet("用户名或密码错误");
                    else{
                        callback();
                        if(!user_id)
                            loginA(name,data);//显示登陆区域
                        $("#denglu").hide();//隐藏登陆块
                        $.alet("登陆成功");
                    }
                }else console.log(data);
            },
            error:function  (xml) {
                console.log(xml);
            }
        })
        event.preventDefault();
    });
}
function subCom() {
    //初始化的函数
    $("#comform").submit(function(){
        var node = document.getElementById("comcon");
        content = $(node).val();
        if(content == "")return false;
        content=content.replace(/\n/g,"<br/>");
        console.log(this.action);
        $.ajax({
            url:this.action,//呵呵，这个要不要换一种方式
            type:"POST",
            data:{"com":content},
            dataType:"json",
            success:function(data,responseText) {
                //返回值，将来修改成为评论的数目，修改页面中的信息,不过，不着急
                if(data == "0"){
                    $.alet("请首先登陆");
                    denglu(showJ);
                    return false;
                }
                giveUpFun();
                content=content.replace(/\[face:(\(?[0-9]+\)?)]/g,"<img src="+base_url+"face/$1.gif>");
                if((user_id != undefined)&&(user_id !=""))
                    CCA(content,nowTime(),user_name,user_id,data["photo"],data["comment_id"]);
                else
                    CCA(content,nowTime(),$.cookie("user_name"),$.cookie("user_id"),data["photo"],data["comment_id"]);
            },
            error:function(xml){
                console.log(xml);
            }
        });
        node.value = "";
        return false;
    });
}
function nowTime () {
    //获得本地的时间"2013-4-6 20:27:32"的形式
    var time=new Date();
    return time.getFullYear()+"-"+(time.getMonth()+1)+"-"+time.getDate()+" "+time.getHours()+":"+time.getMinutes()+":"+time.getSeconds();
}
function getCom (id) {//或许设置成滚动加载比较好
    //通过art_id 获得评价信息，不分页，我觉得，分页反而会增加代码量，也很少有需要分页的帖子，之后如果出现很长很长的，就再处理吧
    //之后在这里绑定时间
    $.ajax({
        url:site_url+"/showart/getCom/"+id,
        dataType:"json",
        success:function(data,responseText){
            console.log(data);
        for (var i = 0,len = data.length; i < len; i++) {
            data[i]["comment"]=data[i]["comment"].replace(/\[face:(\(?[0-9]+\)?)]/g,"<img src="+base_url+"face/$1.gif>");
            CCA(data[i]["comment"],data[i]["reg_time"],data[i]["name"],data[i]["user_id"],data[i]["photo"],data[i]["comment_id"],i+1);
        };
        $("#ulCont").delegate(".thumb ","mouseenter",function  () {
            $(this).find("p").fadeOut();
        }).delegate(".thumb","mouseleave",function  () {
            $(this).find("p").fadeIn();
        })
    },
    error:function(xml){
        console.log(xml);
    }
    });
}
function CCA(cont,time,name,userId,photo,comId) {
    //comId目前不准备使用,以后添加修改评论功能吧，创建评论的li
    //用户评论后生成内容,好挫
    var li = document.createElement("li");
    $(li).addClass("alire");//art li
    $(li).append("<a  class = 'thumb' href = '"+site_url+"/space/index/"+userId+"'><img class = 'block' title = '"+name+"' src = '"+base_url+"upload/"+photo+"'/></a>");
    $(li).append("<p class = 'cct'>"+cont+"</p>");
    $(li).append("<p class = 'atime'><span class = 'userName'>"+name+"</span>--<span class = 'layer'>"+layer+"楼</span> -- <span class = 'time'>"+time+"</span></p>");
    layer++;
    $("#ulCont").append(li);
}
function getName (name) {//通过传入的url获得其中隐藏的图片名称
    var reg = /(\d+).gif$/;
    return reg.exec(name)[1];
}
function com() {//controller the comment area hide or show
    //为了解决bug，延迟1s，然后执行
    //setTimeout(function  () {
        console.log("testing setTimeout");
        showUp = 0;
        $("#dcom").click(function(){
            if((user_id == "")||(user_id == null)){
                $.alet("请登陆后发表评论");
                denglu(showJ);
                return false;
            }
            if(showUp == 0){
                showJ();
                showUp = 1;
            }
            //$("#comform input").fadeIn();
        });
        $("#giveup").click(function(){
            giveUpFun();
            showUp = 0;
        });
    //},1000);
}
function showJ () {
    //showJudgearea，将评论区域显示出来
    //$("#comcon").val("");
    $("#comcon").animate({
        height:"200px"
    },'fast').val("");
    $("#face").fadeIn();
    $("#subcom").css("display","block");
    $("#giveup").css("display","block");
}
function giveUpFun () {
    var node  = document.getElementById("comcon").value = "";
    $("#face").fadeOut();
    $("#comcon").animate({
        height:"33px"
    }).val("评论..");
    $("#subcom").fadeOut();
    $("#giveup").fadeOut();
}
function mouse () {
    //睡觉了，下面就是关于位置的判断http://www.neoease.com/tutorials/cursor-position/
    var dir = 1;//前后三次，对比是否是水平滑动-》角度在30度以内的2*y>x
    //dir 表示侧边栏的状态，1表示上次向右，已经展开，2向左，闭合的状态，初始状态为打开，为1
    var sp = {x:0,y:0},ep = {x:0,y:0};
    if(document.addEventListener){
        document.addEventListener("touchstart",first,true);
        document.addEventListener("touchmove",move,true);
    }
    function first (event) {
        event = event.touches[0];
        sp.x = event.clientX;
        sp.y = event.clientY;
    }
    var ulCont = $("#content");
    var dir = $("#dir"),hiA = $("#hiA");
    function move (event) {
        document.removeEventListener("touchmove",move,true);
        var ev = event.touches[0];
        ep.x = ev.clientX;
        ep.y = ev.clientY;
        var y = Math.abs(ep.y-sp.y);
        var x = ep.x - sp.x;
        if((dir == 1)&&(2*y<(-x))){//x 小于0代表左滑动，关闭
            event.preventDefault();
            hide();
            dir = 2;
        }else if((dir == 2)&&(2*y<x)){//大于0向右滑动，打开，dir为2，状态
            event.preventDefault();
            dir = 1;
            show()  ;
        }
        setTimeout(function  () {
            document.addEventListener("touchmove",move,true);
        },500);
    }
    function show () {
        //控制边栏的显隐和主要区域的移动
        dir.css("top",$(window).scrollTop());
        dir.css("display","block");
        ulCont.animate({
            "margin-left":"250px"
        },200);
        hiA.text("隐藏");
    }
    function hide () {
        ulCont.animate({
            "margin-left":"0px"
        },200,function () {
            dir.css("display","none");
        });
        hiA.text("显示");
    }
    //控制边框的显示隐藏和旁边body的显示margin,效果一般，不绚烂，漂亮的将来作吧
    //整合到dir.js中
    if(isPc==0){
        $(".dp").css("width",$(document).width()).css("position","relative");//在非pc平台上，宽度设置为文档宽度
        hiA.css("display","inline");
        $(".sli").css("min-width","272px");
        $(".but").css("width","65px");
    }
    var flag = 1;//1 表示还在显示，0表示正在隐藏中
    hiA.click(function  (){
        flag?hide():show();
        flag = 1-flag;
    });
}
function Pc () {
    var p = navigator.platform;
    if(p.indexOf("Win"))return 1;
    if(p.indexOf("X11"))return 1;
    if(p.indexOf("Mac"))return 1;
    if(p.indexOf("Linux"))return 1;
    return 0;
}
/************cookie的内容**************/
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        //貌似添加了这些之后，就没有办法保存cookie了,但是cookie的保存时间怎么办呢
        options = options || {};//什么意思
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        var path = options.path ? '; path=' + options.path : '';
        var domain = options.domain ? '; domain=' + options.domain : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
jQuery.alet = function (cont) {//给出各种提示的函数，和alert不同，这个过1s就消失
    var alet = document.createElement("div");
    var p = document.createElement("p");
    var css = {
        width:'200px'
    };
    $(alet).css(css);
    css = {
        position:'absolute',
        padding:'15px',
        background:'#000',
        top:$(window).scrollTop()+100+"px",
        left:$(document).width()/2-100+"px",
        margin:'0 auto',
        "border-radius":"5px",
        color:"white",
        "z-index":"20"
    }
    $(p).css(css);
    $(p).text(cont);
    $(alet).append(p);
    $("body").append(alet);
    setTimeout(function  () {
        $(alet).detach();
    },999);
}
function showInfo (index,main,total) {
    //index aImg 调出悬浮的关键，mian 悬浮的主体，totol，总的父亲，delegate的根
    //控制用户信息悬浮的函数I;
    var inarea = 0,flag = 0,show = 0,info = null,lastCon = null;//在可悬浮区域内部外部标志变量
    //flag hover 中用到的标志位
    //lastCon 上一个显示出来的aImg,在进入aImg 的时候判断,show 是否正在显示状态
    $(total).delegate(index,"click",function  (event) {
            if((info != null)&&(lastCon != this)){//在上一个,因为有进入另一个的可能性，所以需要判断新进入的和上一个是不是同一个
                var temp = info;
                //temp.slideUp();//让他慢慢消失吧,一个的消失是另一个的开始
                up(temp);
                show = 0;
            }
            lastCon = this;//现在正在有一个显示中,将正在显示的复制
            inarea = 1;
            info = $(this).siblings(main);//添加判断，多用
            if(info.length == 0)
                info = $(this).find(main);
        //  show?info.slideUp():info.slideDown();
            if(show){
                up(info);
            }
            else if(isPc == 0)info.css("display","block");
            else {
                //info.slideDown();
                down(info);
            }
            show = 1-show;
        //event.preventDefault();
    }).delegate(index,"mouseleave",function  () {
        //info = $(this).siblings(".userCon");//离开的时候将她赋值，成为全局变量,方便之后隐藏
        //既然click过，必然enter，不必在查找dom
        inarea = 0;
        if(show)close();//自由在落下来的情况下，会开始计时
    }).delegate(main,"mouseenter",function  () {
        inarea = 1;//单纯的延长时间
    }).delegate(main,"mouseleave",function  () {
        inarea = 0;
        if(show)close();
    }).delegate(index,"hover",function  () {
        if(isPc == 0)return;
            if((info != null)&&(lastCon != this)){//在上一个,因为有进入另一个的可能性，所以需要判断新进入的和上一个是不是同一个
                var temp = info;
                //temp.slideUp();//让他慢慢消失吧,一个的消失是另一个的开始
                up(temp);
                show = 0;
            }
            temp = this;
            info = $(this).siblings(main);//添加判断，多用
            if(info.length == 0)
                info = $(this).find(main);
            //show?info.slideUp():info.slideDown();
            if(flag == 0){
                inarea = 1;//hover 在进出的时候都会触发，所以必须在只能打开一次，才不会出bug
                flag = 1;
                lastCon = this;
                setTimeout(function  () {
                    if((lastCon == temp )&& (inarea)&&(show == 0)){
                        down(info);
                        show = 1;
                    }
                    flag = 0;
                },500)
            }
    });
    function down (node) {
        $(node).css("opacity",0).slideDown(400).animate(
            {opacity:1},
            {queue:false,duration:"slow"}
        );
    }
    function up (node) {
        $(node).css("opacity",1).slideUp("slow").animate(
            {opacity:0},
            {queue:false,duration:"normal"}
        );
    }
    function close () {
        //延迟0.5S，之后不在显示区域就隐藏
        setTimeout(function  () {
            if(inarea == 0){
                up(info);
                info = null;
                show = 0;
            }
        },9900);
    }
}
function dir () {
    showInfo(".diri","ul","#dir");
}
