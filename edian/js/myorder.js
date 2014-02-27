/**
 * @name        ../../js/myorder.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-27 20:48:44
*/
$(document).ready(function () {
    showStore();
})
/**
 * 对店铺进行评论
 */
function showStore() {
    $("#cart").delegate(".re" ,  'click' ,function () {
        $(this.parentNode).find(".reply").fadeToggle();
    })
}
