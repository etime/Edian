/**
 * @name        ../../js/storeMap.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-01-13 19:51:11
*/
/**
 * @param {node} longtitude  从input name = longtitude 那里获取的值
 * @param {node} latitude    从input name = latitude   那里获取的值
 * @param {node} dist        从input name = dist       那里获取的送货距离
 */
function objMap() {
    var map  = new BMap.Map("allmap");
    var lng  = $.trim($("input[name = 'longitude']").val());
    var lat  = $.trim($("input[name = 'latitude']").val());
    var dist = $("input[name = 'dist']").val();

    //设置图标的样式;
    var Icon = new BMap.Icon(baseUrl + "bgimage/elogo.png",new BMap.Size(64,64));
    var mkopt = {
        icon:Icon,
        title:"您的店铺位置",
        raiseOnDrag:true,       //拖拽的时候的效果设定
        enableDragging:true     //默认启用拖拽
    };
    var circleOpt = {
        fillColor:"#00f",
        fillOpacity:0.2,
        strokeOpacity:0,
        strokeWeight:"0px"
    };
    //when change point
    function setPoint( point ) {
        var mk = new BMap.Marker(point , mkopt);
        map.centerAndZoom(point , 14);
        map.clearOverlays();    //清除之前的marker
        map.addOverlay(mk);
        map.panTo(point);
        circle = new BMap.Circle(point , dist, circleOpt);
        map.addOverlay( circle );
        mk.addEventListener("dragend",function (event) {
            //可以拖拽，确定店家的位置
            //$this._point = event.point
            setPoint(event.point);
        });
        mk.addEventListener("dragging",function (event) {
            setTimeout(function() {
                //setPoint(event,point)
                circle.setCenter(event.point);
            }, 100);
        });
    }
    var longtitude = $.trim($("input[name = 'longitude']").val());
    var latitude =  $.trim($("input[name = 'latitude']").val());
    if(longtitude && latitude){
        setPoint( new BMap.Point(longtitude, latitude) );
    }else {
        setPoint( new BMap.Point(103.940, 30.759532) );
    }
    //给出一个默认的位置，然后试图去定位
    // 对地图的初始化
    map.enableScrollWheelZoom();                            //启用滚轮放大缩小
    map.enableInertialDragging();
    map.enablePinchToZoom();//双指缩放
    map.enableAutoResize();

}
$(document).ready(function () {
    objMap();
})
