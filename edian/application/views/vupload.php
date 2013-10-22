<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title?></title>
<link rel="stylesheet" type="text/css" href="<?=base_url("config.css")?>"/>
<script type="text/javascript">
function getsize(path){
		var size=path.files[0].size/1000;
		var span = document.getElementById("showsize");
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
 <div id="con">
<form method="post" action="/index.php/chome/ans_upload/" enctype="multipart/form-data"/>
		<input type="file" name="userfile" size="30" onchange="getsize(this)"/>
		<input type="submit" name="sub" value="上传"/>
		<p id ="showsize">请选择小于2M 的图片文件</p>
</form>
<?php
		echo @$attention;
?>	
 </div>
 <div id="bottom">
 </div>
</body>
</html>
