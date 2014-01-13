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
function showMap() {
    var flag = 1;
    //利用逗号表达式吗?,看起来更优雅
    //获取storeId
    var reg = /\d+$/ , storeId = reg.exec(window.location.href) , storeId = storeId[0];
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
})
