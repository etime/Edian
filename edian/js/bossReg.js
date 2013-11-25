var objName,objPasswd,objPhone,objemail;
//funpasswd 是检验密码的对象，name是namecheck对象的实例,imgcheck是图片验证码的检验，sms是短信验证码,file上传图片检验和操作,phone 是手机号码检验
function fpasswd(){
    //单例模式实现密码检验
    if(!objPasswd){
        function temp() {
            var $this = this;
            console.log("ab");
            $this.flag = 0;//当flag置位2的时候，是可以的时候
            $("input[type = 'password']").change(function  () {
                value = $.trim($(this).val());
                console.log(value);
                if(value.length<=5){
                    report("太短,太简单的密码容易被破解哦","#pass","red");
                    return false;
                }else if($this.flag == 1){
                    var passwd = $("input[type = 'password']");
                    var pa1 = $(passwd[0]).val();
                    var pa2 = $(passwd[1]).val();
                    if(pa1 == pa2){
                        $this.flag = 2;//为2的时候，代表检验完成
                    }
                }else{
                    //无论之前是否为2,或者为0,现在都重新开始,刚刚输入一个的状态
                    $this.flag = 1;
                    //下一步，在这里输入对应的提示
                }
            });
        }
        return new temp();
    }else return objPasswd;
}
/**
 * 名称不能超过一定长度
 */
function namecheck(){
    if(!objName){
        function temp(){
            $("input[name = 'userName']").blur(function () {
                console.log($(this).val());
            })
        }
        return new temp();
    }else return objName;
}
    /**
     *  phone check 检验手机号码
     */
function funPhone(){
    if(!objPhone){
        function temp() {
            var $this = this;
            $this.flag = false;
            $("input[name = 'contra']").blur(function  () {
                $(this).unbind("keypress");//删除press事件，防止意外
                value = $.trim($(this).val());
                reg = /^1[\d]{10}$/;
                if(reg.exec(value)){
                    $this.flag = true;
                    report("验证正确","#contra","green");
                }else {
                    $this.flag = false;
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
        }
        return new temp();
    }else return objPhone;
}
    /**
     * 短信验证码
     */
function scheck() {
    if(!sms){
        function temp(){
            var $this = this;
            $this.flag = 0;
            var smsflag = 0;//smsflag 防止多次发送短信
            //点击发送之后，发送按钮小时，使用倒计时取代
            $("#smschk").click(function(){
                if(imgCheck && phone){
                    var imgCode = $("#incheck").val();
                    var phNum = $("input[name = 'contra']").val();
                    if(smsflag){
                        $.alet("请稍等半分钟");
                    }else if(phNum && imgCode){
                        smsflag = 1;
                        $.get(site_url + "/checkcode/sms/" + imgCode + "/" + phNum,function(data,textStatus){
                            if(textStatus == "success")
                                $.alet(data);
                            else{
                                $.alet("发送失败");
                            }
                            setTimeout(function() {
                                smsflag = 0;//每隔一定时间，允许发送一次短信验证码
                            }, 20000)
                        })
                    }else{
                        $.alet("请首先输入图片验证码");
                    }
                }
            })
        }
        return new temp();
    }else return sms;
}
$(document).ready(function(){
var objName,objPasswd,objPhone,objemail;
    objName   = namecheck();
    objPasswd =  fpasswd();
    objPhone = funPhone();
    objemail = funemail();
});
function report (cont,select,color) {
    $(select).text(cont);
    $(select).css("color",color);
}
