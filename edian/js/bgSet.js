/**
 * 这里对应的是view/bgHomeSet.php
 * @name        bgSet.js
 * @since       2013-12-09 10:53:35
 * @author      unasm<1264310280@qq.com>
 */
/* 地图的对象，*/
var objMap;
/**
 * 百度地图的操作集中
 */
function testMap() {
    //var map = new BMap.Map("allmap");

    // 初始化
    /*
    map.enableScrollWheelZoom();                            //启用滚轮放大缩小
    map.enableInertialDragging();
    map.enablePinchToZoom();//双指缩放
    map.enableAutoResize();
    */
    //自动定位的实现
    /*
    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function(location){
        if(this.getStatus() == BMAP_STATUS_SUCCESS){
            var mk = new BMap.Marker(location.point);
            map.centerAndZoom(location.point, 12);
            console.log(location.point);
            map.addOverlay(mk);
            map.panTo(location.point);
        }
        else {
        var point = new BMap.Point(103.94095284007, 30.759532535854);
        map.centerAndZoom(point,12);
            console.log("failed");
            //alert("定位失败，请手动定位");
            reportBug("百度地图出现bug，无法定位,错误代码为:" + this.getStatus());
        }
    },{enableHighAccuracy: true})
    */
}
function funMap () {
    var map = new BMap.Map("allmap");

    // 初始化
    map.enableScrollWheelZoom();                            //启用滚轮放大缩小
    map.enableInertialDragging();
    map.enablePinchToZoom();//双指缩放
    map.enableAutoResize();

    //自动定位的实现
    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function(location){
        if(this.getStatus() == BMAP_STATUS_SUCCESS){
            var mk = new BMap.Marker(location.point);
            map.centerAndZoom(location.point, 12);
            console.log(location.point);
            map.addOverlay(mk);
            map.panTo(location.point);
        }
        else {
        var point = new BMap.Point(103.94095284007, 30.759532535854);
        map.centerAndZoom(point,12);
            console.log("failed");
            //alert("定位失败，请手动定位");
            reportBug("百度地图出现bug，无法定位,错误代码为:" + this.getStatus());
        }
    },{enableHighAccuracy: true})

    //站点图标logo
    //var icon = new BMap.Icon(base_url+"favicon.ico",new BMap.Size(24,24));

    //标注的样式和属性初始化
    /*
    var markeOpt = {
        icon:icon,
        enableDragging:true,
        raiseOnDrag:true
    }
    */
    //默认从开始就定位,网站性质使然
    /*
    var locinit = {
        locationIcon:icon,
        enableAutoLocation:true
        }
    */
   /*
    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function (status) {
        if(this.getStatus()  == BMAP_STATUS_SUCCESS)console.log("yes");
        else console.log("no");
    })
    */
    /*
    var loc = new BMap.GeolocationControl(locinit),point;
    function success(opt) {
        var opts = {title:"<i style = 'font-size:10px'>贴心小提示:可以右键修改位置哦</i>"}
        var info = new BMap.InfoWindow("您的店在这里",opts);
        map.openInfoWindow(info,opt.point);
        console.log(opt.point);
        //point = new BMap.Point(opt.point.lng,opt.point.lat);
        console.log(point);
        //$("#pos").val(opt.point.lng+";"+opt.point.lat);
        map.centerAndZoom(point,18);//定位成功之后，将图片放到到比较大的位置，即使失败，也按照一般来说放大
    }
    */
    /*
    function error () {
        var lat = "30.757588",lng = "103.93707";
        point = new BMap.Point(lng,lat);
        map.centerAndZoom(point,18);
    }
    */
    /*
    loc.addEventListener("locationSuccess",success);
    loc.addEventListener("locationError",error);
    map.addControl(loc);
    */
    /*************关于右键定位******************/
    /*
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
    //添加覆盖物物品
    function overlay (po) {
        if(marker)map.removeOverlay(marker);
        marker = new BMap.Marker(po,markeOpt);
        $("#pos").val(po.lng+";"+po.lat);
        map.addOverlay(marker);
        marker.setAnimation(BMAP_ANIMATION_BOUNCE);
        setTimeout(function  () {
            marker.setAnimation(null);
        },800);
    }
    */
}
/**
 * 过滤掉不允许输入的字符
 * 所有的特殊字符都去掉了，除了一个-,45号,40,41号对应的是()
 */
function keydel() {
    var arr = [32 ,33, 34, 35, 36, 37, 38, 39, 40, 43, 44, 46, 47, 58, 59, 60, 61, 62, 63, 64, 91, 92, 93, 94, 95, 96 ,123, 124, 125, 126] ;
    //特殊符号对应的keyCode
    $("body").delegate("input[type = 'text']","keypress",function (event) {
        var key = event.keyCode;
        for (var i = 0, l = arr.length; i < l; i ++) {
            if(arr[i] == key) return false;
        }
    })
}
/**
 * business time 营业时间的处理
 * 添加一个营业时间
 */
function busTime() {
    $("#addTime").click(function () {
        var Dtime = $("#dtime").clone();
        var select = $("#dtime").find("select");
        var lstTime = $(select[2]).val();
        var select = $(Dtime).find("select");
        //设置时间
        $(select[0]).val( Math.min(lstTime - 0 + 2 ,23) );
        $(select[2]).val( Math.min(lstTime - 0 + 6 ,23) );
        $("#dtime").after(Dtime);
        $(this).css("display","none");
        //清空内存
        select = null;
        lstTime = null;
        Dtime = null;
    })
}
/**
 * 构建时间，将时间按照一定的格式进行组织的函数
 */
function timeForm() {
    var time = $("select[name = 'time']");
    var val = "";
    for (var i = 0, l = time.length; i < l; i ++) {
        console.log($(time[i]).val());
    }
    //严重依赖dom
    for (var i = 0, l = time.length; i < l; i ++) {
        if(val)val += "&";
        val += $(time[i]).val() + ":" + $(time[i + 1]).val();
        i+=3;
        val += "-" + $(time[i - 1]).val() + ":" + $(time[i]).val();
    }
    $("#time").val(val);
}
function listAdd() {
    var list = $("#list");
    $("#listBut").click(function () {
        var val = $("input[name = 'listName']").val();
        if(!val) return false;
        $("input[name = 'listName']").val("");//清空，防止无意中的二次发送
        $.ajax({
            url: site_url+"/bg/set/listAdd" ,
            type: 'POST',
            data:  {"listName":val},
            success: function (data, textStatus, jqXHR) {
                if(textStatus == "success"){
                    if(data.indexOf("1") != -1){
                        list.append("<li>"+val+"</li>");
                    }
                    else {
                        reportBug("在bgset.js/listAdd/的success返回处理中data=" + data + ",val = " + val);
                    }
                }else{
                    reportBug("在BgSet.js/listAdd函数中返回值为"+textStatus + ",返回的data为" + data);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reportBug("在BgSet.js/listAdd/中返回状态为" + textStatus + ",post value 为" + val);
            }
        });
    })
    list.delegate("li","click",function (){
        if(confirm("s您确定删除该类别？如果存在属于该类别的商品，会导致删除失败")){
            var $this = this;
            console.log($this);
            var val = $($this).text();
            $.ajax({
                url: site_url + "/bg/set/listdelete",
                type: 'POST',
                data: {"listName" : val},
                success: function (data, textStatus, jqXHR) {
                    if(textStatus == "success"){
                        if(data.indexOf("1") == -1){
                            alert(data);
                        }else
                            $($this).empty();
                    }else{
                        reportBug("bgSet/listdelete的时候，输入" + val + ",返回" + textStatus +"请检查一下");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    reportBug("bgset.js/listAdd中的函数删除遇到错误,listName  = " + val);
                }
            });
        }
    })
}
$(document).ready(function () {
    keydel();
    busTime();
    listAdd();
    testMap();
    $("form").submit(function () {
        /**  对时间的操作，整理时间的格式 */
        timeForm();
        return false;
    })

    //关于状态码
    //BMAP_STATUS_SUCCESS 检索成功。对应数值“0”。
    //BMAP_STATUS_CITY_LIST   城市列表。对应数值“1”。
    //BMAP_STATUS_UN  2013-12-07 22:02:47N_LOCATION   位置结果未知。对应数值“2”。
    //BMAP_STATUS_UN  2013-12-07 22:02:47N_ROUTE  导航结果未知。对应数值“3”。
    //BMAP_STATUS_INVALID_    EY  非法密钥。对应数值“4”。
    //BMAP_STATUS_INVALID_REQUEST 非法请求。对应数值“5”。
    //BMAP_STATUS_PERMISSION_DENIED   没有权限。对应数值“6”。(自 1.1 新增)
    //BMAP_STATUS_SERVICE_UNAVAILABLE 服务不可用。对应数值“7”。(自 1.1 新增)
    //BMAP_STATUS_TIMEOUT 超时。对应数值“8”。(自 1.1 新增)
    //objMap = new  funMap();
})
