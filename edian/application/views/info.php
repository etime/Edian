<!DOCTYPE html>
<html lang = "en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
<?php
	$siteUrl = site_url();
	$baseUrl = base_url();
?>
	<title><?php echo $name?></title>
	<link rel="icon" href="logo.png" type="text/css"> 
	<base href="<?php echo base_url()?>" >
	<link rel="stylesheet" href="<?php echo base_url('css/info.css')?>" type="text/css" media="screen" charset="utf-8">
</head>
<body>
	<!------------------header开始---------------------->
<?php
	$joke = array("空是一种境界","也是一门艺术","更是一门学问" );
	$index = 0;
?>
	<div id="header">
		<div class="content">
			<ul class = "clearfix">
			<a href = "<?php echo $siteUrl.('/mainpage/index')?>">
				<li>首页</li>
			</a>
			<a href = "<?php echo $siteUrl.('/space/index/'.$masterId)?>">
				<li>空<span class="direc">间</span></li>
			</a>
			<a href ="<?php echo $siteUrl.('/spacePhoto/index/'.$masterId)?>">
				<li >相册</li>
			</a>
			<a href = "<?php echo $siteUrl.("/info/index/".$masterId)?>"><li class = "index"><span class="direc">名</span>片</li></a>
			<img class = "liImg block"src = "<?php echo base_url('upload/'.$photo)?>"/>	
			</ul>	
		</div>
	</div>
	<!---------------------结束------------------------>
	<div id="cont" class = "content clearfix">
		<p>我的名字:<span><?php echo $res["user_name"]?></span></p>
		<p>地址:<span><?php if($res["addr"]=="") echo "<span class = 'joke'>".$joke[$index++]."</span>";else echo $res["addr"]?></span></p>
		<p>联系方式:<span><?php echo $res["contract1"]?></span></p>
		<p>QQ:<span><?php if($res["contract2"]=="") echo "<span class = 'joke'>".$joke[$index++]."</span>";else echo $res["contract2"]?></span></p>
		<p>邮箱:<span><?php if($res["email"]=="") echo "<span class = 'joke'>".$joke[$index]."</span>";else echo $res["email"]?></span></p>
		<p>注册时间:<span><?php echo $res["reg_time"]?></span></p>
		<p>最后登陆:<span><?php echo $res["last_login_time"]?></span></p>
		<p>口号:
			<span name="cont"><?php echo $res["intro"]?></span>
		</p>
		<textarea name="impress">印象..</textarea>
		<?php if($user_id == $masterId)
			echo "<p  style = 'border:none' id = 'sub'><a href = ".$siteUrl.('/info/change').">修改</a></p>";
		?>
	</div>
</body>
</html>
