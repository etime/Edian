<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="<?php echo base_url('css/spacePhoto.css')?>" type="text/css" media="screen" charset="utf-8">
	<title><?php echo $title?>的相册</title>
<!--
<script type="text/javascript" src="<?php echo base_url('js/jquery.js')?>"></script>
-->
	<script type="text/javascript" src="<?php echo base_url('js/spacePhoto.js')?>"></script>
	<script type="text/javascript" src="http://blog.jobbole.com/wp-content/themes/jobbole/js/jquery.js"></script>
	<script type="text/javascript" >
		var url="<?php echo site_url("spacePhoto/judge/")?>";
		window.onload=construct;
</script>
</head>
<body>
	<?php echo $this->load->view("m-spaceHeader")?>
<!--这里是介绍的开始-->
	<div class="content" id="photo">
			<div id="intro" class="better">
				<div id="photointro">
					<p class="stayline">相册:<span>阿三的阿斯顿发送到发</span></p>
					<p class="stayline">照片:<span class="direc">alskdjflaksdjfasdfasdfasdfasdfasdf;kasd.jpg</span></p>
					<p class="stayline">上传时间:</p>
					<p class="stayline">领主:</p>
					<p>备注:</p>
				</div>
				<textarea>亲，大家都懂的怎么才可以开始空两个字符呢</textarea>
			</div>
			<div id="main" class="better">
<!--
				<img src="http://www.easy-linkholiday.com/de/uploadImages/2008661674192673.jpg" class="mainPhoto" title="按左右按键可以切换图片">
-->
			</div>
			<div id="thumb" class="better">
			</div>
	</div>
	<div id="comment">
		<ul id="commentUl">
			<li class="odd">
				<div class="content">
					<div class="block userInfo">
<!--
						<img class="block" src="http://c1.neweggimages.com.cn/neweggpic2/neg/P380/A28-105-0AR.jpg?v=810D7695D98A46CF81E2">	
-->
						<p>用户名:<span>失意的时候不要伤心</span></p>
						<p>在线:<span>是</span></p>
						<p>评论时间:2010-02-03</p>
					</div>
					<div class="commentInfo">
						<p>我顶以下，阿列克等级分类卡斯蒂封建卡拉大三faksdjfakdsfjadslfkjaskdlfjalkdsjflakd阿斯兰快点放假阿列克就打算饭卡就四道口路放假啊两道三科积分阿克萨的房间阿喀琉斯的剑法的积分阿斯顿李开复阿列克江东父老卡带机富利卡京东方kajsdfkadsfaksldjflakjdsfkla，卡斯江东父老卡的算法卡的所肩负看lajdfkadsfkasdf ，阿斯顿没法卡斯蒂饭卡几点思考封建asdjfajsdfjaksdfja，阿迪所开发克里斯蒂发，摩卡打扫房间卡拉第三届法大赛开发sdfjaksdjfklajdsfajdsf， 阿斯顿麻烦了卡及的算法几点思考发jdskfjaklsdjfajdsflkajdsflkadsfadf的算法阿迪发来阿的算法卡拉打扫房间莱卡的算法拉阿得分飒飒的发阿迪算法阿迪法大赛发 我用力顶一下，我使用力气的顶一下</p>
					</div>
				</div>
			</li>
			<li >
				<div class="content">
					<div class="block userInfo">
<!--
						<img class="block" src="http://c1.neweggimages.com.cn/neweggpic2/neg/P380/A28-105-0AR.jpg?v=810D7695D98A46CF81E2">	
-->
						<p>用户名:<span>失意的时候不要伤心</span></p>
						<p>在线:<span>是</span></p>
						<p>评论时间:2010-02-03</p>
					</div>
				</div>
			</li>
			<li class="odd" >
				<div class="content">
					<div class="block userInfo">
<!--
						<img class="block" src="http://c1.neweggimages.com.cn/neweggpic2/neg/P380/A28-105-0AR.jpg?v=810D7695D98A46CF81E2">	
-->
						<p>用户名:<span>失意的时候不要伤心</span></p>
						<p>在线:<span>是</span></p>
						<p>评论时间:2010-02-03</p>
					</div>
				</div>
			</li>
		</ul>
	</div>
	<div id="judge" class="odd clearfix">
		<div class="content">
			<form class="judgeInfo block" method="post">
				<textarea name="content" id="commentContent" placeholder="添加回复内容" class="block"></textarea>			
					<input type="file" size="9" name="judgeupload" id="upload" >
					<input type="submit" name="sub" value="发表" id="submit">
					<span class="stayline"></span>
			</form>
			<div id="face" class="block">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/15.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/41.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/42.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/45.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/46.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/5.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/47.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/48.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/50.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/51.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/40.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/52.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/30.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/55.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/56.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/10.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/11.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/tuerkong/29.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/16.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/15.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/17.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/18.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/19.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/30.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/61.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/34.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/24.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/35.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/8.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yellow%20face/(20).gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/19.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/1.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/2.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/3.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/4.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/6.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/9.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/13.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/17.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/1.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/28.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/43.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/31.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/too/32.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yellow%20face/(14).gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/38.gif">
				<img src="http://bbs.stuhome.net/images/post/smile/yang/59.gif">
			</div>		
		</div>

	</div>
</body>
</html>
