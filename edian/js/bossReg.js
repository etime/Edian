var objName,objPasswd,objPhone,objemail,objLoginName ;
//funpasswd 是检验密码的对象，name是namecheck对象的实例,imgcheck是图片验证码的检验，sms是短信验证码,file上传图片检验和操作,phone 是手机号码检验
/**
 * _flag 为2的时候代表检验完成
 * 1的时候是输入完毕一个
 * 0的时候
 */
function fpasswd(){
    //单例模式实现密码检验
    var $this = this;
    $this._flag = 0;//当flag置位2的时候，是可以的时候
    $("input[type = 'password']").change(function  () {
        value = $.trim($(this).val());
        if(value.length<=6){
            report("#pass","太短,太简单的密码容易被破解哦");
            return false;
        }else if(value.length > 20){
            report("#pass","太长了，请适当减短密码");
        }else if($this._flag == 1){
            var passwd = $("input[type = 'password']");
            var pa1 = $(passwd[0]).val();
            var pa2 = $(passwd[1]).val();
            if(pa1 === pa2){
                $this._flag = 2;//为2的时候，代表检验完成
            }else{
                $(passwd[0].parentNode).find("span").removeClass("success");
                $(passwd[1].parentNode).find("span").removeClass("success");
                report("#pass","两次密码不一致");
            }
        }else{
            //无论之前是否为2,或者为0,现在都重新开始,刚刚输入一个的状态
            $this._flag = 1;
            $(this.parentNode).find("span").addClass("success").text("");
            //下一步，在这里输入对应的提示
        }
    }).focus(function () {
        $(this.parentNode).find("span").text("请输入6-20位中英文字符");
    });
}
/**
 * 名称不能超过一定长度
 */
function namecheck(){
    var $this = this;
    $this._flag = 0;
    $("input[name = 'nickname']").blur(function () {
        var name = $.trim($(this).val());
        console.log(name);
        if(name.length > 10){
            report("请保持文字在10字以内，谢谢");
            $this._flag = 0;
        }else  $this._flag = 1;
    }).focus(function () {
        $(this.parentNode).find("span").text("请输入1-10位中英文字符");
    });
}
function floginName() {
    $("input[name = 'loginName']").focus(function () {
        $(this.parentNode).find("span").text("请输入10位以内中英文字符或数字");
    }).change(function () {
        var val = $.trim($(this).val());
        console.log(val);
        var reg = /[~!`@#$%^&*()_+-={}|[]\;:'\"<>?,\/.]+/;
        if(reg.exec(val)){
            alert("yes")
        }else alert("no");
    })
}
/**
 * 检验手机号码 短信验证码
 * 点击发送之后，发送按钮小时，使用倒计时取代
 * _flag为2 的情况下是手机号码正确和验证码
 */
function funPhone(){
    var $this = this;
    $this._flag = 0;
    $("input[name = 'phoneNum']").change(function  () {
        $(this).unbind("keypress");//删除press事件，防止意外
        value = $.trim($(this).val());
        reg = /^1[\d]{10}$/;
        if(reg.exec(value)){
            $this._flag = 1;
            report("验证正确","#contra","green");
        }else {
            $this._flag = 0;
            report("请正确输入号码","#contra","red");
        }
    }).focus(function  (event) {
        $("#contra").text("请输入手机号方便送货");
        $(this).keypress(function  (event) {
            if(((event.which<48)||(event.which>57))&&(event.which != 45)){
                return false;
            }
        })
    })
    var smsflag = false;
    $("#smschk").click(function(){
        if($this._flag){
            var phNum = $.trim($("input[name = 'phoneNum']").val());
            if(smsflag){
                $.alet("请稍等半分钟");
            } else {
                smsflag = true;
                $.get(site_url + "/checkcode/sms/" + imgCode + "/" + phNum,function(data,textStatus){
                    if(textStatus == "success"){
                        $.alet(data);
                        $this._flag = 2;
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
            $.alet("请首先输入合适的手机号码");
        }
    })
}
$(document).ready(function(){
    objName   = new  namecheck();
    objPasswd = new fpasswd();
    objPhone  = new funPhone();
    objLoginName = new floginName();
    $("form").submit(function () {
        if(!objName._flag){
            report("#nameCheck","请正确输入用户名");
        }else if( !objPasswd._flag){
            report("#pass","请检验密码是否相同")
        }else if( objPhone._flag == 0){
            report("#contra","请输入手机号码，以便送货");
        }
    })
});
function report (select,cont) {
    $(select).text(cont);
    $(select).css("color","red");
}
