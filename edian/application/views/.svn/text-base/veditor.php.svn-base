<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=site_url("../../config.css")?>"/>
<title>文章sdfasd</title>
</head>
<body id="top">
<?php
	echo time()."<br/>";
?>
<div id="editor"> 
		<?php
/*
echo "hello";
				include("/var/www/ci/system/plugins/fckeditor/fckeditor.php");
				$editor=new FCKeditor("content");
				$editor->BasePath ="/plugins/fckeditor/";
				echo $editor->BasePath;
				echo "<br/>asd<br/>";
				$editor->Width="700px";
				$editor->Height="500px";
				$editor->Create();
				echo site_url();
				echo "<br/>".base_url();
 */

/*
include_once(site_url("plugins/fckeditor/fckeditor.php"));
include("")
$edi= new FCKeditor("value");
$edi->BasePath="plugins/fckeditor";
$edi->Width="500";
$edi->Height="400";
$edi->Create();
 */
/************下面是cke 的代码*****************/
/*
 * <script type="text/javascript" src="<?=site_url('plugins/ckeditor/ckeditor.js'?>"></script>
<script type="text/javascript" src="/var/www/ci/system/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="plugins/ckeditor/ckeditor.js"></script>
 */
?>

<form action="<?=site_url("chome/reditor")?>" method="post">
标题:<input type="text" name="title" size="80"/>
<input type="submit" name="submi" value="提交" />
<br/>
part_id:<input type="text" name="part_id"><br/>
time:<input type="text" name="time"><br/>
user_id:<input type="text" name="user_id">
<?php
	//<textarea class="ckeditor" cols="80" rows="10"id="editor1" name="editor2">
//</textarea>a
	//echo $cke->editor("content","这里输入内容");
if(isset($cont)){
		echo $cke->editor("content",$cont[0]->content);

}
else echo $cke->editor("content","");
?>
</form>
</div>
 <div id="con">
 </div>
 <div id="bottom">
 </div>
</body>
</html>
