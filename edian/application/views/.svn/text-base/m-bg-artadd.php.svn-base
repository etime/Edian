<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title?></title>
<script type="text/javascript" src="<?=base_url("fckeditor/fckeditor.js")?>">	</script>
</head>
<body>
<script type="text/javascript">
/*
var editor=new FCKeditor("content");
		editor.BasePath='/var/www/ci/fckeditor/';
		editor.ToobarSet="Basic";
		editor.Width='100%';
		editor.Height="400";
		editor.Value="hello,boy, nice to meet you";
		editor.Create();
 */
</script>
<form method="post" action="<?=site_url("chome/reditor")?>" >
标题:<input type="text" size="80" name="title"/>
		<input type="submit" name="sub" value="发表"/>
		<?php
		$path=base_url("fckeditor");
		include("fckeditor/fckeditor.php");
/*
				$path=$_SERVER['PHP_SELF'];
				echo $path;
				$path=substr($path,0,strpos($path,"bg"));
 */
				$editor = new FCKeditor("content");
				$editor->BasePath=base_url("")."fckeditor/";
				$editor->Width="100%";
				$editor->Height="500px";
				$editor->Create()	;
		?>	
</form>
</body>
</html>
