/**
 * @name        ../../js/bghome.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-01-20 03:33:38
*/
$(document).ready(function () {
    var side = $("#side");
    side.delegate('li' , 'click', function () {
        console.log("rese");
        side.find(".liCse").removeClass("liCse");
        $(this).addClass("liCse");
    })
})
