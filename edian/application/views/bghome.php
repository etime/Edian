<!DOCTYPE html>
 <html lang = "en">
     <head>
<?php
$baseUrl = base_url();
$siteUrl = site_url();
?>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="author" content="Chomo" />
 <title>后台管理页面</title>
<link rel="stylesheet" type="text/css" href="<?php echo  base_url("css/bghome.css")?>"/>
 </head>
 <body>
    <div class="top">
        <h2 ><span>E点,悠闲生活</span>这里是管理员页面 ,欢迎吐槽</h2>
    </div>
<div class="side" id = "side">
<!--这里是art的开始------>
<?php
if($type == $ADMIN){
    echo "<ul id = 'wrong' class = 'wrong'>".
        "<a href = ".$siteUrl.('/bg/wrong/index/')." target = 'content'><li>错误意外处理</li></a>".
        "<a href = ".$siteUrl.('/bg/userlist')." target='content'><li >用户列表</li></a>".
        "<a href = ".$siteUrl.('/bg/info/add')." target = 'content'><li>添加公告</li></a>".
        "<a href = ".$siteUrl.('/bg/bgart/index')." target = 'content'>二手管理</a>".
        "</ul>";
}
?>
<!--
    <ul id = "wrong" class = "wrong">
        <a href = " <?php echo $siteUrl.('/bg/wrong/index/') ?>"><li>错误意外处理</li></a>
    </ul>
-->
    <ul id = "order" class = "order">
        <a href = "<?php echo $siteUrl.('/bg/order/ontime') ?>" target = "content"><li>待处理订单</li></a>
        <a href = "<?php echo $siteUrl.('/bg/order/today') ?>" target = "content"><li>今日订单</li></a>
        <a href = "<?php echo $siteUrl.('/bg/order/history') ?>" target = "content"><li>历史订单</li></a>
    </ul>
    <ul class = "art" id = "art" >
        <a href = "<?php echo $siteUrl.'/bg/set/setAct' ?>" target="content"><li>商城设置</li></a>
        <a href ="<?php  echo $siteUrl.('/bg/item/mange')?>" target="content">
            <li>商品管理</li>
        </a>
        <!--商品管理其实分两个部分，一个是用户自己看的，一个是网站工作人员看的-->
        <a href = "<?php  echo $siteUrl.('/bg/item/itemCom')?>" target="content"><li>商品评论</li></a>
        <!-- 评论分为店家看的和管理员可以修改的部分-->
        <a href = "<?php  echo $siteUrl.('/bg/home/item')?>" target="content"><li>添加商品</li></a>
    </ul>
<!--这里是art的结束------>
<!--这里是img的开始------>
    <ul id = "img" class = "img">
        <a href = "<?php echo site_url('bg/home/imglist')?>" target="content"><li>图片管理</li></a>
        <a href = "<?php echo site_url('upload/index')?>" target="content"><li>上传图片</li></a>;
    </ul>
    <!--这里是user的开始------>
    <ul id = "sec" class = "sec">
    </ul>
    <!--这里是user的结束------>
</div>
<div id = "frameCon">
<?php
$src = $siteUrl.('/bg/wrong/index');
if($type == $SELLER){
    $src = $siteUrl.('/order/ontime');
}
?>
    <iframe id = "main" frameborder="0" name="content" src="<?php echo $src?>"></iframe>
</div>
     </body>
 </html>
