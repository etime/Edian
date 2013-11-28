var objName,objPasswd,objPhone,objemail,objLoginName ;
//funpasswd 是检验密码的对象，name是namecheck对象的实例,imgcheck是图片验证码的检验，sms是短信验证码,file上传图片检验和操作,phone 是手机号码检验
/**
 * _flag 为2的时候代表检验完成
 * 1的时候是输入完毕一个
 * 0的时候
 */
function fpasswd(){
    var $this = this;
    $this._bro = null;
    $this._flag = 2;//当flag置位2的时候，是可以的时候
    var passwd = $("input[type = 'password']");
    $("input[type = 'password']").change(function  () {
        value = $.trim($(this).val());
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
 * 名称不能超过一定长度
 */
function namecheck(){
    var $this = this;
    $this._flag = 1;
    $this._bro = null;
    $("input[name = 'nickname']").change(function () {
        var name = $.trim($(this).val());
        if(name.length > 10){
            $($this._bro).text("请保持文字在10字以内").addClass("failed").removeClass("success");
            $this._flag = 1;
        }else  if(name){
            $this._flag = 0;
            $($this._bro).addClass("success").text("");
        }
    }).focus(function () {
        $this._bro = $(this.parentNode).find("span");
        $($this._bro).text("请输入1-10位中英文字符").removeClass("success").removeClass("failed");
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
        $($this._bro).text("请输入10位以内中英文字符或数字").removeClass("success").removeClass("failed");
    }).change(function () {
        var val = $.trim($(this).val());
        console.log(val);
        var reg = /[~!`@#$%^&*()_+-={}|[]\;:'\"<>?,\/.]+/;
        if(reg.exec(val)){
            $($this._bro).text("请只用中文英文数字").addClass("failed");
        }else {
            $($this._bro).addClass("success").text("");//或许这里的符号，可以成为等待符号
            $.get(site_url + "/checkcode/sms/",function(data,textStatus){
                if(textStatus == "success"){
                    //$.alet(data);
                    $this._flag = 0;//有待检验
                }
                else{
                    console.log("");
                    //$.alet("发送失败");
                }
                setTimeout(function() {
                    smsflag = false;//每隔一定时间，允许发送一次短信验证码
                }, 20000)
            })
        }
    })
}
/**
 * 检验手机号码 短信验证码
 * 点击发送之后，发送按钮小时，使用倒计时取代
 * _flag为0 的情况下是手机号码正确和验证码
 * 1 为手机号正确，
 * 2 为都不正确
 */
function funPhone(){
    var $this = this;
    $this._flag = 2;
    $this._bro = null;
    $("input[name = 'phoneNum']").change(function  () {
        $(this).unbind("keypress");//删除press事件，防止意外
        $this._bro = $(this.parentNode).find("span");
        value = $.trim($(this).val());
        reg = /^1[\d]{10}$/;
        if(reg.exec(value)){
            $this._flag = 1;
            $($this._bro).text("").addClass("success");
        }else {
            $this._flag = 2;
            $($this._bro).text("请输入正确手机号").addClass("failed");
        }
    }).focus(function  (event){
        $this._bro = $(this.parentNode).find("span");
        $($this._bro).text("请输入11位手机号码").removeClass("success").removeClass("failed");
        $(this).keypress(function  (event) {
            if(((event.which<48)||(event.which>57))&&(event.which != 45)){
                return false;
            }
        })
    })
    var smsflag = false;
    $("#smschk").click(function(event){
        if($this._flag){
            var phNum = $.trim($("input[name = 'phoneNum']").val());
            if(smsflag){
                $.alet("请稍等半分钟");
            } else {
                smsflag = true;
                $.get(site_url + "/checkcode/sms?phoneNum=" + phNum,function(data,textStatus){
                    if(textStatus == "success"){
                        $.alet(data);
                        $this._flag = 0;
                    }
                    else{
                        $.alet("发送失败");
                    }
                    setTimeout(function() {
                        smsflag = false;//每隔一定时间，允许发送一次短信验证码
                    }, 20000)
                })
            }
        }else{
            $($this._bro).text("请首先输入手机号码").addClass("failed");
        }
    })
}
$(document).ready(function(){
    objName   = new  namecheck();
    objPasswd = new fpasswd();
    objPhone  = new funPhone();
    objLoginName = new floginName();
    $("form").submit(function () {
        debugger;
        //在登录之前检验需要输入的东西
        if(objName._flag != 0){
            $(objName._bro).text("请输入正确的用户名").addClass("failed");
        }else if( !objPasswd._flag != 0){
            $(objPasswd._bro).text("请检查密码").addClass("failed");
        }else if( objPhone._flag != 0){
            $(objPhone._bro).text("请输入手机号码").addClass("failed");
        }else if(objLoginName != 0){
            $(objPhone._bro).text("请正确输入登录名").addClass("failed");
        }else return true;
        return false;
    })
});
