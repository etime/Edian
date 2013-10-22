/*************************************************************************
    > File Name :  ../js/msea.js
    > Author  :      unasm
    > Mail :         douunasm@gmail.com
    > Last_Modified: 2013-07-13 13:38:55
 ************************************************************************/
var map = new BMap.Map("allmap");
var conIdMark = new Array();
$(document).ready(function  () {
    var pEnd = new BMap.Point(116.58508,"30.739300");
    mapInit();
    cssInit();
    $(window).resize(function  () {
        cssInit();
    })
    var info = $("#info");
    info.delegate(".sde","mousedown",function  (event) {
        //这个的作用是移动右边的数据显示
        var stx = event.clientX,sty = event.clientY;
        var width = info.css("width"),reg = /^\d+/,temp;
        width = reg.exec(width);
        width = width[0];
        $(document).bind("mousemove",function  (event) {
            temp = stx - event.clientX+ parseInt(width);
            info.css("width",temp+"px");
        }).mouseup(function  () {
            $(this).unbind("mousemove").unbind("mouseup");
        })
    });
    var href = location.href.split("#");
    if(href.length>1){
        //一旦用户有了输入，默认刷新的时候也搜索
        if(href[1]){
            $(".res").detach();//将搜索来的结果抹除
            getData(site_url+href[1],1);
        }
    }
    fConIdMark();
})
function cssInit () {
    var height = $(window).height()-40;
    $("#info").css("height",height);
}
function mapInit () {
    var stp = -1,enp,polygon;
    //stp搜索开始的点，搜索结束的点，polygon 绘制出来的举行
    map.enableScrollWheelZoom();                            //启用滚轮放大缩小
    map.enableInertialDragging();
    map.enablePinchToZoom();//双指缩放
    map.enableAutoResize();
    var lat = "30.757588",lny = "103.93707";//可以的话，就更大体定位吧,这种方式不好
    var point = new BMap.Point(lny,lat);
    map.centerAndZoom(point,14);//默认开始定位在科大附近
    var icon = new BMap.Icon(base_url+"favicon.ico",new BMap.Size(24,24));//站点图标logo
    var markeOpt = {//标注的样式和属性初始化
        icon:icon,
        raiseOnDrag:true
    }
    var locinit = {
        locationIcon:icon,
        anchor:BMAP_ANCHOR_BOTTOM_LEFT
    }
    var loc = new BMap.GeolocationControl(locinit);
    map.addControl(loc);
    if(window.addEventListener){
        loc.addEventListener("locationSuccess",success);
        loc.addEventListener("locationError",error);
    }else{
        loc.attachEvent("locationSuccess",success);
        loc.attachEvent("locationError",error);
    }
    function success(opt) {
        if(ploygon)
            map.clearOverlay(polygon);
        var dis = 0.013;
        var opts = {title:"<i style = 'font-size:10px'>贴心小提示:可以右键修改位置哦</i>"}
        var inf = new BMap.InfoWindow("就以这点为中心,阴影内找东西喽",opts);
        stp = new BMap.Point(opt.point.lng-dis,opt.point.lat-dis);
        enp = new BMap.Point(opt.point.lng+dis,opt.point.lat+dis);
        map.openInfoWindow(inf,opt.point);
        map.centerAndZoom(opt.point,15);//定位成功之后，将图片放到到比较大的位置，即使失败，也按照一般来说放大
        drawPoly(stp,enp);
    }
    function drawPoly (st,ep) {
        polygon = new BMap.Polygon([
            new BMap.Point(st.lng,st.lat),
            new BMap.Point(ep.lng,st.lat),
            new BMap.Point(ep.lng,ep.lat),
            new BMap.Point(st.lng,ep.lat)
        ], {strokeColor:"#000", strokeWeight:1,fillColor:"#000",fillOpacity:0.3});
        map.addOverlay(polygon);
    }
    function error (StatusCode) {
        //其实应该是大体定位的，这里
        var lat = "30.757588",lny = "103.93707";
        point = new BMap.Point(lny,lat);
        map.centerAndZoom(point,18);
        $.alet("很遗憾，定位失败,请手动添加");
    }
    var allmap = $("#allmap");
    allmap.mousedown(function  (event) {
        if(event.which == 3){
            stp = getPoint(event);
            $(document).mousemove(function  (event) {
                enp = getPoint(event);
                map.removeOverlay(polygon);
                drawPoly(stp,enp);
            })
            $(document).mouseup(function  () {
                $(this).unbind("mousemove").unbind("mouseup");
            })
            allmap.removeAttr('title');//用户已经知道了，就没有必要存在了
        }
        function getPoint (event) {
            var pixel = new BMap.Pixel(event.clientX,event.clientY);
            return map.pixelToPoint(pixel);
        }
    })
    function rPaint (event) {
        console.log(event.which);
        if(event.which == 3){
            console.log(event.clientX);
            console.log(event.clientY);
        }
    }
    var sub = $("#sub"),sea = $("#sea");
    sub.submit(function  (event) {
        //接下来要在submit的时候，清空所有的悬浮物品
        var key = $.trim(sea.val()),url;
        if(key.length == 0){
            $.alet("请输入关键字");
            return false;
        }
        key = encodeURI(key);
        if(stp == -1){
            $.alet("推荐右键选择具体区域然后搜索");
            key = "/search/index?key="+key;
        }else{
            var dis = Math.max(stp.lng,enp.lng)+"|"+Math.max(stp.lat,enp.lat)+"|"+Math.min(stp.lng,enp.lng)+"|"+Math.min(stp.lat,enp.lat);
            key = "/map/keyd?key="+key+"&p="+dis;
        }
        url = site_url+key;
        console.log(url);
        map.clearOverlays();
        //map.clearOverlays
        //$("#info").empty().addClass("limit");使用动画效果代替
        $(".res").detach();//将搜索来的结果抹除
        getData(url,1);
        var split = location.href;
        split  = split.split("#");
        location.href = split[0]+"#"+key;
        event.preventDefault();
    })
}
function getData(url,page) {
    //向数据库中申请内容，调用时候输入url，这个是为区域搜索和全面搜索准备的
    $.getJSON(url,function  (data,textStatus) {
            if(textStatus  == "success"){
                if(data){
                    var div = document.createElement("div"),li,temp;
                    for (var i = 0 ,len = data.length; i < len; i ++) {
                        temp = data[i]["time"].split(" ");
                        data[i]["time"] = temp[0];
                        li = document.createElement("li");
                        $(li).attr("name",data[i]["author_id"]).append("<div class = sde></div><a href = "+site_url+"/showart/index/"+data[i]["art_id"]+" ><img src = '"+base_url+"thumb/"+data[i]["img"]+"' /></a><a class = detail href = "+site_url+"/Showart/index/"+data[i]["art_id"]+">"+data[i]["title"]+"</a>");
                        $(li).append("<p class = din><em>￥:<b>"+data[i]["price"]+"</b></em>浏览:"+data[i]["visitor_num"]+"/评论:"+data[i]["comment_num"]+"</p><p class = din>时间:"+data[i]["time"]+"</p>");
                        $(div).append(li);
                        conIdMark[data[i]["author_id"]] = addInfo(data[i]["user"],data[i]["author_id"]);
                    }
                    $(div).append("<p class = 'page'>第"+page+"页</p>").addClass("res clearfix");
                    $("#np").before(div);
                    if(page == 1){//第一页的时候，淡入，之后就没有必要了
                        $("#info").fadeIn().animate({
                            width:"290px",
                            "min-width":"290px"
                        },{queue:false,duration:"slow"});
                    }
                }else{
                    $.alet("没有对应结果");
                }
            }
    })
}
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
    },3999);
}
function addInfo (data,userId) {
    //根据用户信息添加悬浮框的函数
    function ComplexCustomOverlay(point){
      this._point = point;
    }
    var div,mark;
    ComplexCustomOverlay.prototype = new BMap.Overlay();
    ComplexCustomOverlay.prototype.initialize = function(map){
        this._map = map;
        div = this._div = document.createElement("div");
        $(div).css({
            "zIndex":BMap.Overlay.getZIndex(this._point.lat),
            background:"#193047",
            padding:"2px",
            color:"#D1D1D1",
            lineHeight:"18px",
            whiteSpace:"nowrap",
            fontSize:"1em",
            position:"absolute",
            "border-radius":"2px",
            width:"250px",
            display:"none"
        }).addClass("arrow").attr("id",userId);
        $(div).append("<a class = 'thumb' href = '"+site_url+"/space/index/"+userId+"'><img class = 'layImg' src = '"+base_url+"upload/"+data["user_photo"]+"' /></a><a href = '"+site_url+"/space/index/"+userId+"' ><p>店家:"+data["user_name"]+"</p></a><p><a class = 'mess' href = '"+site_url+"/message/write/"+userId+"' >站内信联系</a></p><p>电话:"+data["contract1"]+"</p>");
        if(data["email"]){
            $(div).append("<p>邮箱:"+data["email"]+"</p>");
        }
        if(data["contract2"]){
            $(div).append("<p>QQ:"+data["contract2"]+"</p>");
        }
        map.getPanes().labelPane.appendChild(div);
        return div;
    }
    var markeOpt = {//标注的样式和属性初始化
        title:data["user_name"]
     }
    ComplexCustomOverlay.prototype.draw = function(){
      var map = this._map;
      var pixel = map.pointToOverlayPixel(this._point);
      this._div.style.left = pixel.x -14 + "px";
      this._div.style.top  = pixel.y+ "px";
      mark = new BMap.Marker(this._point,markeOpt);//这里添加事件,通过delegate实现
      mark.addEventListener("click",function  () {
        $(div).fadeToggle();
      })
      map.addOverlay(mark);
      console.log(mark);
    }
    var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(data["lng"],data["lat"]));
    map.addOverlay(myCompOverlay);
    return mark;
}
function fConIdMark () {
    //使用conidmark的函数，也是控制左边内容和右边窗口标注
    var mark;
    $("#info").delegate("li","mouseenter",function  () {
        mark = $(this).attr("name");
        mark = conIdMark[mark];
        if(mark)
        {
            console.log(mark);
            mark.setAnimation(BMAP_ANIMATION_BOUNCE);
            setTimeout(function  () {
                mark.setAnimation(null);
            },100);//一直跳觉得有点讨厌，这里跳两下停止
        }
    })
}
