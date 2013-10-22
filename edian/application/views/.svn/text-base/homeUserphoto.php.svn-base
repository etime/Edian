<?php
/*这个函数是为了用户空间显示相册使用的页面，对应的控制器是user_photo index ,model是mphoto
 *
 */
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title?></title>
<link rel="stylesheet" type="text/css" href="<?=base_url("userspace.css")?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url("photoUserspace.css")?>"/>
<script type="text/javascript" src="<?=base_url("photoUserspace.js")?>"></script>
<script type="text/javascript">
var imgidlist,now,baseMain,imgnum,user_name,user_id;  
//now 代表了当前main图片的id，imgidlist代表了图片的id list，imgnum，这是一个可以不存在的，代表了数据库中的所有的img的数字,baseMain是主图片除了img——id之外的url部分
function getready(){
	//这个函数是进行各种初始化的函数，
	getlist();
	freshImg();
	user_name=get_cookie("user_name");
	var framesrc="<?=site_url('userspace/user_photo/img_show').'/'.$img_all[0]->img_id?>" 
		var iframe=document.getElementsByTagName("iframe")[0];
	iframe.src=framesrc;
	var pos=document.getElementById("pic").getBoundingClientRect();
	console.log(pos['bottom']);
	if(user_name){
		document.getElementById("denglu").className="wall";
	}
}  
function get_cookie(or){
	//通过用名称获得cookie的函数
	var name=encodeURIComponent(or) + "=",start=document.cookie.indexOf(name);
	var value=null;
	if (start>-1) {           
		var end=document.cookie.indexOf(";",start);
		if (end ==-1) {
			end=document.cookie.length;
		}
		value=decodeURIComponent(document.cookie.substring(start+name.length,end));
	}
	return value;
}
function freshImg(){
	//根据now 然后对所有的缩小图进行更新的函数
	var thumb_list= document.getElementsByName("thumb_img");
	var base="<?=site_url("userspace/user_photo/thumbShow/")?>";
	for(var i=thumb_list.length-1;i>=0;i--){
		getThumb(base,(now+i-2+imgnum)%imgnum,thumb_list[i]);
	}              
}             

function    getlist(){
	//获得js需要的各种参数的函数
	imgidlist= document.getElementsByName("temp_id");
	now=0;
	imgnum=imgidlist.length;
	baseMain="<?=site_url('userspace/user_photo/img_show').'/'?>";
}       
function thumbclick(node){
	console.log(node.id);
}
window.onload=getready;		
</script>
</head>
<body id="top">
<div id="denglu"> 
	<a href="<?=site_url("reg/index")?>"  id="reg" title="注册">注册</a>
	<a href="<?=site_url("reg/denglu")?>" id="deng" title="登录">登录</a>
</div>
</div>
<div id="header">
		<ul>
				<li><a href="<?=site_url("userspace/user_home/index")?>">主页</a></li>	
				<li><a href="<?=site_url("userspace/user_photo")?>">相册</a></li>	
				<li><a href="">最新动态</a></li>	
				<li><a href="">信箱</a></li>	
				<li><a href="">博客</a></li>	
		</ul>
</div>
<div class="block" id="direc"> 
		<p>名称:</p>	
		<p>相册名:</p>
		<ul> 
				<li>同学</li>
				<li>商品</li>
		</ul>
		<p>当前相册:</p>
		<ul> 
				<li>名称:</li>
				<li>价格:</li>
		</ul>	
		<p><a href="<?=site_url("userspace/user_photo/ans_upload/")?>">上传图片</a></p>
</div>
<div id="pic" title="左右按键可以切换图片" onkeyup="keydown(event)"> 
	<iframe name="main_img" width="100%" height="100%" frameborder="no" scrolling="no" src="" title="按左右同样可以切换图片" ONKEY/>
	</iframe>
	<input type="submit" id="last" onclick="last()"   value="上一张"/>
	<input type="button" id="next" onclick="next()"  value="下一张"/>
</div>
<div class="block" id="thumb"> 
	<img class="thumb_show" name="thumb_img" src="" title="左右按键同样可以切换图片"/>
	<img class="thumb_show" name="thumb_img" src="" title="左右按键同样可以切换图片"/>
	<img class="thumb_show" name="thumb_img" src="" title="左右按键同样可以切换图片"/>
	<img class="thumb_show" name="thumb_img" src="" title="左右按键同样可以切换图片"/>
	<img class="thumb_show" name="thumb_img" src="" title="左右按键同样可以切换图片"/>
	<img class="thumb_show" name="thumb_img" src="" title="左右按键同样可以切换图片"/>
</div>    
<div id="bottom"> 
	<?php foreach($img_all as $temp):?>
		<li name="temp_id"><?php echo $temp->img_id?></li>
	<?php endforeach?>
</div>
