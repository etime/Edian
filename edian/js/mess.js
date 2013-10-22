/*************************************************************************
    > File Name :  ../js/mess.js
    > Author  :      unasm
    > Mail :         douunasm@gmail.com
    > Last_Modified: 2013-08-07 20:13:20
 ************************************************************************/
/*
 * 这个函数是存放发送站内新的js函数，之前的辛苦，现在用不上了，也不想白费
 */
function mess () {
    //message 发送站内信
    var temp = "<form class = 'block msgA' action = "+site_url+"/message/add method = 'post' accept-charset = 'utf-8'><input type = 'text' name = 'title' class = 'msgt' placeholder = '标题'/><input type = 'button' name = 'cc' value = '取消'/>";
    var left = "<input type = 'submit' name = 'sub' value = '发送'/><textarea name = 'cont' placeholder = '内容...'></textarea></form>";
    var reg = /\d+\/?/,name,id,msga,flag;
    $("#cont").delegate(".mess","click",function  (event) {
        if(msga){
            flag = msga;
            flag.fadeOut();
        }
        name = this.name;
        id = reg.exec(this.href);
        if(id)id = id[0];
        var fat = this.parentNode.parentNode;
        msga = $(fat).siblings(".msgA");
        if(msga.length){
            msga.fadeIn();
        }else{
            $(fat).before(temp+"<input type = 'text' name = 'geter' value = "+name+"("+id+")"+">"+left) ;
            msga = $(fat).siblings(".msgA");
        }
        event.preventDefault();
    }).delegate("input","click",function  (event) {
        var tp = event.target.type;
        if(tp === "button"){
            flag = msga;
            flag.fadeOut();
            msga = null;
        }else if(tp === "submit"){
            var tit = $.trim($(this).siblings("input[name = 'title']").val());
            var geter = $.trim($(this).siblings("input[name = 'geter']").val());
            var text = $($(this).siblings("textarea")).val();
            return;
            if(tit.length == 0){
                $.alet("标题是要有的哦");
                return false;
            }
            var fater = this.parentNode;
            var url = fater.action+"/1";
            $.ajax({
                url:url,dataType:"json",type:"POST",timeout:2000,
                data:{"geter":geter,"cont":text,"title":tit},
                success:function  (data) {
                    (data == "1")?$.alet("发送成功"):$.alet(data);
                }
            })
            $(fater).css("display","none");//发送完毕隐藏
        }
        event.preventDefault();
    })
}
