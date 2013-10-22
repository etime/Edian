<!DOCTYPE htm=PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>注册</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url("config.css")?>"/>
		<link rel="stylesheet" type="text/css" href="<?=base_url("reg.css")?>"/>
<script type="text/javascript" src="<?=base_url("reg.js")?>"></script>
<script type="text/javascript">
function namecheck(node){
	if(getlen(node)==0)return ;
	var flag=document.getElementById("name_flag");
	var span=document.getElementById("span_name");
	if((node.value.length<=10)&&(node.value.length>=5))	{
		flag.value=1;						
			span.innerHTML="用户名合适".fontcolor("green");
	}
	else {
		flag.value=0;				
		span.innerHTML="请遵守用户名规则".fontcolor("red");
	}
	ajcheck("<?=site_url('reg/get_user_name')."/"?>"+node.value);
}      
</script>
</head>
<body id="top">
		<div id="con"> 
		</div>
		<form name="reg" action="<?=site_url("reg/index")?>" method="post">
				姓名：<input type="text" name="user_name" onfocus="name_focus()" onblur="namecheck(this)"/><span id="span_name"></span>
				<input type="hidden" id="name_flag" value="0"/>
				<br/>
				密码：<input type="text" name="passwd" onfocus="pass_focus()" onblur="pass_check(this)"/><span id="span_passwd"></span>
				<input type="hidden" id="passwd_flag" value="0"/>
				<br/>
				确认：<input type="text" name="repasswd" onfocus="repass_focus()" onblur="repasswd_check(this)"/><span id="span_re"></span>
				<br/>
				<img  class="wall" src="<?=site_url("check")?>"/>
				<div id="check">
				验证码：<input type="text" name="check" onblur='check_pic("<?=site_url('check/imgSession')?>",this)'/>	<img src="<?=base_url('jpeg')?>"/>
						<span id="piccheck"></span>
				</div>
				<input type="hidden" id="check_pich" value="0"/>
				<br/>
				<input type="submit" name="sub" value="提交"/>
		</form>
		<div id="bottom"> 
		</div>
</body>
</html>
