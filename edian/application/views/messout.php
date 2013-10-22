<!DOCTYPE html>
<html lang = "en">
<head>
<?php
	$siteUrl = site_url();
	$baseUrl = base_url();
?>
	<title><?php echo $cont["title"]?></title>
	<meta http-equiv = "content-type" content = "text/html;charset = utf-8"/>
	<link rel="stylesheet" href="<?php echo $baseUrl.('css/art2.css')?>" type="text/css" charset="UTF-8">
	<link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>"> 
	<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var base_url = "<?php echo base_url()?>";
var	user_name="<?php echo $this->session->userdata('user_name')?>";
var	user_id="<?php echo $this->session->userdata('user_id')?>";
var now_type = "<?php echo $messId?>";
var sPhoto = "<?php echo $photo?>";
</script>
</head>
<body  class = "clearfix">
	<div id="dir" >
<!--
		<p class = "dire tt"></p>
		<input type = 'text' id = "search" class = "valTog ip" value = "搜索" name = "search">
		<img src = "<?php echo base_url("bgimage/search.png")?>">
-->
		<p class = "dire"></p>
		<ul id = "dirUl">
			<a href = "<?php echo site_url("message/index")?>">
				<?php if($get == "index") echo "<li style = 'border-radius:5px 5px 0px 0px' class = 'liC'>收件箱<span class = 'tran'></span></li>";else echo "<li style = 'border-radius:5px 5px 0px 0px' class='dirmenu'>收件箱<span ></span></li>"?>
			</a>
			<a href = "<?php echo site_url('message/sendbox')?>">
				<?php if($get == "sendbox") echo "<li style = 'border-radius:0 0 5px 5px' class = 'liC'>发件箱<span class = 'tran'></span></li>";else echo "<li class='dirmenu'>发件箱<span ></span>"?>
				</li>
			</a>
		</ul>

	</div>
	<div id="content" >
	<p id = "title"><?php echo $cont["title"] ?></p>
	<p id = "info"><?php echo $cont["time"]?></p>
		<ul id="ulCont" class="clearfix">
			<li>
				<a href = "<?php echo site_url('space/index/'.$cont["senderId"])?>" target = "_blank">
					<img title = "<?php echo $sender["user_name"]?>"  class = "thumb" src = "<?php echo base_url("upload/".$sender["user_photo"])?>"/>
				</a>
				<p class = "info" style = "margin:0"><?php echo $cont["body"]?></p>
			</li>
			<?php foreach($reply as $key):?>
			<li>
				<?php 
					if($key["senderId"] == $cont["senderId"])
						echo "<a href = ".site_url("space/index/".$cont['senderId'])." target = '_blank'><img title = 'name' class = 'thumb' src =".base_url("upload/".$sender["user_photo"])." /></a>";
					else  
						echo "<a href = ".site_url("space/index/".$cont['geterId'])." target = '_blank'><img title = 'name' class = 'thumb' src =".base_url("upload/".$geter["user_photo"])." /></a>";
				?>
				<p><?php echo $key["body"]?></p>
				<span class = "time"><?php echo $key["time"]?></span>
			</li>
			<?php endforeach?>
		</ul>
		<div id="judge" class = "clearfix sli">
			<form id = "comform" action="<?php echo site_url('message/quickAdd/'.$messId)?>" method="post"  accept-charset="utf-8">
				<textarea id = "comcon" name="com" ></textarea>
				<label for = "comcon"><span class = "pholder">吐槽吗.....</span></label>
			<div id="face" class = "clearfix">
				<div class = "but">
					<input  id ="subcom" type="submit" value="提交"/>
					<input  id ="giveup" type="button" value="取消"/>				
				</div>
<!---------------所有的图片都必须是\d+.gif的格式------------------------------------------>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/15.gif" title="不要嘛，人家会害羞的"/>
				<img src="http://bbs.stuhome.net/images/post/smile/yang/41.gif"/>
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
			</form>
		</div>
	</div>	
<script type="text/javascript" src = "<?php echo $baseUrl.('js/jquery.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/cookie.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/messout.js')?>"> </script>

</body>
</html>
