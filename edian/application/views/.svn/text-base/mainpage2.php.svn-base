 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>测试页面</title>
	<link rel="stylesheet" href="<?php echo  base_url('css/mainpage2.css')?>" type="text/css" charset="UTF-8">
<link rel="icon" href="./edian/logo.png" type="text/css"> 
<script type="text/javascript" src="<?php echo base_url('js/mainpage.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery.js')?>"></script>
<script type="text/javascript">
/*now_type表示当前表示的显示的版块，热门消息算是0，part_id，表示显示的页数，已经表示到了第几页
 */
var partId=new Array(1,1,1,1,1);
var download_height=100;
var now_type=0;
var url,total;//now_type 表示当前显示的版块，download_height表示距离底部开始加载的距离，part_id,表示显示的页数，url表示向那个页面申请数据，total表示版块的数据总数
window.onload= init;
function init(){
	url="mainpage/infoDel/";
	getInfo(now_type);
	$("#dir ul li").click(function(){
		var parent=$("#dir  li");
		for(var i=0;i<parent.length;i++){
			parent[i].className="dirmenu";
		}
		this.className="dirClick";
	})
	changePart();
}

function changePart(node){

	getTotal(now_type,"<?php echo site_url('mainpage/getTotal')?>"+"/"+now_type);
}
window.onscroll=init_scroll;
function init_scroll()
{
	autload(now_type);
}
</script>
</head>
<body>
	<div id="header">
	</div>
	<div id="topline">
	</div>
	<div id="denglu">
		<input type="button" class="butDenglu">	
		<input type="button" class="butDenglu">	
	</div>
<div id="newBody" class="clearfix">
	<div id="dir">
		<ul>
			<li class="dirmenu" name="0" >最新热门</li>
			<li class="dirmenu" name="1" >推荐</li>
			<li class="dirClick" name="2" >店铺</li>
			<li class="dirmenu" name="3" >新闻</li>
			<li class="dirmenu" name="4" >校内部门</li>
			<li class="dirmenu" name="5" >公交出行</li>
		</ul>
<!--
		<ul>
			<li class="dirmenu" name="0" onclick="changePart(this)">最新热门</li>
			<li class="dirmenu" name="1" onclick="changePart(this)">推荐</li>
			<li class="dirmenu" name="2" onClick="changePart(this)">店铺</li>
			<li class="dirmenu" name="3" onClick="changePart(this)">新闻</li>
			<li class="dirmenu" name="4" onClick="changePart(this)">校内部门</li>
			<li class="dirmenu" name="5" onClick="changePart(this)">公交出行</li>
		</ul>
-->
	</div>
	<div id="content" class="contSpace">
		<ul id="ulCont" class="contSpace">
<!--
			<p class="pageDir">第一页</p>
-->
		</ul>
	</div>
</div>
	<div id="bottomDir">
		<ul>
			<li class="botDirli">1</li>
			<li class ="botDirli">2</li>
			<li class="botDirli">3</li>
			<li class="botDirli">4</li>
			<li class="botDirli">5</li>
		</ul>
	</div>
</body>
</html>
