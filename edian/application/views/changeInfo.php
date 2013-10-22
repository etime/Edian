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

<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var base_url = "<?php echo base_url()?>";
var	user_name="<?php echo $this->session->userdata('user_name')?>";
var	user_id="<?php echo $this->session->userdata('user_id')?>";
</script>
</head>
<body>
	<div id="content"  class = "clearfix">
		<form action="<?php echo site_url("reg/change")?>" method="post" enctype = "multipart/form-data" accept-charset="utf-8">
			<p>用户名：<input type="text" name="userName" value = "<?php echo $user_name?>"/><span id = "name"></span></p>
			<p>密码：<input type="password" name="passwd" /><span id = "pass"></span></p>
			<p>确认密码：<input type="password" name="repasswd" /></p>
			<p>联系方式(手机,电话)：<input type="text" name="contra"  value = "<?php echo $contract1?>"/><span id = "contra"></span></p>
			<p>图片验证码：<input type = "text" id = "incheck" name = "checkcode"/><img id = "check" src="<?php echo site_url('checkcode/index')?>"><span id = "spanCheck"></span></p>
			<p id = "utype">用户类型:<input type="radio" id = "shop" name="type" value="1" <?php if($user_type  == 1)echo "checked=checked"?>/>开店<input type="radio" name="type" value="2" <?php if($user_type  == 2)echo "checked=checked"?>/>买家<span class = "safe" id = "typeatten">只可以在二手专区销售物品</span></p>
			<div id = "map" <?php if($user_type == 2)echo "style = display:none" ?> ><p>商店位置:<span>通过定位，我们可以更好的将您的店推荐给您附近的买家</span></p>
				<input type="hidden" name="pos" id = "pos" value="<?php echo $lng.';'.$lat?>"/>
				<div id = "allmap"></div>
			</div>
			<p>QQ(可选)：<input type="text" name="contra2" value = "<?php echo $contract2?>"/></p>
			<p>地址(可选)：<input type="text" name="add" value = "<?php echo $addr; ?>"/><span id = "add"></span></p>
			<p>头像(可选)：<input type="file" name="userfile" /><span id = "photo">本次不上传，默认采用原来头像</span></p>
			<p>邮箱(可选)：<input type="text" name="email" value = "<?php echo $email?>"/><span id = "email"></span></p>
			<p>口号^.^(可选):</p> 
			<p><textarea name="intro" rows="8" cols="40"><?php echo $intro?></textarea></p>
			<p class = "center"><input type="submit" name="sub" value="提交"/></p>
		</form>
	</div>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/jquery.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/cookie.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/change2.js')?>"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=672fb383152ac1625e0b49690797918d"></script>
</body>
</html>
