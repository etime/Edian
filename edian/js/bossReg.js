var objName,objPasswd,objPhone,objemail,objLoginName ;
//funpasswd 是检验密码的对象，name是namecheck对象的实例,imgcheck是图片验证码的检验，sms是短信验证码,file上传图片检验和操作,phone 是手机号码检验
/**
 * login zhj5adf
 * _flag 为2的时候代表检验完成
 * 1的时候是输入完毕一个
 * 0的时候
 */
function fpasswd(){
    var $this = this;
    $this._bro = null;
    $this._flag = 2;//当flag置位2的时候，是可以的时候
    var passwd = $("input[type = 'password']");
    $("input[type = 'password']").blur(function  () {
        var value = $(this).val();
        if(!value)return false;
        if(value.length<6){
            $($this._bro).text("密码太短，不安全哦").addClass("failed").removeClass("success");
            return false;
        }else if(value.length > 20){
            $($this._bro).text("密码过长").addClass("failed").removeClass("success");
        }else if($this._flag == 1){
            var pa1 = $.trim($(passwd[0]).val());
            var pa2 = $.trim($(passwd[1]).val());
            if(pa1 === pa2){
                $this._flag = 0;//为2的时候，代表检验完成
                $(passwd[0].parentNode).find("span").removeClass("failed").addClass("success").text("");
                $(passwd[1].parentNode).find("span").removeClass("failed").addClass("success").text("");
            }else{
                $(passwd[0].parentNode).find("span").removeClass("success").text("");
                $(passwd[1].parentNode).find("span").removeClass("success").text("");
                //report("#pass","两次密码不一致");
                $($this._bro).addClass("failed").text("两次密码不一样");
            }
        }else{
            if($this._flag == 0){
                $(passwd[0].parentNode).find("span").removeClass("success").text("");
                $(passwd[1].parentNode).find("span").removeClass("success").text("");
            }
            //无论之前是否为2,或者为0,现在都重新开始,刚刚输入一个的状态
            $this._flag = 1;
            $($this._bro).addClass("success").text("");
            //下一步，在这里输入对应的提示
        }
    }).focus(function () {
        $this._bro = $(this.parentNode).find("span");
        $($this._bro).text("请输入6-20位中英文字符").removeClass("success").removeClass("failed");//.removeClass("success failed");
    });
}
/**
 * 真实姓名不能超过一定长度
 */
function namecheck(){
    var $this = this;
    $this._flag = 1;
    $this._bro = null;
    $("input[name = 'nickname']").blur(function () {
        var name = $.trim($(this).val());
        if(name.length > 20){
            $($this._bro).text("请保持文字在20字以内").addClass("failed").removeClass("success");
            $this._flag = 1;
        }else  if(name){
            $this._flag = 0;
            $($this._bro).addClass("success").text("");
        }
    }).focus(function () {
        $this._bro = $(this.parentNode).find("span");
        $($this._bro).text("请输入1-20位中英文字符").removeClass("success").removeClass("failed");
    });
}
/**
 * 检测登录名的唯一性和合法性
 * @todo 有待检验get唯一性
 * @整体完成的话，添加一个keypress把
 */
function floginName() {
    var $this = this;
    $this_bro = null;
    $this._flag = 1;
    $("input[name = 'loginName']").focus(function () {
        $this._bro = $(this.parentNode).find("span");
        $($this._bro).text("请输入20位以内中英文字符或数字").removeClass("success").removeClass("failed");
    }).blur(function () {
        var val = $.trim($(this).val());
        var reg = /[~!`@#$%^&*()_\+\-\={}\\\|\[\]\;:'\"<>?,\/.]/;
        if(reg.exec(val)){
            $this._flag = 1;
            $($this._bro).text("请用中文英文数字").addClass("failed");
        }else if(val.length > 20){
            $($this._bro).text("清不要超过20位").addClass("failed").removeClass("success");
        }else{
            $($this._bro).addClass("success").text("");//或许这里的符号，可以成为等待符号
            $.get(site_url + "/register/checkLoginName?loginName=" + val,function(data,textStatus){
                if(textStatus == "success"){
                    $this._flag = data.indexOf("true") == -1 ? 1 : 0;
                }
                else{
                    console.log(textStatus);//这种情况改怎么处理呢，向后台报错？
                }
            })
        }
    })
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
    $this._flag = 2;
    $("input[name = 'phoneNum']").blur(function  () {
        $(this).unbind("keypress");//删除press事件，防止意外
        //$this._broPhone = $(this.parentNode).find("span");
        value = $.trim($(this).val());
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
            console.log(event.which);
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
            smsCode = false;
            smsCnt = 20;
            //应该将检验手机号码的和合格性和验证码放一起，这样如果合适的话，就发送短信，不合适的话，就放弃
            $.getJSON(site_url + "/register/smssend/" + phNum ,function(data,textStatus){
                if(textStatus == "success"){
                    $($this._broCode).text("")
                    if("failed" in data){
                        $($this._broCode).text(data["failed"]).removeClass("success").addClass("failed");
                    }else{
                        smsCode = data;
                    }
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
                    $($this._broCode).text(smsCnt + "秒后可重新发送");
                }
            },1000)//2s之后，重新发送一次短信验证码
        }
    })
    $("input[name = 'checkNum']").blur(function () {
        if(smsCode){
            var phoneCode = $.trim($(this).val());
            if(smsCode == phoneCode){
                $($this._broCode).text("").addClass("success").removeClass("failed");
                if(interval) clearInterval( interval );
            }
        }
    })
}
/**
 * 修改提示框的状态；
 */
$(document).ready(function(){
    objName   = new  namecheck();
    objPasswd = new fpasswd();
    objPhone  = new funPhone();
    objLoginName = new floginName();
    $("form").submit(function () {
        //在登录之前检验需要输入的东西
        if(objName._flag != 0){
            $(objName._bro).text("请输入正确的用户名").addClass("failed").removeClass("success");
        }else if( objPasswd._flag != 0){
            $(objPasswd._bro).text("请检查密码").addClass("failed").removeClass("success");
        }else if( objPhone._flag == 2){
            $(objPhone._broPhone).text("请输入您的手机号码").addClass("failed").removeClass("success");
        }else if( objPhone._flag == 1){
            $(objPhone._broCode).text("请输入发送到你手机的验证码").addClass("failed").removeClass("success");
        }else if(objLoginName != 0){
            $(objPhone._bro).text("请正确输入登录名").addClass("failed").removeClass("success");
        }else return true;
        return false;
    })
});
