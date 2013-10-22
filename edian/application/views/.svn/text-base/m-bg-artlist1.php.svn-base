<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<style type="text/css">
.fix{
		height:20px;
		background:grey;	
		width:300px;
}
.title{
		height:20px;
		overflow:hidden;		
}
table{
		margin:15px;		
}
table tr th #userName{
		width:100px;		
}
table tr td #userName{
		width:100px;		
}
table tr th #time{
		width:160px;		
}
table tr td #time{
		width:160px;		
}
table tr th #action{
		width:100px;		
}
table tr td #action {
		width:100px;		
}
</style>
</head>
<body>
<table >
		<tr>
				<th><span class="fix" id="userName">用户名</span></th>
				<th><span class="title">文章标题</span></th>
				<th><span class="fix" id="time">发表日期</span></th>
				<th><span class="fix" id="action">增删</span></th>
		</tr>
<!----------------------下面是输出具体数据------------------>
		<?php foreach($allart as $temp):?>	
		<tr>
				<td><span class="fix" id="userName"><?php echo $temp->author_id?></span></td>
				<td><a href=""><span class ="title"><?php echo $temp->title?></span></a></td>
				<td><span class="fix" id="time"><?php echo $temp->time?></span></td>	
				<td><span class="fix" id="action"><a href="<?=site_url("bg/home/artdelete/$temp->art_id")?>">删除</a><a href="">|修改</a></span></td>	
		</tr>
		<?php endforeach?>
</table>

<?php
/*
echo "here is the m-bg-artlist<br/>";
print_r($allart);
 */
?>	
</body>
</html>
