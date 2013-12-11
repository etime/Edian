/**
 * 这里对应的是view/bgHomeSet.php
 * @name        bgSet.js
 * @since       2013-12-09 10:53:35
 * @author      unasm<1264310280@qq.com>
 */
/* 地图的对象，*/
var objMap;
/** 百度地图的操作集中 */
function testMap() {
    var map = new BMap.Map("allmap");
    var $this = this;
    $this._point = null;
    $this._dist = $("#distance").val();
    //设置图标的样式;
    var Icon = new BMap.Icon(baseUrl + "bgimage/elogo.png",new BMap.Size(64,64));
    var mkopt = {
        icon:Icon,
        title:"您的店铺位置",
        raiseOnDrag:true,       //拖拽的时候的效果设定
        enableDragging:true     //默认启用拖拽
    }
    var circleOpt = {
        fillColor:"#00f",
        fillOpacity:0.2,
        strokeOpacity:0,
        strokeWeight:"0px"
    }
    //给出一个默认的位置，然后试图去定位
    setPoint( new BMap.Point(103.940, 30.759532) );
    // 对地图的初始化
    map.enableScrollWheelZoom();                            //启用滚轮放大缩小
    map.enableInertialDragging();
    map.enablePinchToZoom();//双指缩放
    map.enableAutoResize();

    //对地图的定位
    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function(location){
        if(this.getStatus() == BMAP_STATUS_SUCCESS){
            console.log("yes");
            setPoint(location.point);
        } else {
            console.log("failed");
            //reportBug("百度地图出现bug，无法定位,错误代码为:" + this.getStatus());
        }
    },{enableHighAccuracy: true})
    var maker,circle;
    $("#but").click(function () {
        if(circle){
            $this._dist = $("#distance").val();
            circle.setRadius($this._dist);
        }
    })
    //when change point
    function setPoint( point ) {
        $this._point = point;
        mk = null;
        mk = new BMap.Marker(point , mkopt);
        map.centerAndZoom(point, 15);
        map.clearOverlays();    //清除之前的marker
        map.addOverlay(mk);
        map.panTo(point);
        circle = new BMap.Circle(point ,$this._dist , circleOpt);
        map.addOverlay( circle );
        mk.addEventListener("dragend",function (event) {
            //可以拖拽，确定店家的位置
            //$this._point = event.point
            setPoint(event.point);
        })
        mk.addEventListener("dragging",function (event) {
            setTimeout(function() {
                //setPoint(event,point)
                circle.setCenter(event.point);
            }, 100);
        })
    }

    //use when want to change by rightclick
    var textMenu = [{   text:"放大",
            callback:function () {
                map.zoomIn();
            }
        },{
            text:"缩放",
            callback:function () {
                map.zoomOut();
            }
        },{
            text:"我的店在这里",
            callback:function (p) {
                setPoint(p);
            }
        }]
    var contextMenu = new BMap.ContextMenu();
    for (var i = 0, l = textMenu.length; i < l; i ++) {
        contextMenu.addItem( new BMap.MenuItem(textMenu[i].text , textMenu[i].callback,100));
        contextMenu.addSeparator();
    }
    map.addContextMenu(contextMenu);
}
/**
 * 过滤掉不允许输入的字符
 * 所有的特殊字符都去掉了，除了一个-,45号,40,41号对应的是()
 */
function keydel() {
    var arr = [32 ,33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 46, 47, 58, 59, 60, 61, 62, 63, 64, 91, 92, 93, 94, 95, 96 ,123, 124, 125, 126] ;
    //特殊符号对应的keyCode
    $("body").delegate("input[type = 'text']","keypress",function (event) {
        var key = event.keyCode;
        console.log(key);
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
    var cnt = 0;
    $("#addTime").click(function () {
        var dlast = $(".dtime").last();
        $("#tarea").append($(dlast).clone());
        cnt++;
        if( cnt == 2 ){
            $(this).css("display","none");
            //清空内存
            select = null;
            lstTime = null;
            Dtime = null;
        }
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
