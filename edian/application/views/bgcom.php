<?php
/*************************************************************************
    > File Name :     ../../views/bgcom.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-23 03:37:34
 ************************************************************************/
$siteUrl = site_url();
$baseUrl = base_url();
if($com)$len = count($com);
else $len = 0;
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>后台评论查看页面</title>
    </head>
    <body>
        <table border="1">
            <tr>
                <th>评分</th>
                <th>详情</th>
                <th>主题</th>
            </tr>
            <tbody>
                <?php for($i = 0;$i < $len;$i++):?>
                <tr>
                    <td style = "text-align:center;font-size:1.6em;color:#B90101;">
                        <?php
                        $comi = $com[$i];
                        echo $comi["score"];
                        ?>
                    </td>
                    <td>
                    <?php
                        $lenj = count($comi["context"]);
                        $cont = $comi["context"];
                        for($j = 0;$j < $lenj;$j++){
                            if($type == $ADMIN){
                                echo "<form action = '".$siteUrl.'/bg/item/checom/'."$comi[id]/$j"."' enctype = 'multipart/form-data' method = 'post' accept-charset = 'utf-8'>".
                                    "<span>".$cont[$j]["user_name"]."</span>".
                                    "<textarea name = 'cont'>".$cont[$j]["context"]."</textarea>".
                                    "<span>".$cont[$j]["time"]."</span>".
                                    "<span class = 'oper' name = '".$cont[$j]["user_name"]."'>站内信</span><input type = 'submit' class = 'oper' name = 'cge' value = '修改'/></form>";
                            }else{
                                echo "<p><span>".$cont[$j]["user_name"]."</span><span>".$cont[$j]["context"]."</span><span>".$cont[$j]["time"]."</span><span class = 'oper' title = '可以给评论的人发送信件联系' name = ".$cont[$j]["user_name"].">站内信</span></p>";
                            }
                        }
                    ?>
                    </td>
                    <td>
                        <a href = "<?php echo $siteUrl.'/item/index/'.$comi["item_id"] ?>"> <?php echo $comi["title"] ?></a>
                    </td>
                </tr>
                <?php endfor ?>
            </tbody>
        </table>
        <div id = "msgA" class = "block" style = "display:none">
            <!------发送站内心的框------>
            <form action="<?php echo site_url('message/add')?>" method="post" accept-charset="utf-8">
                <input type="text" name="title" id = "msgt" />
                <input type="button" name="cc" id = "cc" value="取消"/>
                <input type="text" name="geter" value=""/>
                <input type="submit" name="sub" value="发送"/>
                <textarea id = "cont" name="cont"></textarea>
            </form>
        </div>
    </body>
<style type="text/css" media="all">
    table{
        width:100%;
        border-spacing:0;
        border-color:#fff;
    }
    .oper{
        float:right;
    }
    td span{
        margin-right:20px;
    }
/***************是msga模块***************/
#msgA{
	width:272px;
    /*
	position:absolute;
    */
	overflow:hidden;
	padding:2px;
	background:none repeat scroll 0% 0% rgb(0,0,0);
    position:fixed;
    top:0;
    bottom:0;
    left:0;
    right:0px;
    height:220px;
    border-radius:3px;
    margin:auto;
}
#msgA textarea{
	position:relative;
	z-index:1;
	/*修补其他的不被覆盖的bug
	*/
    width:260px;
	height:150px;
	padding:5px;

}
#msgA p{
	margin:-20px 0 0 15px;
	color:#818181;
}
#msgA input{
	padding:3px 18px 3px 10px;
}
/***************msga结束********************/
</style>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/jquery.js') ?>" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
jQuery.alet = function (cont) {//给出各种提示的函数，和alert不同，这个过1s就消失
	var alet = document.createElement("div");
	var p = document.createElement("p");
	var css = {
		width:'200px'
	};
	$(alet).css(css);
	css = {
		position:'absolute',
		padding:'15px',
		background:'#000',
		top:$(window).scrollTop()+100+"px",
		left:$(document).width()/2-100+"px",
		margin:'0 auto',
		"border-radius":"5px",
		color:"white",
		"z-index":"20"
	}
	$(p).css(css);
	$(p).text(cont);
	$(alet).append(p);
	$("body").append(alet);
	setTimeout(function  () {
		$(alet).detach();
	},3999);
}
var msgA = $("#msgA");
$("#msgA form").submit(function  (event) {
        var tit = $.trim($(this).find("input[name = 'title']").val());
        var geter = $.trim($(this).find("input[name = 'geter']").val());
        var cont = document.getElementById("cont");
        cont = $.trim(cont.value);
        if(tit.length == 0){
            $.alet("标题是要有的哦");
            return false;
        }
        var url = this.action+"/1";
        $.ajax({
            url:url,dataType:"json",type:"POST",
            data:{"geter":geter,"cont":cont,"title":tit},
            success:function  (data) {
                (data == "1")?$.alet("发送成功"):$.alet(data);
            }
        })
    $("#msgA").fadeOut();
    return false;
})
var geter = msgA.find("input[name = 'geter']");
$(".oper").click(function(){
    msgA.fadeIn();
    geter.val($(this).attr("name"));
})
$("#cc").click(function(){
    msgA.fadeOut();
})
</script>
</html>
