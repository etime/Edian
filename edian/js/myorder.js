/**
 * @name        ../../js/myorder.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-27 20:48:44
*/
$(document).ready(function () {
    showStore();
    login();
    add();
})
/**
 * 对店铺进行评论
 */
function showStore() {
    $("#cart").delegate(".re" ,  'click' ,function () {
        $(this.parentNode).find(".reply").fadeToggle();
    })
}

/**
 * 向数据库添加数据
 */
function add() {
    $("#cart").delegate('form' , "submit" , function (event) {
        var inputs = $(this).find("input[type = 'text'] , textarea");
        var str = '{';
        for ( l = inputs.length , i = l-1; i >=0; i --) {
            var val = $.trim($(inputs[i]).val());
            if(!val) {
                alet("请补全信息后评论");
                return false;
            }
            if(i !== 0){
                str += $(inputs[i]).attr('name') + ":" + $(inputs[i]).val() +',';
            } else {
                str += $(inputs[i]).attr('name') + ":" + $(inputs[i]).val() ;
            }
        }
        str += '}';
        debugger;
        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',dataType: 'json',data: str,
            success: function (data, textStatus, jqXHR) {
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
            }
        });
        event.preventDefault();
    })
}
