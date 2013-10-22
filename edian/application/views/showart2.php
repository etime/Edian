 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title?></title>
	<link rel="stylesheet" href="<?php echo base_url('css/art2.css')?>" type="text/css" charset="UTF-8">
<link rel="icon" href="./edian/logo.png" type="text/css"> 
<script type="text/javascript" src = "<?php echo base_url('js/jquery.js')?>"> </script>
<script type="text/javascript" src = "<?php echo base_url('js/cookie.js')?>"> </script>
<script type="text/javascript" src = "<?php echo base_url('js/art.js')?>"> </script>
<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var base_url = "<?php echo base_url()?>";
var	user_name="<?php echo $this->session->userdata('user_name')?>";
var	user_id="<?php echo $this->session->userdata('user_id')?>";
var now_type = "<?php echo $part_id?>",layer=1;
</script>
</head>
<body  class = "clearfix">
	<div id="dir" >
<!--
		<p class = "dire tt"></p>
		<input type = 'text' id = "search" class = "valTog ip" value = "搜索" name = "search">
		<img src = "<?php echo base_url("bgimage/search.png")?>">
-->
		<div id="after" style = "display:none">
			<input type="button"  class = "et" name="zhu" value="注销"/>
			<a href = "<?php echo site_url('write/index')?>" target = "_blank">
				<input type="button" name="reg" class = "et" value="新帖"/>
			</a>
		<p style="text-align:center"><a href="<?php echo site_url("space/index/".$this->session->userdata('user_id'))?>"><img class="block userPhoto" src="<?php echo base_url("upload/".(isset($user)?$user["user_photo"]:null))?>"></a></p>
		</div>
		<p class = "dire"></p>
		<ul id = "dirUl">
			<a href = "<?php echo site_url("mainpage/index/0")?>"><li style = "border-radius:5px 5px 0 0" class="dirmenu" >热点<span ></span></li></a>
			<a href = "<?php echo site_url("mainpage/index/1")?>"><li class="dirmenu" >日记<span ></span></li></a>
			<a href = "<?php echo site_url("mainpage/index/2")?>"><li class="dirmenu" >热点<span ></span></li></a>
			<a href = "<?php echo site_url("mainpage/index/3")?>"><li class="dirmenu" >死亡笔记<span ></span></li></a>
			<a href = "<?php echo site_url("mainpage/index/4")?>"><li style = "border-radius:0 0 5px 5px" class="dirmenu" >旅行<span ></span></li></a>
		</ul>

	</div>
	<div id="content" >
	<p id = "title"><?php echo $title ?></p>
	<p id = "info"><?php if(isset($price))echo "<span class = 'price'>价格￥:".$price."</span>" ?>评价:<?php echo $comment_num?>/浏览:<?php echo $visitor_num?><span><?php echo $time?></span></p>
		<ul id="ulCont" class="clearfix">
			<li>
				<a href = "<?php echo site_url('space/index/'.$author_id)?>" target = "_blank">
					<img  class = "thumb" src = "<?php echo base_url("upload/".$user_photo)?>"/>
				</a>
				<p class = "info" style = "margin:0"><?php echo $content?></p>
			</li>
		</ul>
		<div id="judge" class = "clearfix sli">
			<form id = "denglu" class = "block" action = "<?php echo site_url('reg/denglu');?>" method = 'post' accept-charset = "utf-8">
				用户名:<input type = "text" name = "userName" class = "valTog" value = "注册名,下格请输入密码"/>
				密码:<input type = "password" class = "valTog" name = "passwd" />
				<input type = "submit" name = "enter"  value = "登陆"/>
			</form>
			<form id = "comform" action="<?php echo site_url('showart/addCom/'.$artId)?>" method="post"  accept-charset="utf-8">
				<textarea id = "comcon" name="com" ></textarea>
				<label for = "comcon"><span class = "pholder">吐槽吗.....</span></label>
			<div id="face" class = "clearfix">
				<div class = "but">
					<input  id ="subcom" type="submit" value="提交"/>
					<input  id ="giveup" type="button" value="下次"/>				
				</div>
<!---------------所有的图片都必须是\d+.gif的格式------------------------------------------>
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img  src = "http://bbs.stuhome.net/images/post/smile/yang/11.gif">
			</div>
		</form>
		</div>
	</div>	


</body>
</html>
