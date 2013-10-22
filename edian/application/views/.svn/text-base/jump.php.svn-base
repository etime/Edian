<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<script type="text/javascript">
var time="<?=$time?>";
function getready()
{
	var  atten=document.getElementById("atten");
	atten.innerHTML="页面将在"+time+"后跳转";
	time-=1;
	if(time<=0){
		window.location="<?=$uri?>";
	}
	else {
		setTimeout("getready()",1000);
	}
}
window.onload=getready;
</script>
</head>
<body>
	<p id="atten"></p>
	<p>直接跳转:<a href="<?=$uri?>"><?php echo $uriName?></a></p>
</body>
</html>
