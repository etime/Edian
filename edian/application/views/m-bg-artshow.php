<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
		body #time{
				float:right;
		}
		body #content{
				margin:0px auto;		
		}
		body #title{
				margin:2px;
				white-space:nowrap;
				text-overflow:ellipsis;
		}
		a:{
		}
</style>
</head>
<body>
		<h3 id="title"><?php echo $art[0]->title?></h3>
		<p id="time"><?php echo $art[0]->time?></p>
		<br/>
		<div > 
<?php
//print_r($data);
?>	
		<p id="content"><?php  echo $art[0]->content?></p>
</div>
</body>
</html>
