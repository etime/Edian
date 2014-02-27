/**
 * @name        ../../../js/histOrder.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-13 13:47:40
*/

/**
 * 拒绝订单和恶意订单的回复显示区域
 */
function refuse() {
    $("#list").delegate(".buyer" , 'click' , function (event) {
        var name = $(event.target).attr("name");
        //这个有个缺陷就是一旦其他的有name就会出bug
        if(name && $(event.target).prop("tagName") == 'A'){
            $(this).find('.' + name).slideToggle();
            event.preventDefault();
        }
    })
}
$(document).ready(function () {
    refuse();
    //这里控制的是详细信息的显示隐藏
    $("#list").delegate("font","click",function (event) {
        var target = event.target;
        var name = $(target).attr('class');
        target = findLi(target);
        if(name === 'down'){
            $(target).find(".buyer").slideUp();
            $(event.target).removeClass("down").addClass("up");
        } else if(name === 'up'){
            $(target).find(".buyer").slideDown();
            $(event.target).removeClass("up").addClass("down");
        }
    })
    function findLi(node) {
        while(node && $(node).prop('tagName') != 'LI'){
            node = node.parentNode;
        }
        return node;
    }
})
