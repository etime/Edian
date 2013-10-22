<!DOCTYPE html>
<html lang = "en">
<head>
	<meta http-equiv = "content-type" content = "text/html;charset = utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />    
	<title><?php echo $title?></title>
<?php
	$baseUrl = base_url();
?>
	<base href="<?php echo base_url()?>" >
	<link rel="stylesheet" href="<?php echo base_url('css/write.css')?>" type="text/css" charset="UTF-8">
	<link rel="icon" href="favicon.ico"> 
<script type="text/javascript" src = "<?php echo base_url('js/jquery.js')?>"> </script>
<script type="text/javascript" src = "<?php echo base_url('js/cookie.js')?>"> </script>
<script type="text/javascript" >
	var admin = "<?php echo $this->adminMail?>";
	var dir = <?php  echo json_encode($dir)?>;
	var keyword = "<?php echo $keyword?>";
</script>
<body class = "clearfix">
	<div id="content" class="contSpace">
		<form action="<?php echo site_url('write/reAdd/'.$artId)?>" method="post" enctype = "multipart/form-data" accept-charset = "utf-8">
		<table border="0">
			<p class = "part" id = "part">
					<span class = "item">类别:</span>
<?php
	$count = 1;
?>
<!--js控制选择-->
					<?php foreach ($dir as $key => $value):?>
						<input type="radio" name="part" value="<?php echo $count++?>" <?php if($userType == 2){ if($key == "二手交易") echo "checked='checked'"; else echo "disabled";}else if($key == "食品") echo "checked='checked'"?>/><span><?php echo $key?></span>
					<?php endforeach?>
						<input type="radio" name="part" value="<?php echo $count?>" <?php if($userType == 2) echo "disabled"?>/><span>其他</span>
			</p>
			<p>
				<span class = "item">商品价格:(元)</span><input type="text" name="price" value="<?php echo $price?>"/><span id = "patten"></span>
			</p>
			<p >
				<span class = "item">商品图片:</span><input type="file" name="userfile" size = "14"/>
				<span id = "imgAtten">若本次不添加，将采用上一次的图片</span>
			</p>
			<p class = "tit">
				<input type="text" class = "title" name="key" id = "key" value="<?php echo $keyword?>"/>
				<label for="key" style = "display:none">关键字，查找更方便<span>(关键字请空格断开如: 水果 苹果 青苹果 送货,40字内哦)</span></label>
			</p>
			<p class = "tit"> 
				<input type="text" name="title" id = "title" class = "title" value = "<?php echo $title?>"/>
				<input type="submit" name = "sub" class = "button" value="发表" />
				<label for = "title" style = "display:none">标题<span>(请用简短的描述商品,尽量包含名称和特点，尽量50字以内哦)</span></label>
<!----------------title太差劲了。,学习以下taobao了-------->
			</p>
			<tr id = "tcont">
				<td><textarea name="cont" id = "cont" style = "width:580px"><?php echo $content?></textarea></td>
			</tr>
		</table>
		</form>
	</div>
<script type="text/javascript" src = "<?php echo base_url('js/xheditor.min.js')?>"></script>
<script type="text/javascript" src = "<?php echo base_url('js/zh-cn.js')?>"></script>

<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var	user_name="<?php echo $this->session->userdata('user_name')?>";
var	user_id="<?php echo $this->session->userdata('user_id')?>";
var	PASSWD = "<?php echo $this->session->userdata("passwd")?>";
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
<script type="text/javascript" src = "<?php echo base_url('js/wchange.js')?>"> </script> 
</body>
</html>
