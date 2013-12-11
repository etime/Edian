$(document).ready(function(){
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
});
