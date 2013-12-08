/**
 * 这个文件是为了开发期间的报错使用的,针对各种意外情况的处理
 * @name        ../../js/debug.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2013-12-08 13:56:17
*/
/**
 * 向后台报告出现的bug
 * 不需要返回处理
 */
function reportBug(str) {
    $.ajax({
        url: site_url+"/wrong/index",type: 'POST',data:  {"text":str},
        success: function (data, textStatus, jqXHR) {
            console.log(data);
            console.log(jqXHR);
        }
    });
}
