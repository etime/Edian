 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title?></title>
	<link rel="stylesheet" href="<?php echo base_url('css/write.css')?>" type="text/css" charset="UTF-8">
<link rel="icon" href="./edian/logo.png" type="text/css"> 
<script type="text/javascript" src = "<?php echo base_url('js/jquery.js')?>"> </script>
<!--
<script type="text/javascript" src = "<?php echo base_url('js/cookie.js')?>"> </script> ;
-->

<body class = "clearfix">
	<div id="dir" class = "leaft">
<!--
		<p id = "atten" class = "tt"></p>
		<input id = "search" class = "ip" value = "搜索" name = "search">
		<img src = "<?php echo base_url("bgimage/search.png")?>">
-->
		<p class = "dire"></p>
		<ul id = "dirUl">
			<a href = "<?php echo site_url("mainpage/index/0")?>"><li style = "border-radius:5px 5px 0 0" class="dirmenu" >热点<span ></span></li></a>
			<a href = "<?php echo site_url("mainpage/index/1")?>"><li class="dirmenu" >日记<span ></span></li></a>
			<a href = "<?php echo site_url("mainpage/index/2")?>"><li class="dirmenu" >热点<span ></span></li></a>
			<a href = "<?php echo site_url("mainpage/index/3")?>"><li class="dirmenu" >死亡笔记<span ></span></li></a>
			<a href = "<?php echo site_url("mainpage/index/4")?>"><li style = "border-radius:0 0 5px 5px" class="dirmenu" >旅行<span ></span></li></a>
		</ul>
		<p class = "dire tt"></p>
	</div>
	<div id="content" class="contSpace">
		<form action="<?php echo site_url('write/add')?>" method="post" accept-charset = "utf-8">
		<table border="0">
			<tr width = "500px">
				<td>
				<select  class = "button" name="part" id="part">
					<option value="1" selected = "selected">商店</option>
					<option value="2">公交</option>
					<option value="3">二手市场</option>
					<option value="4">新闻</option>
				</select>
				</td>
				<td>
				<?php if(!isset($tit)) $tit = "标题"?>
					<input type="text" name="title" id = "title" value = "<?php echo $tit?>">
				</td>
				<td>
				<input type="submit" name = "sub" class = "button" value="发表">
				</td>
			</tr>
			<tr><td class = "tdarea" style = "width:400px"><textarea name="cont" id = "cont" style = "width:580px">
			</textarea></td></tr>
		</table>
<!--
			<table>
			<p>版块:
				<select  class = "button" name="part" id="part">
					<option value="1" selected = "selected">商店</option>
					<option value="2">公交</option>
					<option value="3">二手市场</option>
					<option value="4">新闻</option>
				</select>
				<?php if(!isset($tit)) $tit = "标题"?>
				<input type="text" name="title" id = "title" value = "<?php echo $tit?>">
				<input type="submit" class = "button" value="发表">
			</p>
			<textarea id="cont" name="cont" style="width: 580px">
			</textarea>
			</table>
-->
		</form>
	</div>
<script type="text/javascript" src = "<?php echo base_url('js/xheditor.min.js')?>"></script>
<script type="text/javascript" src = "<?php echo base_url('js/zh-cn.js')?>"></script>

<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var	user_name="<?php echo $this->session->userdata('user_name')?>";
var	user_id="<?php echo $this->session->userdata('user_id')?>";
$(pageInit);
function pageInit()
{
	$.extend(XHEDITOR.settings,{shortcuts:{'ctrl+enter':submitForm}});
	$('#cont').xheditor({upImgUrl:site_url+"/write/imgAns?immediate=1",upImgExt:"jpg,jpeg,gif,png"});
}
function insertUpload(arrMsg)
{
	var i,msg;
	for(i=0;i<arrMsg.length;i++)
	{
		msg=arrMsg[i];
		$("#uploadList").append('<option value="'+msg.id+'">'+msg.localname+'</option>');
	}
}
function submitForm(){$('#frmDemo').submit();}
</script>
<script type="text/javascript" src = "<?php echo base_url('js/write.js')?>"> </script> 
</body>
</html>
