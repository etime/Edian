<!--页面提示调转页面-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<script type="text/javascript">
var time="<?php 
if(isset($time))
	echo $time;
else echo "5";?>";
/*减少接口，缺省条件下为5ms
 */
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
<body >
	<div style = "background:white;margin:0  auto;height:400px;width:330px" >
		<p id="atten"></p>
		<p style = "color:red"> <?php echo $atten?></p>
		<p>直接跳转:<a href="<?php echo $uri?>"><?php echo $uriName?></a></p>
	</div>
</body>
</html>