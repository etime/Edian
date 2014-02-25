/**
 * @name        ../../js/home2.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-22 12:47:26
*/
$(document).ready(function () {
    login();
    itemToggle();
})
function itemToggle() {
    var lis = $("#itemLi");
    lis.delegate("li" , 'click' , function (event) {
        lis.find(".chose").removeClass('chose');
        $(this).addClass("chose");
    })
}
