<!DOCTYPE html>
<html lang = "en">
<head>
<?php
    $siteUrl = site_url();
    $baseUrl = base_url();
?>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8"/>
    <title><?php echo "写信"?></title>
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/messwrite.css')?>" type="text/css" charset="UTF-8">
<link rel="icon" href="logo.png" type="text/css">
<script type="text/javascript" src = "<?php echo $baseUrl.('js/jquery.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/cookie.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/messwrite.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/xheditor.min.js')?>"></script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/zh-cn.js')?>"></script>

<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var user_name="<?php echo $this->session->userdata('user_name')?>";
var user_id="<?php echo $this->session->userdata('user_id')?>";
$(pageInit);
function pageInit()
{
    $.extend(XHEDITOR.settings,{shortcuts:{'ctrl+enter':submitForm}});
    $('#cont').xheditor({upImgUrl:site_url+"/write/imgAns?immediate=1",upImgExt:"jpg,jpeg,gif,png"});
}
function insertUpload(arrMsg)
{
    var i,msg;
    for(i=0;i<arrMsg.length;i++)
    {
        msg=arrMsg[i];
        $("#uploadList").append('<option value="'+msg.id+'">'+msg.localname+'</option>');
    }
}
function submitForm(){$('#frmDemo').submit();}
</script>
<body class = "clearfix">
    <div id="dir" class = "leaft">
        <p id = "atten" class = "tt"></p>
        <p class = "dire tt"></p>
<!--
        <input id = "search" class = "ip" value = "搜索" name = "search">
        <p class = "dire"></p>
-->
        <ul id = "dirUl">
            <a class = "mail" href = "<?php echo site_url("message")?>"><li style = "border-radius:5px 5px 0px 0px" class="dirmenu" >收件箱<span ></span></li></a>
            <a class = "mail" href = "<?php echo site_url('message/sendbox')?>"><li class="dirmenu" >发件箱<span ></span></li></a>
            <a  style = "border-radius:0 0 5px 5px" href = "<?php echo site_url('message/write')?>"><li  class="liC" >写信<span  class = "tran"></span></li></a>
        </ul>
    </div>
    <div id="content" class="contSpace">
        <form action="<?php echo site_url('message/add')?>" method="post" enctype = "multipart/form-data" accept-charset="utf-8">
                <p class = "clearfix">
                    <span class = "reman">标题:</span><input type="text" class = "tit" name="title"/>
                    <input type="submit" class = "button" value="发送">
                </p>
                <p class = "clearfix">
                    <span class = "reman">收件人:</span>
                    <input type="text"  class = "tit" name="geter" value = "<?php if(isset($id))echo $name.'('.$id.')';?>">
                </p>
            <textarea id="cont" name="cont" style="">
            </textarea>
        </form>
    </div>
</body>
</html>
