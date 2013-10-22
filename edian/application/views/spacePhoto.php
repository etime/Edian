<!DOCTYPE html>
<html lang = "en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title><?php echo $title?>的相册</title>
	<link rel="icon" href="favicon.ico"> 
	<base href="<?php echo base_url()?>" >
	<link rel="stylesheet" href="css/spacePhoto.css" type="text/css" charset="utf-8">
</head>
<body>
	<!------------------header开始---------------------->
	<div id="header">
		<div class="content">
			<ul class = "clearfix">
			<a href = "<?php echo site_url('mainpage/index')?>">
				<li>首页</li>
			</a>
			<a href = "<?php echo site_url('space/index/'.$masterId)?>">
				<li>空<span class="direc">间</span></li>
			</a>
			<a href ="<?php echo site_url('spacePhoto/index/'.$masterId)?>">
				<li class = "index">相册</li>
			</a>
			<a href = "<?php echo site_url("info/index/".$masterId)?>"><li><span class="direc">名</span>片</li></a>
			<img class = "liImg block"src = "<?php echo base_url('upload/'.$photo)?>"/>	
			</ul>	
		</div>
	</div>
	<!---------------------结束------------------------>
<!--这里是介绍的开始-->
	<div class="content clearfix" id="photo">
			<div id="intro" >
			<?php if($this->session->userdata("user_id")==$masterId) echo "<input type='button' id = 'uploadBt' value='上传'/>"?>
				<textarea id = "introText"></textarea>
			</div>

			<div id="main" >
				<img  class="mainPhoto" id = "mainPhoto"  alt = "大图片">
				<div id="mainName">
					<span></span>
				</div>
				<span class = "leftarrow"></span>
				<span class = "rightarrow"></span>
			</div>
			<div id="thumb">
				<p id="arrowup"></p>
				<p id="arrowdown"></p>
			</div>
	</div>
	<div id="comment">
		<ul id="comUl" class = "clearfix content">
		</ul>
	</div>
	<div id="judge" class="odd clearfix">
		<div class="content">
			<form  class="judgeInfo block" method="post" >
				<textarea name="content" id="commentContent" placeholder="添加回复内容" class="block"></textarea>			
<!--
					<input type="file" size="9" name="judgeupload" id="upload" >
-->
					<input type="submit" name="sub" value="回复" id="submit">
<!--
					<span class="stayline"></span>
-->
			</form>
			<div id="face" class="block">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/15.gif" title="不要嘛，人家会害羞的"/
				><img src="http://bbs.stuhome.net/images/post/smile/yang/41.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/42.gif" title="嘿嘿嘿....先拿钱来"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/45.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/46.gif" title="让人家得瑟一会嘛"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/5.gif" title="这个....呵呵.....汗....."/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/47.gif" title="嘿嘿嘿嘿......"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/48.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/50.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/51.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/40.gif" title="饱饱的，很贴心"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/52.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/30.gif" title="汗....."/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/55.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/56.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/10.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/11.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/16.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/15.gif" />
				<img src="http://bbs.stuhome.net/images/post/smile/yang/17.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/18.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/19.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/30.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/61.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/34.gif"/
				><img src="http://bbs.stuhome.net/images/post/smile/too/24.gif" title="耶..........."/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/35.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/8.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/19.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/1.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/2.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/3.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/6.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/27.gif"/>
				<img src = "http://bbs.stuhome.net/images/post/smile/yang/33.gif"/>
				<img src = "http://bbs.stuhome.net/images/post/smile/too/21.gif"/>
				<img src = "http://bbs.stuhome.net/images/post/smile/too/10.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/9.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/13.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/17.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/1.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/28.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/43.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/31.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/too/32.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/38.gif"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/59.gif"/>
			</div>		
		</div>
	</div>
<script type="text/javascript" src="js/jquery.js"></script>
<!--
<script type="text/javascript" src="http://blog.jobbole.com/wp-content/themes/jobbole/js/jquery.js"></script>
-->
	<script type="text/javascript" src="js/spacePhoto.js"></script>
	<script type="text/javascript" >
		var site_url = "<?php echo site_url('')?>";
		var user_id = "<?php echo $this->session->userdata('user_id')?>";
		var base_url="<?php echo base_url('')?>";
		var user_name = "<?php echo $this->session->userdata('user_name')?>";
</script>
</body>
</html>
