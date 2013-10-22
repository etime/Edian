<!--页面提示调转页面-->
<!DOCTYPE html>
<html lang = "en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<script type="text/javascript">
var time="<?php
if(isset($time))
	echo $time;
else echo "5";?>";
function getready()
{
	var  atten=document.getElementById("atten");
	atten.innerHTML="页面将在"+time+"后跳转，请稍后";
	time-=1;
	if(time<=0){
		window.location="<?php echo $uri?>";
	}
	else {
		setTimeout("getready()",1000);
	}
}
window.onload=getready;
</script>
</head>
<body>
	<div style = "background:white;margin:0  auto;height:400px;width:330px" >
		<p id="atten"></p>
		<p style = "color:green"> <?php echo $atten?></p>
		<p>直接跳转:<a href="<?php echo $uri?>"><?php echo $uriName?></a></p>
        <input type="hidden" name="value" id="value" value=" <?php echo @$value ?>" />
	</div>
</body>
</html>
