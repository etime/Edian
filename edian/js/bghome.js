/**
 * @name        ../../js/bghome.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-01-20 03:33:38
 */
$(document).ready(function () {
    toggleLi();
})
/**
 * 侧边栏的显示和切换控制，
 */
function toggleLi() {
    var side = $('#side');
    var href = window.location.href.split("#");
    console.log(href);
    if(href.length === 2  && href[1]){
        var node = side.find('li[name = ' + href[1] +']');
        $('iframe').attr('src' , $(node[0].parentNode).attr('href'));
        side.find('.liCse').removeClass('liCse');
        side.find('li[name = ' + href[1] +']').addClass("liCse");
    }
    side.delegate("li", 'click' , function () {
        var name = $(this).attr("name");
        side.find('.liCse').removeClass('liCse');
        side.find('li[name = ' + name +']').addClass("liCse");
        href = window.location.href;
        href = href.split('#');
        window.location.href = href[0] + '#' + name;
    })

}
