/**
 * 这里是作为店铺的js处理的函数进行的
 * @name        ../js/shop.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-01-04 16:30:23
*/
/**
 * 确定topbar的位置和列表的位置
 */
function fixpos() {
    var win = window ,headHeight = $("#header").height() , nav = $("#nav");
    $(win).scroll(function () {
        var top = $(win).scrollTop();
        if(top < headHeight){
            if(nav.attr("class").indexOf("navfix") !== -1 ){
                nav.removeClass("navfix");
            }
        }else if(top > headHeight){
            if(nav.attr("class").indexOf("navfix") === -1 ){
                nav.addClass('navfix');
            }
        }
    })
}
/**
 * 根据约定，以#结尾的链接不可以点击
 */
function pageDisable() {
    $('.snav').delegate('a' , 'click', function (event) {
        var href = $.trim ($(this).attr("href") );
        if(href[href.length -1] == '#'){
            event.preventDefault();
        }
    })
}

/**
 * 控制icart的显示和隐藏
 * 前提要求，所有需要隐藏显示的都必须由icart包裹，所有商品列表由itemlist控制
 */
function iCartShow() {
    $("#itemList").delegate('li' , 'mouseenter' , function () {
        $(this).find(".icart").css("display", 'block');
    }).delegate('li' , 'mouseleave' , function () {
        $(this).find('.icart').css('display' , 'none');
    })
}
/**
 * 显示营业时间
 * @todo 需要讨论怎么显示不再营业时间里面
 */
function bustime() {
    //添加必要的时间
    var bus = $("#busVal");
    var str = bus.attr('alt');
    str = str.split('&');
    var html = "";
    for (var i = 0, l = str.length; i < l; i ++) {
        html+="<li>" + str[i] + "</li>";
        str[i] = str[i].split('-');
        str[i][0] = str[i][0].split(":");
        str[i][1] = str[i][1].split(":");
    }
    /*
     * 检查时间，判断时候在营业时间内
     * 获得本地的时间"2013-4-6 20:27:32"的形式
     * @return flag为0的时候是在营业时间里面
     */
    function checkTime() {
        var time=new Date();
        var hour = time.getHours()
        var min = time.getMinutes()
        var flag = 1;
        for (var i = 0, l = str.length; i < l; i ++) {
            if(equel(str[i][0] , true  , hour ,  min) && equel(str[i][1] , false , hour , min)){
                flag = 0;
                break;
            }
        }
    }
    /**
     * 对比当前时间的大小
     * @param {array}   arr     时间的数组
     * @param {flag}    flag    比大还是比小的标志位
     * @param {int}     hour    小时
     * @param {int}      min    分钟
     */
    function equel(arr , flag , hour ,min) {
        if(arr[0] < hour){
            return flag;
        } else if(arr[0] == hour && arr[1] < min){
            return flag;
        }
        return !flag;
    }
    checkTime();
    bus.append(html);
    //控制下单
}
/**
 * 显示地图，
 * @param {int} storeid  在.php页面，通过php传入的数值
 */
function showMap() {
    var flag = 1;
    $("#mapImg").dblclick(function () {
        if(flag){
            flag = 0;
            $("body").append("<div id = 'map' style = 'display:none'><a class = 'close' href = 'javascript:;'></a><iframe src = '" + site_url +'/shop/storeMap/' + storeId + "'></iframe></div>");
        }
        $("#map").fadeIn();
    });

    //对所有的close进行监听，必须使用懒加载的方式，
    $("body").delegate(".close","click",function () {
        $(this.parentNode).fadeOut();
    })
}
$(document).ready(function () {
    fixpos();
    showMap();
    pageDisable();
    iCartShow();
    bustime();
})
