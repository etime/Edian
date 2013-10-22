<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>xhEditor demo8 : Ajax文件上传</title>
<script type="text/javascript" src="<?php echo base_url('js/jquery.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/xheditor-1.2.1.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/zh-cn.js')?>"></script>
<script type="text/javascript">
$(pageInit);
function pageInit()
{
	$.extend(XHEDITOR.settings,{shortcuts:{'ctrl+enter':submitForm}});
	/*
	$('#elm4').xheditor({upImgUrl:"uploadthumb.php",upImgExt:"jpg,jpeg,gif,png"});
	$('#elm6').xheditor({upLinkUrl:"<?php echo site_url("test/ans")?>",upLinkExt:"zip,rar,txt",upImgUrl:"<?php echo site_url('test/ans')?>",upImgExt:"jpg,jpeg,gif,png"});
	*/
	$('#elm6').xheditor({upLinkUrl:"<?php echo site_url("test/ans?immediate=1")?>",upLinkExt:"zip,rar,txt",upImgUrl:"<?php echo site_url('test/ans?immediate=1')?>",upImgExt:"jpg,jpeg,gif,png",onUpload:insertUpload});
}
function insertUpload(arrMsg)
{console.log(arrMsg)
	var i,msg;
	for(i=0;i<arrMsg.length;i++)
	{
		msg=arrMsg[i];
		$("#uploadList").append('<option value="'+msg.id+'">'+msg.localname+'</option>');
	}
}
function submitForm(){$('#frmDemo').submit();}
</script>
</head>
<body>
<form id="frmDemo" method="post" action="">
	<h3>xhEditor demo8 : Ajax文件上传</h3>
	6,上传文件URL回调:<br />
	<textarea id="elm6" name="elm6" rows="12" cols="80" style="width: 80%">
&lt;p&gt;当前实例调用的Javascript源代码为：&lt;/p&gt;&lt;p&gt;$('#elm6').xheditor({upLinkUrl:&quot;upload.php&quot;,upLinkExt:&quot;zip,rar,txt&quot;,upImgUrl:&quot;upload.php&quot;,upImgExt:&quot;jpg,jpeg,gif,png&quot;,&lt;span style=&quot;color:#ff0000;&quot;&gt;onUpload:insertUpload&lt;/span&gt;});&lt;/p&gt;&lt;p&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;上传文件URL回调接口onUpload可扩展编辑器内置的文件上传功能，例如可以将编辑器中上传的图片应用在文章主图片上。&lt;/p&gt;
	</textarea>
	<input type="submit" name="save" value="Submit" />
	<input type="reset" name="reset" value="Reset" />
</form>
</body>
</html>
