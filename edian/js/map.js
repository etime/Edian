/*************************************************************************
    > File Name :  ../js/map.js
    > Author  :      unasm
    > Mail :         douunasm@gmail.com
    > Last_Modified: 2013-06-25 10:40:03
 ************************************************************************/
/*
 * 这里对应的是reg的js
 * 地图的宽度不能太小，就li的宽度吧，放缩的比例值为18
 */
var mp = new BMap.Map("allmap");
mp.centerAndZoom(new BMap.Point(116.3964,39.9093), 15);
mp.enableScrollWheelZoom();
// 复杂的自定义覆盖物
