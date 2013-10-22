<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--这个文件将会被保存，然后被删除，原因是它没有保存的价值了，它的功能被jump.php更好的实现和替代，因为没有倒计时的功能，所以抱歉....-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="refresh" content="<?php echo $time.";"; echo"url=".$url;?>" />
<title></title>
<style type="text/css">
		body #cont{
			padding:10px;	
				margin:10px;
				font-size:18px;
		}
</style>
</head>
<body>
<div id="cont">
<?php
		echo $content;
?>	
</div>
</body>
</html>
