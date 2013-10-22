<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title?></title>
<link rel="stylesheet" type="text/css" href="<?=base_url("userspace.css")?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url("upload.css")?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url("photoUserspace.css")?>"/>
<script type="text/javascript">
function getsize(path){
		var temp="";
		var str=path.value;
		var span = document.getElementById("showsize");
		for(var  i=str.length-1;i>=0;i--){
				if(str[i]==".")	{
						if(!((temp=="GNP")||(temp=="gnp")||(temp=="fig")||(temp=="FIG")||(temp=="GEPJ")||(temp=="gpj")||(temp=="GPJ")||(temp=="gepj"))){
								span.innerHTML ="该格式的图片不支持，请更换格式".fontcolor("red");
								return ;
						}
				}
				else if(str[i]=="/"){
						break;				
				}
				 temp+=str[i];
}
		if(temp.length>100)
		{
				span.innerHTML =temp.length+"字符，文件名过长，会导致上传出错，请更换".fontcolor("red");
				return ;
		}
		var size=path.files[0].size/1000;
		if(size>2000){
				span.innerHTML = size+"KB"+" 超过2M的文件会导致上传失败".fontcolor("red");
		}
		else {
				span.innerHTML=size+"KB";
		}
}
</script>
</head>

<body id="top">
<div id="header">
		<ul>
				<li><a href="<?site_url("userspace/user_home")?>">主页</a></li>	
				<li><a href="<?=site_url("userspace/user_photo")?>">相册</a></li>	
				<li><a href="">最新动态</a></li>	
				<li><a href="">信箱</a></li>	
				<li><a href="">博客</a></li>	
		</ul>
</div>
<!--
		<div style="overflow:hidden;height:67px;" > 
				<object id="xt_home_map" height="100%" align="middle" width="100%" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
						<embed height="100%" align="middle" width="100%" pluginspage="http://www.adobe.com/go/getflashplayer_cn" type="application/x-shockwave-flash" allowfullscreen="false" allowscriptaccess="sameDomain" name="xt_home_map" wmode="transparent" bgcolor="#ffffff" quality="high" src="http://www.nowamagic.net/librarys/webapp/clock.swf">
				</object>
		</div>
-->
<div class="block" id="direc"> 
		<p>名称:</p>	
		<p>相册名:</p>
		<ul> 
				<li>同学</li>
				<li>商品</li>
		</ul>
		<p>当前相册:</p>
		<ul> 
				<li>名称:</li>
				<li>价格:</li>
		</ul>	
		<p><a href="<?=site_url("userspace/user_photo/ans_upload/")?>">上传图片</a></p>
</div>
 <div id="con">
 <form method="post" action="<?=site_url("userspace/user_photo/ans_upload/")?>" enctype="multipart/form-data"/>
		<input type="file" name="userfile" size="30" onchange="getsize(this)"/>
		<input type="submit" name="sub" value="上传"/>
		<p id ="showsize">请选择小于2M 的图片文件</p>
</form>
<?php
		echo $attention;
?>	
 </div>
 <div id="bottom">
 </div>
</body>
</html>
