<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
selector: target{
		color:red;		
}
.tab_content{
		position:absolute;		
}
#tab1:target,#tab2:target,#tab3:target{
		z-index:1;
}
</style>
</head>
<body>
<ul> 
		<li><a href="#tab1">标签一</a></li>
		<li><a href="#tab2">标签二</a></li>
		<li><a href="#tab3">标签三</a></li>
</ul>
<div id="tab1" class="tab_content">
		<p>asdfasdfasd</p>
</div>
<div id="tab2" class="tab_content"> 
<p>bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb</p>
</div>
<div id="tab3" class="tab_content">
		<p>cccccccccccccccccccccccccccccccccc</p>
</div>
</body>
</html>
