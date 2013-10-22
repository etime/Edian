<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8">
    <title>注册</title>
    <link rel="stylesheet" href="<?php echo base_url('css/reg.css')?>" type="text/css" charset="UTF-8">
<?php
    $baseUrl = base_url();
?>
    <link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
<link rel="icon" href="logo.png" type="text/css">
<script type="text/javascript" src = "<?php echo $baseUrl.('js/jquery.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/cookie.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/reg.js')?>"></script>
<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var base_url = "<?php echo base_url()?>";
var user_name="<?php echo $this->session->userdata('user_name')?>";
var user_id="<?php echo $this->session->userdata('user_id')?>";
</script>
</head>
<body>
    <div id="content"  class = "clearfix">
        <form action="<?php echo site_url("reg/regSub")?>" method="post" enctype = "multipart/form-data" accept-charset="utf-8">
            <p>用户名<span class = "xx">*</span>：<input type="text" name="userName" /><span id = "name"></span></p>
            <p>密码<span class = "xx">*</span>：<input type="password" name="passwd" /><span id = "pass"></span></p>
            <p>确认密码<span class = "xx">*</span>：<input type="password" name="repasswd" /></p>
            <p id = "utype">用户类型<span class = "xx">*</span>:<input type="radio" id = "shop" name="type" value="1"/>开店<input type="radio" name="type" value="2" checked/>买家<span class = "safe" id = "typeatten">只可以在二手专区销售物品</span></p>
            <div id = "map" style = "display:none">
                <p class = "opertime">营业起止时间
                <!--精确到分钟，使用四个select-->
                    <span class = "xx">*</span>:
                    <select name = "opersth">
                        <?php
                            for($i = 0;$i<25;$i++){
                            if($i == 9){
                                echo "<option value = ".$i." Selected = 'Selected'>".$i."</option>";
                            }
                            else {
                                echo "<option value = ".$i.">".$i."</option>";
                            }
                        }
                        ?>
                    </select>:
                    <select name = "operstm">
                        <?php
                            for($i = 0;$i<60;$i++){
                            if($i == 0){
                                echo "<option value = ".$i." Selected = 'Selected'>".$i."</option>";
                            }
                            else {
                                echo "<option value = ".$i.">".$i."</option>";
                            }
                        }
                        ?>
                    </select>--
                    <select name = "operedh">
                        <?php
                            for($i = 0;$i<25;$i++){
                            if($i == 17){
                                echo "<option value = ".$i." Selected = 'Selected'>".$i."</option>";
                            }
                            else {
                                echo "<option  value = ".$i.">".$i."</option>";
                            }
                        }
                        ?>
                    </select>
                    :
                    <select  name = "operedm">
                        <?php
                            for($i = 0;$i<60;$i++){
                            if($i == 0){
                                echo "<option value = ".$i." Selected = 'Selected'>".$i."</option>";
                            }
                            else {
                                echo "<option value = ".$i.">".$i."</option>";
                            }
                        }
                        ?>
                    </select>
                </p>
                <p class = "opertime">经营范围<span class = "xx">*</span>:<input type = "text" name = "work" /><span>外卖,零食,超市等关键词,词之间空格隔开</span></p>
                <p>公告^.^(可选): <textarea type="text" name="intro" /></textarea></p>
                <p>商店位置<span class = "xx">*</span>:<span>通过定位，我们可以更好的将您的店推荐给您附近的买家</span></p>
                <input type="hidden" name="pos" id = "pos" value=""/>
                <div id = "allmap"></div>
            </div>
            <p>联系方式(手机)<span class = "xx">*</span>：<input type="text" name="contra" /><span id = "contra"></span></p>
            <p>QQ(可选)：<input type="text" name="contra2" /></p>
            <p>地址(可选)：<input type="text" name="add" /><span id = "add"></span></p>
            <p>头像(可选)：<input type="file" name="userfile" /><span id = "photo">小于5M的jpg,gif,png格式图片</span></p>
            <p>邮箱(可选)：<input type="text" name="email" /><span id = "email"></span></p>
            <p>图片验证码<span class = "xx">*</span>：<input type = "text" id = "incheck" name = "checkcode"/><img id = "check" src="<?php echo site_url('checkcode/index')?>"><span id = "spanCheck"></span></p>
            <p>短信验证码<span class = "xx">*</span>：<input type = "text" name = "smschk"/> <button id = "smschk">点击发送验证码</button></p>
            <p class = "tip">标有<span class = "xx">*</span>为必填内容，其他可选</p>
            <p class = "center"><input type="submit" name="sub" value="提交"/></p>
        </form>
    </div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=672fb383152ac1625e0b49690797918d"></script>
</body>
</html>
