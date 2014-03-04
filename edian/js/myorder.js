/**
 * @name        ../../js/myorder.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-27 20:48:44
*/
$(document).ready(function () {
    showStore();
    login();
    add();
    star();
    lineScore();
})
/**
 * 通过线滑动给分
 */
function lineScore() {
    var doc = document;
    var line = $("#line");

    var last = null;
    $("#cart").delegate('.point' , 'mousedown', function () {
        var point = this;
        var le = $(point).siblings(".le");
        var ri = $(point).siblings(".ri");
        //var ri = $().find(".ri");
        var len = $(line).width();
        $(doc).mousemove(function (event) {
            console.log(last);
            if(last){
               var dis =  event.clientX - last;
               var width = Math.min($(le).width() + dis , len);
               $(le).width(width);
               $(ri).width(len - width);
            }
            last = event.clientX;
        })
    })
    $(doc).mouseup(function () {
        $(doc).unbind("mousemove");
    })
}
/**
 * 对店铺进行评论
 */
function showStore() {
    $("#cart").delegate(".re" ,  'click' ,function () {
        $(this.parentNode).find(".reply").fadeToggle();
    })
}
function star() {
    //鼠标划过星星，更改状态和修改对应的数值
    $("#cart").delegate('.star' , 'mouseenter' , function () {
        var stars = $(this.parentNode).find(".star");
        var len = parseInt($(this).attr('name') , 10);
        $(this.parentNode).find("input[name = 'score']").val(len);
        for (var i = 0; i <= len; i ++) {
            $(stars[i]).removeClass("fa-star-o").addClass('fa-star');
        }
        for (l = len+1 ,len = stars.length; l < len;l++) {
            $(stars[l]).removeClass("fa-star").addClass('fa-star-o');
        }
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
