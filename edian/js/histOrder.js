/**
 * @name        ../../../js/histOrder.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-13 13:47:40
*/
$(document).ready(function () {
        console.log("yes");
    $("#list").delegate("li","click",function (event) {
        console.log(event.target);
        var name = $(event.target).attr('class');
        if(name === 'down'){
            $(this).find(".buyer").slideUp();
            $(event.target).removeClass("down").addClass("up");
        } else if(name === 'up'){
            $(this).find(".buyer").slideDown();
            $(event.target).removeClass("up").addClass("down");
        }
    })
    refuse();
})
/**
 * 拒绝订单和恶意订单的回复显示区域
 */
function refuse() {
    $("#list").delegate(".buyer" , 'click' , function (event) {
        console.log(event.target);
        var name = $(event.target).attr("name");
        //这个有个缺陷就是一旦其他的有name就会出bug
        if(name){
            $(this).find('.' + name).slideToggle();
            event.preventDefault();
        }

    })
}
