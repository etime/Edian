<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=base_url("userDengLu.css")?>"/>
<script type="text/javascript" src="<?=base_url("userDengLu.js")?>"></script>
<title> 登录页面</title>
<script type="text/javascript">
var  flag=0;
function rmlab(node){
	node.className="cover";
}
function lealab(node){
	bgchange(node);
	if(node.value.length>0)
		ajcheck(node,"<?=site_url('reg/get_user_name')."/"?>"+node.value);
}
</script>
</head>
<body>                     
<div id="form">
<form method="post" action="<?=site_url("reg/denglu_check/")?>" enctype="multipart/form-data" >
				<div class="input_name"> 
						<input type="text" class="username" onfocus="rmlab(this)" onblur="lealab(this)" name="user_name"/>
						<span id="name_atten" class="atten"></span>
						<label>用户名</label>
				</div>
				<div  class="input_name"> 
						<input type="text" class="username" onfocus="rmlab(this)" onblur="checkpasswd(this)" name="passwd"/>
						<span id="pw_atten" class="atten"></span>
						<label>输入密码</label>
				</div>
				<input type="submit" name="sub"  value="登录" id="user_sub"/>
				<input type="hidden"  id="id"/>
				<input type="hidden"  id="passwd" value="wrong"/>
		</form>		
</div>
</body>
</html>
