<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?>	</title>
<style type="text/css">
		*{
		margin:0;
		padding:0;
		list-style:none;
}
html,body	{
		height:100%;
		overflow:hidden;				
}
.panel{
		position:absolute;
		top:0px;
		right:0px;
		bottom:0px;
		left:0px;
		z-index:1;	
}
.top{
		height:50px;
		background:#ccc;		
}
.left{
		top:50px;
		bottom:50px;
		width:200px;
		background:#eee;		
}
.main{
		left:200px;
		top:50px;
		bottom:50px;
		background-color:#f5f5f5;		
}
.bottom{
		top:auto;
		height:50px;
		background-color:#ccc;
}
.panel  iframe{
		width:100%;
		height:100%;		
}
.hidetop .top{
		display:none;		
}
.hidetop .left,.hidetop .main{
		top:0px;		
}
.hidebottom .bottom{
		display:none;		
}
.hidebottom .left, .hidebottom .main{
		bottom:0px;		
}
.hideleft .left{
		display:none;		
}
.hideleft .main{
		left:0px;		
}
</style>
<script type="text/javascript">
function toggleClass(dom,className){
		var reg= new RegExp(className ,"g")					,
				cn=dom.className;
				newcn=cn.indexOf(className)==-1?(cn+""+className):cn.replace(reg,"");
				dom.className =newcn;
}
</script>
  </head>
     <body>
      <div class="panel top">顶部内容(iframe上scrolling="yes" style="overflow:visible;"防止IE6出现iframe横向滚动条)</div>
      <div class="panel left">
        <input type="button" id="" name="" value="收起/显示上部" onclick="toggleClass(document.getElementsByTagName('html')[0],'hidetop')" />
        <br />
        <input type="button" id="" name="" value="收起/显示左部" onclick="toggleClass(document.getElementsByTagName('html')[0],'hideleft')" />
        <br />
        <input type="button" id="" name="" value="收起/显示下部" onclick="toggleClass(document.getElementsByTagName('html')[0],'hidebottom')" />
      </div>
      <div class="panel main" ><iframe frameborder="0"  scrolling="yes" style="overflow:visible;" src="http://www.baidu.com"></iframe></div>
      <div class="panel bottom">底部内容</div>
     </body>
</html>
