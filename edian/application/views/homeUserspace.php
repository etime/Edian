<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title?></title>
<link rel="stylesheet" type="text/css" href="<?=base_url("homeUserspace.css")?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url("userspace.css")?>"/>
<script type="text/javascript" src="<?=base_url("userspace.js")?>"></script> 
<script type="text/javascript">
function imgover(node){
	var photoa=document.getElementById("changePhoto")
		photoa.className="overimga";
	node.className="overImgPhoto"; 				
}
function  imgout(node){
	var photoa=document.getElementById("changePhoto")
		photoa.className="outimga";
	node.className="out_img_photo";
}
</script>
</head>
<body id="top">
<div id="header">
		<ul>
				<li><a href="<?=site_url("userspace/user_home")?>">主页</a></li>	
				<li><a href="<?=site_url("userspace/user_photo")?>">相册</a></li>	
				<li><a href="">最新动态</a></li>	
				<li><a href="">信箱</a></li>	
				<li><a href="">博客</a></li>	
		</ul>
</div>
<div id="info" class="block"> 
		<div class="out_img_photo" onmouseover="imgover(this)" onmouseout="imgout(this)"/>
			 <img src="<?=base_url("upload").'/'.$user_photo?>"> 
<!--图像的高度为100px，宽度为93px，对于一般的网站来说都是正方形，个人觉得颀长效果更好-->
<a id="changePhoto" class="outimga" href="<?=site_url("userspace/user_photo/photo")?>"> 点击编辑头像</a>
		</div>
		<div id="state"> 
				<p id="welcome">欢迎你,亲爱的<span><?php echo $user_name?></span></p>
<!--
				<p>这里需要编辑，将编辑头像改为鼠标到达这个区域的时候显示，然后适当调窄这个info框</p>
-->
				<p>最后登录时间:</p>
				<p>威望:</p>
				<p>在线时间:</p>
				<br/>
				<p>关注领域:</p>
				<ul id="part"> 
						<a href=""><li>二手市场</li></a>
						<a href=""><li>周边商店</li></a>
					<a href=""><li>校内新闻</li></a>
						<a href=""><li>求助答疑</li></a>
				</ul>
		</div>
</div>
<div id="active" > 
		<ul > 
				<li><p> wo aEDFOASDIHFOIA SDFO IAS DIFasdfalksdhglasasdflaisdf阿龙索的发挥速度发阿斯地方拉丝机的发丝快点放假萨塑料袋看风景阿龙索 hdsd fsdfasdflkhasdfhasld;kjhdssdkfjaslkdjasdflkasdjfal;sdf;lajsdflas:foahsjdfoiahsdoghiaodogfashjdfoijhasdfoijaisodfhjiohfdsi</p>
						<BR/>
						<BR/>
						<BR/>
			</li>
				<li>
						sadflasdjfakisdjf
				<br/>
						sadfihasidfhjoiadjs
				</li>
				<li> 
						asdhfhasdfihjasdf<br/>
								saldfjalsdkj<br/>
				</li>
		</ul>		
</div>

<div id="visitor" class="block"> 
<ul> 
		<li class="img">
				<img src=""/>
				<p>田乙</p>
				<p>2009-10-12</p>
		</li>	
		<li class="img">
				<img src=""/>
				<p>田乙</p>
				<p>2009-10-12</p>
		</li>
		<li class="img">
				<img src=""/>
				<p>田乙</p>
				<p>2009-10-12</p>
		</li>
		<li class="img">
				<img src=""/>
				<p>田乙</p>
				<p>2009-10-12</p>
		</li>
		<li class="img">
				<img src=""/>
				<p>田乙</p>
				<p>2009-10-12</p>
		</li>
		<li class="img">
				<img src=""/>
				<p>田乙</p>
				<p>2009-10-12</p>
		</li>
</ul>
		<a href="">更多>></a>
</div>
<div id="bottom"> 
</div>
