<?php
/***********************************
 * 这个页面是显示图片的，主要是为homeUserphoto.php服务的，功能是显示大图片，没有对应css，js只是作为页面的一部分
 *
 * */
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
#outer{
/*
	display:table;  
*注释掉的部分是垂直居中的css,但是暂时不需要
*/
	width:675px;
	height:100%;
}
 #inner {
/*
	display:table-cell;
	vertical-align:middle;
*/
	text-align:center;   
}
img{
	border: 4px solid #fff;
}
</style>
</head>
<body>
	<div id="outer">
			<div id="inner">
				<img src="<?=base_url('user_photo/').'/'.$img[0]->img_name?>"/>
			</div>
	</div>
</body>
</html>
