<?php
/*************************************************************************
    > File Name :     login.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-06-04 02:28:15
 ************************************************************************/
	$siteUrl = site_url();
	$baseUrl = base_url();
?>
<html lang = "en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"0>
	<title>登录</title>
	<link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
<style type="text/css" media="screen">
	body,html{
		height:100%;
		background:#000;
		background:-webkit-linear-gradient(left,#000, #272727,#000);
		font:15px/1.5 tahoma,arial,宋体b8b体4f53;
		text-align:center;
		color:#189779;
	}
	form{
		margin:0px auto;
	}
	input{
		box-shadow:0 1px 0 rgba(255, 255, 255, .08), 0 1px 4px rgba(0, 0, 0, .3) inset;
		border-radius:5px;
		padding:5px;
		border:none;
	}
</style>
</head>
<body>
	<h1>E点，悠闲生活</h1>
	<form id = "ent" action="<?php echo $siteUrl.('/reg/dc')?>" method="post" accept-charset="utf-8" >
		<p>用户名:<input type="text"  class = "valTog" name="userName" id = "userName"></p>
		<p>密码:<input type="password" class = "valTog"  name="passwd" id = "passwd"></p>
		<input  class = "butCol  et" type="submit" name="enter" value="登录"/>
        <input type="hidden" name="target" value=" <?php echo @$url ?>" />
	</form>
</body>
</html>
