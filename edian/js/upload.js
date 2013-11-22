$(document).ready(function(){
    $("#textintro").focus(function  () {
        if(this.value == "")
        $("#spanintro").fadeOut();
    });
    $("#file").change(function  () {
        var size = $(this)[0].files[0].size/1000;
        size = parseInt(size*10)/10;
        if(size > 2000){
            $("#showsize").text(size+"KB,超过2M会导致上传失败,请压缩后上传");
            $("#showsize").css("color","red");
        }
        else{
            var reg = /.(png|jpg|jpeg|gif)$/i;
            if(!reg.exec(this.value)){
                $("#showsize").text("支持png，jpg，gif格式图片，其他的文件会上传失败");
            }else {
                if(this.value.length> 100){
                    $("#showsize").text("文件名太长了，请重命名后上传");
                    $("#showsize").css("color","red");
                }else{//放弃在js判重，因为觉得有点蛋疼，还是抓当紧的吧
                $("#showsize").text("没有问题，可以上传");
                $("#showsize").css("color","green");
                }
            }
        }
    });
    keyAdd();
})
/**
 * 添加关键字的处理
 */
function keyAdd(){
    var _keys = $("#keys"),_key = $("#key");
    _key.focus(function(){
        $(window).keypress(function (event) {
            console.log(event.which);
            if(event.which == 32 || event.which == 13){
                var value = _key.val();
                _key.val("");
                addkeySpan(value);
                return false;
            }
            if(event.which == 96)return false;
            if(event.which == 42)return false;//*
            if(event.which == 92)return false;// 反斜线\
            if((event.which < 40)&&(event.which > 33))return false;
            if(event.which < 63 && (event.which > 58))return false;
            if(event.which < 126 && event.which > 122)return false;

        })
    }).blur(function () {
        addkeySpan(_key.val());
        _key.val("");
        $(window).unbind("keypress");
    })
    _keys.delegate("span","click",function () {
        $(this).remove();
    })
    function addkeySpan(value) {
        if(value)
        _keys.append("<span>"+value+"</span>");
    }
    $("form").submit(function () {
        var kspan = _keys.find("span");
        var keyBuf = "";
        for (var i = 0, l = kspan.length; i < l; i ++) {
            keyBuf += ((i == 0)?"":";") + $(kspan[i]).text();
        }
        _key.val(keyBuf);
        return false;
    });
}
