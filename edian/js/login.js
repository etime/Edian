/**
 * 登录的管理和控制
 * 作为这个的使用约束，就是在一个id为login的form下，函数名必须是login
 * @name        ../../js/login.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-18 21:22:07
*/

/**
 * 对密码的检验
 * 2代表什么都没有输入
 * 1代表已经输入完成了一个
 * 0 代表完成了 密码的校验
 */
function fpasswd(){
    var $this = this;
    $this._bro = null ,$this._flag = 2 ,$this.self = $(".r input[type = 'password']");
    $this.self.blur(function  () {
        var value = $(this).val();
        if(!value)return false;
        if(value.length<6){
            $($this._bro).text("密码太短，不安全哦").addClass("failed").removeClass("success");
            return false;
        }else if(value.length > 20){
            $($this._bro).text("密码过长").addClass("failed").removeClass("success");
        }else if($this._flag === 1 || $this._flag === 0){
            checkPasswdSame();
        }else{
            $this._flag = 1;
            $($this._bro).addClass("success").text("");
        }
    }).focus(function () {
        $this._bro = $(this.parentNode).find(".atten");
        $($this._bro).text("请输入6-20位中英文字符").removeClass("success").removeClass("failed");
    });
    var passNode1 = $($this.self[0].parentNode).find("span");
    var passNode2 = $($this.self[1].parentNode).find("span");
    function checkPasswdSame() {
        //除了passwd之外其他的都进行trim
        var pa1 = $($this.self[0]).val();
        var pa2 = $($this.self[1]).val();
        if(pa1 === pa2){
            $this._flag = 0;//为2的时候，代表检验完成
            passNode1.removeClass("failed").addClass("success").text("");
            passNode2.removeClass("failed").addClass("success").text("");
        }else{
            $this._flag = 1;
            passNode1.removeClass("success").text("");
            passNode2.removeClass("success").text("");
            $($this._bro).addClass("failed").text("两次密码不同");
        }
    }
}



/**
 * 检验手机号码 短信验证码
 * 点击发送之后，发送按钮小时，使用倒计时取代
 * _flag为0 的情况下是手机号码正确和验证码
 * 1 为手机号正确，
 * 2 为都不正确,或则什么都没有做的状态
 */
function funPhone(){
    var $this = this;
    $this._flag = 2 , $this.selfPhone = $("input[name = 'phoneNum']") , $this.selfCode = $("input[name = 'checkNum']");
    $this.selfPhone.blur(function  () {
        $(this).unbind("keypress");//删除press事件，防止意外
        var value = $.trim($(this).val());
        if(!value)return false;
        var reg = /^1[\d]{10}$/;
        if(reg.exec(value)){
            $this._flag = 1;
            $($this._broPhone).text("").addClass("success");
        }else {
            $this._flag = 2;
            $($this._broPhone).text("请输入正确手机号").addClass("failed");
        }
    }).focus(function  (event){
        $this._broPhone = $(this.parentNode).find("span");
        $($this._broPhone).text("请输入11位手机号码").removeClass("success").removeClass("failed");
        $(this).keypress(function  (event) {
            if( (event.which<48) || (event.which>57) ){
                return false;
            }
        })
    })
    var smsCnt = 0,smsCode = false , interval = false;
    $("#smschk").click(function(event){
        if($this._flag != 1){
            $("input[name = 'phoneNum']").focus();   //只有手机号码已经正确的情况下才可以进入这里
            return false;
        }
        event.preventDefault();
        var phNum = $.trim($("input[name = 'phoneNum']").val());
        if(smsCnt === 0){
            $this._broCode = $(this.parentNode).find("span");
            $($this._broPhone).removeClass("failed").addClass("success");//防止用户change之后，点击phone
            smsCode = false, smsCnt = 30;
            //应该将检验手机号码的和合格性和验证码放一起，这样如果合适的话，就发送短信，不合适的话，就放弃
            $.getJSON(site_url + "/register/smssend/" + phNum ,function(data,textStatus){
                console.log(data);
                if(textStatus == "success"){
                    $($this._broCode).text("")
                    if(typeof data == "object"){
                        $($this._broPhone).text(data["failed"]).removeClass("success").addClass("failed");
                    }else{
                        smsCode = data;
                    }
                    //( typeof data == "object" ) ?  $($this._broCode).text(data["failed"]).removeClass("success").addClass("failed") : ( smsCode = data );
                }
                else{
                    console.log("发送失败");//向后台报告这种错误的情况吧
                }
            })
            $($this._broCode).removeClass("success").removeClass("failed");
            interval = setInterval(function () {
                if(smsCnt=== 0){
                    $($this._broCode).text("");
                    clearInterval(interval);
                    interval = false;
                }else {
                    smsCnt --;
                    $($this._broCode).text(smsCnt + "秒");
                }
            },1000)//2s之后，重新发送一次短信验证码
        }
    })
    $this.selfCode.blur(function () {
        if(smsCode){
            var phoneCode = $.trim($(this).val());
            if(smsCode == phoneCode){
                $($this._broCode).text("").addClass("success").removeClass("failed");
                if(interval){
                    smsCnt = 0;
                    $this._flag = 0;
                    clearInterval( interval );
                }
            }
        }
    })
}

/**
 * 做成一个自闭的登录管理函数
 * 只需要外界调用login，就可以完成登录的内容
 * @param {string} callBack  回调函数，在成功的时候触发，这个是为了适应不同的情况和情景
 */

function login(callBack){
    showNav();
    var login = $("#login");
    /**
     * 目前就简单的替换成为注销，以后添加用户中心之类的
     */
    function replaceDom() {
        var str = "<a href = '" + site_url + '/destory/zhuxiao'+ "' class = 'zhuxiao'>注销</a>";
        $('.replace').html(str);
    }
    //监测 注销和登录两种事情
    $(".replace").delegate('a' , 'click' , function (event) {
        var name = $(this).prop('class');
        if(name === 'zhuxiao'){
            event.preventDefault();
            $.ajax({
                url: $(this).prop('href'),
                success: function (data, textStatus, jqXHR) {
                    alet('注销成功');
                    var str = "<a href = '#' id = 'gotoLogin' class = 'gotoLogin'>登录</a>  | <a href = '" + site_url + '/register/userRegister/' + "'>注册</a>";
                    $('.replace').html(str);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("出错了");
                }
            });
        } else if(name === 'gotoLogin'){
            login.fadeIn();
            show(false);
            event.preventDefault();
        } else if(name === 'register'){
            login.fadeIn();
            show(true);
            event.preventDefault();
        }

    })
    //如果已经登录，就替换dom
    if(userId)replaceDom()
    $("#login .l").submit(function (event) {
        var name = login.find("input[name = 'userName']").val();
        var pass = login.find("input[name = 'password']").val();
        if(name && pass){
            $.ajax({
                url: site_url + '/login/loginCheck',type: 'POST',dataType: 'json',
                data:{'userName' :name , 'password' : pass},
                success: function (data, textStatus, jqXHR) {
                    if(data === 'true'){
                        login.find(".atten").text('登录成功');
                        login.fadeOut();
                        if(callBack){
                            callBack();
                        }
                        userId = true;
                        replaceDom();
                    } else {
                        login.find(".atten").html(data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    login.find(".atten").text('登录失败' + textStatus);
                }
            });
        } else if(!name){
            login.find(".atten").text('请输入用户名或者手机号码');
            login.find("input[name = 'userName']").focus();
        } else {
            login.find(".atten").text('请输入密码');
            login.find("input[name = 'password']").focus();
        }
        event.preventDefault();
    });
    var objPasswd = new fpasswd();
    var objPhone  = new funPhone();
    var objLoginName = new floginName();
    $("#login .r").submit(function () {
        if(objLoginName._flag != 0){
            $(objLoginName.self).focus();
        }else if( objPasswd._flag != 0){
            $(objPasswd.self[0]).focus();
        }else if( objPhone._flag == 2){
            $(objPhone.selfPhone).focus();
        }else if( objPhone._flag == 1){
            $(objPhone.selfCode).focus();
        }else return true;
        return false;
    })
    $("#login .shut").click(function () {
        login.fadeOut();
    })

    var regd = $("#regd");
    /**
     * 显示登录框中不同的区域
     * @param {boolen} flag 当为true的时候显示注册，false的时候显示登录
     */
    function show(flag) {
        regd.find('.focus').removeClass('focus');
        if(flag){
            regd.find("span[name = 'r']").addClass('focus');
            login.find('.l').css('display','none');
            login.find('.r').fadeIn();
        } else {
            regd.find("span[name = 'l']").addClass('focus');
            login.find('.r').css('display','none');
            login.find('.l').fadeIn();
        }

    }
    regd.delegate('span' , 'click' , function () {
        var name = $(this).attr('name');
        if(name === 'r'){
            show(true);
        }else {
            show(false);
        }
    })
}
/**
 * 弹出框，一定时间后自动小时
 * 给出各种提示的函数，和alert不同，这个过1s就消失
 * @param {string} cont 通过弹出框想要说的内容
 */
function alet(cont) {
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
    },3999);
}

/**
 * 控制nav的显示和控制
 */
function showNav() {
    var nav = $("#nav");
    $("#tonav").mouseenter(function (event) {
        nav.fadeIn();
        event.preventDefault();
    })
    $("#tab").mouseleave(function (event) {
        nav.fadeOut();
        event.preventDefault();
    })
}
/**
 * 检测登录名的唯一性和合法性
 * @todo 有待检验get唯一性
 * @整体完成的话，添加一个keypress把
 */
function floginName() {
    var $this = this;
    $this_bro = null , $this._flag = 1 ,$this.self = $("input[name = 'loginName']");
    $this.self.focus(function () {
        $this._bro = $(this.parentNode).find("span");
        $($this._bro).text("请输入20位以内中英文字符或数字").removeClass("success").removeClass("failed");
    }).blur(function () {
        var val = $.trim($(this).val());
        if(!val)return false;
        var reg = /[~!`@#$%^&*()_\+\-\={}\\\|\[\]\;:'\"<>?,\/.]/;
        if(reg.exec(val)){
            $this._flag = 1;
            $($this._bro).text("请用中文英文数字").addClass("failed");
        }else if(val.length > 20){
            $($this._bro).text("清不要超过20位").addClass("failed").removeClass("success");
        }else{
            $.get(site_url + "/register/checkLoginName?loginName=" + val,function(data,textStatus){
                if(textStatus == "success"){
                    if(data.indexOf("false") == -1){
                        $this._flag = 0;
                        $($this._bro).addClass("success").text("");//或许这里的符号，可以成为等待符号
                    }else {
                        $this._flag = 1;
                         $($this._bro).addClass("failed").text("登录名重复");//或许这里的符号，可以成为等待符号
                    }
                }
                else{
                    console.log(textStatus);//这种情况改怎么处理呢，向后台报错？
                }
            })
        }
    })
}

