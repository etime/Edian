<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?=base_url('m-bg-home-leftdir-img.css')?>"/>
<script type="text/javascript">
function ArtOver(node){
		node.className="over"	;
}
function ArtOut(node){
		node.className="out";
}
</script>
<style type="text/css">
		body #table{
		}	
		.over{
		background:#F3F3F3;
		}
		.out{
}
</style>
</head>
<!---------------这个页面的目的就是添加一个表格,成为后台显示的表格------------------>
<body>
		<ul id = "table"> 
					<a href="<?=site_url("bg/imglist/index")?>" target="content"><li onmouseover="ArtOver(this)" onmouseout="ArtOut(this)" >图片列表</li></a>
		</ul>
</body>
</html>
