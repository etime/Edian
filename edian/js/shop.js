/**
 * @name        ../js/shop.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-01-04 16:30:23
*/
//设置list的宽度和高度
function funList() {
    var sideWidth = $("#side").width();
    $("#list").width(sideWidth);
}
/**
 * 确定topbar的位置和列表的位置
 */
function fixpos() {
    funList();
    var win = window;
    console.log("abc");
    console.log(win);
    var headHeight = $("#header").height();
    console.log(headHeight);
    var nav = $("#nav"),list = $("#list");
    $(win).scroll(function () {
        var top = $(win).scrollTop();
        console.log(top);
        if(top < headHeight){
            var cls = nav.attr("class");
            console.log(cls);
            if(cls.indexOf('navfix') !== -1){
                nav.removeClass("navfix");
                list.removeClass('listfix')
                console.log("remove fix");
            }
        }else if(top > headHeight){
            var cls = $("#nav").attr("class");
            if(cls.indexOf('fix') === -1){
                nav.addClass('navfix');
                list.addClass('listfix')
                console.log("add fix");
            }
        }
    })
}
$(document).ready(function () {
    fixpos();
})
