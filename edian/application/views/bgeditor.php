<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文章</title>
</head>
 <div id="con">
 <form action="<?=site_url("bg/home/reditor")."/".$cont[0]->art_id?>" method="post" enctype="multipart/formdata">
		 标题:  <input type="text" name="title" size="80" value="<?php echo $cont[0]->title;?>"/>
				<input type="submit" name="submi" value="提交"/>
<?php
echo $cont[0]->art_id;
				if(isset($cont))
						echo $cke->editor("content",$cont[0]->content);
				else	 echo $cke->editor("content");
/*<link rel="stylesheet" type="text/css" href="<?=base_url("config.css")?>"/>
 <form action="<?=site_url("bg/home/reditor/")?>" method="post" enctype="multipart/formdata">
 */
?>	
</form>
 </div>
</body>
</html>
