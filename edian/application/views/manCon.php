<!--
/*************************************************************************
    > File Name :     views/manCon.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-05-14 22:55:03
 ************************************************************************/<!DOCTYPE html>
-->
<html lang = "en">
<head>
	<meta charset = "utf-8">
	<title>E点</title>
	<base href="<?php echo base_url()?>"/>
	<link rel="stylesheet" href="<?php echo base_url('css/mainpage2.css')?>" type="text/css" charset="UTF-8">
	<link rel="stylesheet" href="<?php echo base_url('css/seali.css')?>" type="text/css" charset="UTF-8">
<link rel="icon" href="logo.png" type="text/css"> 
<meta http-equiv = "content-type" content = "text/html;charset =UTF-8">
</head>
<body>
<?php
$siteUrl = site_url();
$baseUrl = base_url();
?>
	<ul id="ulCont" class="clearfix">
	<?php foreach($cont as $val):?>
		<li class = "mainli">
		<a class = "aImg" href = "<?php echo $siteUrl."/showart/index/".$val["art_id"]?>">
			<img class = "imgLi block" src = "<?php echo $baseUrl."thumb/".$val["img"]?>" alt = "商品缩略图"/>
			</a>
			<a href = "<?php echo $siteUrl."/showart/index/".$val["art_id"]?>">
				<p class = "detail"><?php echo $val["title"]?></p>
			</a>
			<p class = "user">
				<span class = "price"><?php echo "￥:".$val["price"]?></span>
			<a target = '_blank' href = "<?php echo $siteUrl."/space/index/".$val["author_id"]?>">
				<span class = "master tt"><?php echo $val["user"]["user_name"]?></span>
			</a>
			</p>
			<p class = "user tt">浏览:<?php echo $val["visitor_num"]?>/评论:<?php echo $val["comment_num"]?><span class = "time"><?php echo $val["time"]?></span>
			</p>
			<div class = "block userCon" style = "display:none">
				<p class = "utran"><p>
				<p class = "clearfix">
					<a target = '_blank' href = "<?php  echo $siteUrl.'/space/index/'.$val['author_id']?>">
					<img class = "imgLi block" src = "<?php echo $baseUrl."upload/".$val["user"]["user_photo"]?>">
					</a>
					<a class = "fuName tt" target = '_blank' href = "<?php echo $siteUrl."/space/index/".$val["author_id"]?>"><?php echo $val["user"]["user_name"]?></a>
					<a target = '_blank' href = "<?php echo $siteUrl."/message/write/".$val["author_id"]?>">站内信联系</a>
				</p>
				<p><span>联系方式:</span><?php echo $val["user"]["contract1"]?></p>
				<?php
					if((array_key_exists("addr",$val["user"]))&&(strlen($val["user"]["addr"]))){
						echo "<p><span>地址:</span>".$val["user"]["addr"]."</p>";
					}
				?>
			</div>
			</li>
		<?php endforeach?>
		</ul>
</body>
</html>
