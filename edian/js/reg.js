var funpasswd,funname,imgCheck,phone,sms,file;
//funpasswd 是检验密码的对象，name是namecheck对象的实例,imgcheck是图片验证码的检验，sms是短信验证码,file上传图片检验和操作,phone 是手机号码检验
function fpasswd(){
    //单例模式实现密码检验
    if(!funpasswd){
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
        return new temp();
    }else return funpasswd;
}
 function namecheck(){
    if(!funname){
        function temp(){
            var $this = this;
            $this.flag = 0;
            $("input[name = 'userName']").change(function(){
                name = $.trim($(this).val());
                $this.flag = 0;//每次修改的时候修改成为0
                var reg = /[\[\];\"\/?:@=#&<>%{}\\|~`^]/,reg2 = /^1[\d]{10}$/;//如果名字类似与手机号码，就无法将
                var temp = reg.exec(name);
                if(temp){
                    report("抱歉,符号"+temp[0]+"不可以用","#name","red");
                }else if(reg2.exec(name)){
                    report("请不要使用类似于手机号码的名字","#name","red");
                }else if(name.length){
                    $.post(site_url+"/reg/get_user_name",{"userName":name},function(data,status) {
                        if(status === "success"){
                            //当不是成功的时候，向后台发一个警告吗？
                            if(data["id"] != "0"){
                                report("该用户已经存在，请更改","#name","red");
                            }
                            else {
                                report("恭喜，用户名可用","#name","green");
                                $this.flag = 1;
                            }
                        }
                    });
                }else report("请输入用户名","#name","red");
            })
        }
        return new temp();
    }else return funname;
}

/**
 * 图片验证码检验
 */
function icheck(){
    if(!imgCheck){
        function temp(){
            var $this = this;
            $this.flag = false;
            $("input[name = 'checkcode']").change(function  () {
                var value = $.trim($(this).val());
                if(value.length == 0)return false;
                $.get(site_url+"/checkcode/check/"+value,function  (data,status) {
                    if(status == "success" && (data == 1)){
                        $this.flag = true;
                        report("验证码正确","#spanCheck","green");
                    }else{ report("验证码错误","#spanCheck","red");
                        $this.flag = false;
                    }
                })
            })
        }
        return new temp();
    }else return imgCheck;
}
/**
 *  phone check 检验手机号码
 */
function pcheck(){
    if(!phone){
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
    }else return phone;
}
/**
 * 上传头像的检验
 */
function fileCheck(){
    if(!file){
        function temp() {
            var $this = this;
            $this.flag = 0;
            $("#content input[name = 'userfile']").change(function (){
                photo = $(this).val();
                //没有检验图片的大小
                reg = /\.(jpg|jpeg|png|gif)$/i;
                if(reg.exec(photo) === null){
                    report("图片格式应该为jpg,png,gif","#photo","red");
                    photo = false;
                }
                else {
                    report("正确","#photo","green");
                    photo = true;
                }
            });
        }
        return new temp();
    }else return file;
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
    funpasswd = fpasswd();
    imgCheck = icheck();
    funname = namecheck();
    phone  = pcheck();//手机检验
    sms = scheck();//短信检验
    file = fileCheck();
    var photo = false;
    //phone 对手机号码格式的检验，imgcheck,对图片验证码的检验，pass密码的检验，photo，有没有头像
    $("#check").click(function  () {
        //点击修改图片验证码
        $.get(site_url+"/checkcode/index",function  (data,status) {
            document.getElementById("check").src = site_url+"/checkcode/index/"+(new Date()).getTime();
        });
    })

    $("#content form").submit(function  () {
    })
    $("#utype").click(function  (event) {
            //usertype 选择用户时候的控制
        if(event.target.value == 1){
            $.alet("请允许我们对您进行定位,或您在地图上标注您的店铺位置");
            $("#typeatten").text("店家的要求和管理比较严格,可以在所有区域销售");
            $("#map").slideDown();
            map();
        }else if(event.target.value == 2){
            $("#typeatten").text("买家只可以在二手市场销售商品");
            $("#map").slideUp();
        }
    })
});
function report (cont,select,color) {
    $(select).text(cont);
    $(select).css("color",color);
}
function map () {
    //和地图，定位有关的，都在这里
var map = new BMap.Map("allmap");            // 创建Map实例
map.enableScrollWheelZoom();                            //启用滚轮放大缩小
map.enableInertialDragging();
map.enablePinchToZoom();//双指缩放
map.enableAutoResize();
/*************变量的初始化*********************/
var icon = new BMap.Icon(base_url+"favicon.ico",new BMap.Size(24,24));//站点图标logo
var markeOpt = {//标注的样式和属性初始化
    icon:icon,
    enableDragging:true,
    raiseOnDrag:true
}
var locinit = {
    locationIcon:icon,
    enableAutoLocation:true
}//默认从开始就定位,网站性质使然
/************定位**************/
var loc = new BMap.GeolocationControl(locinit),point;
function success(opt) {
    var opts = {title:"<i style = 'font-size:10px'>贴心小提示:可以右键修改位置哦</i>"}
    var info = new BMap.InfoWindow("您的店在这里",opts);
    map.openInfoWindow(info,opt.point);
    point = new BMap.Point(opt.point.lng,opt.point.lat);
    $("#pos").val(opt.point.lng+";"+opt.point.lat);
    map.centerAndZoom(point,18);//定位成功之后，将图片放到到比较大的位置，即使失败，也按照一般来说放大
}
function error (StatusCode) {
    var lat = "30.757588",lng = "103.93707";
    point = new BMap.Point(lng,lat);
    map.centerAndZoom(point,18);
}
loc.addEventListener("locationSuccess",success);
loc.addEventListener("locationError",error);
map.addControl(loc);
/*************关于右键定位******************/
var marker = 0;
map.addEventListener("rightclick",function  () {
    //右键单击添加标注，之所以是右键，因为需要移除之前添加的那些
    var menu = new BMap.ContextMenu();
    var textItem = [{
            text:'我的店在这里',
            callback:function  (p) {
                map.clearOverlays();//将之前的的自动定位之类，手动添加全部清除
                overlay(p);//
                map.removeContextMenu(menu);
            }
    }];
    console.log(textItem[0].text);
    var item = new BMap.MenuItem(textItem[0].text,textItem[0].callback);
    menu.addItem(item);
    map.addContextMenu(menu);
})
function overlay (po) {
    if(marker)map.removeOverlay(marker);
    marker = new BMap.Marker(po,markeOpt);
    $("#pos").val(po.lng+";"+po.lat);
    map.addOverlay(marker);
    marker.setAnimation(BMAP_ANIMATION_BOUNCE);
    setTimeout(function  () {
        marker.setAnimation(null);
    },800);//一直跳觉得有点讨厌，这里跳两下停止
}
}
