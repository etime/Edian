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
        <strong>Edian</strong>
    </div>

<div class="side" id = "side">
<!--这里是art的开始------>
<?php
if($type === 2){
    echo "<ul id = 'wrong' class = 'wrong'>".
        "<a href = ".$siteUrl.('/wrong/showError')." target = 'content' ><li name = 'wrong'>错误意外处理</li></a>".
        "<a href = ".$siteUrl.('/bg/userlist')." target='content'><li  name = 'shop'>商店管理</li></a>".
        "<a href = ".$siteUrl.('/bg/userlist/user')." target='content'><li  name = 'user'>用户管理</li></a>".
        "<a href = ".$siteUrl.('/bg/info/add')." target = 'content'><li  name = 'cast'>添加公告</li></a>".
        "<a href = ".$siteUrl.('/bg/bgart/index')." target = 'content' ><li name = 'sec'>二手管理</li></a>".
        "</ul>";
}
?>
    <ul id = "order" class = "order">
<!--
        <a href = "<?php echo $siteUrl.('/bg/order/ontime') ?>" target = "content"><li  name = 'ontime' class = "liCse">待处理订单</li></a>
-->
        <a href = "<?php echo $siteUrl.('/bg/order/ontime') ?>" target = "content"><li  name="today">今日订单</li></a>
        <a href = "<?php echo $siteUrl.('/bg/order/history') ?>" target = "content"><li  name = 'hist'>历史订单</li></a>
    </ul>
    <ul class = "art" id = "art" >
        <a href = "<?php echo $siteUrl.'/bg/set/setAct' ?>" target="content" ><li name = 'set'>商城设置</li></a>
        <a href ="<?php  echo $siteUrl.('/bg/item/manage')?>" target="content">
            <li name = 'manage'>商品管理</li>
        </a>
        <!--商品管理其实分两个部分，一个是用户自己看的，一个是网站工作人员看的-->
        <a href = "<?php  echo $siteUrl.('/bg/item/itemCom')?>" target="content"><li name = 'coment'>商品评论</li></a>
        <!-- 评论分为店家看的和管理员可以修改的部分-->
        <a href = "<?php  echo $siteUrl.('/bg/home/item')?>" target="content"><li name = 'addItem'>添加商品</li></a>
    </ul>

    <form action="<?php echo $siteUrl . '/bg/home/index/' ?>" method="post" accept-charset="utf-8">
        <select name = 'storeId'>
        <?php foreach ($storeList  as $value){
                if($value['id'] == $storeId){
                    echo "<option value=" . $value['id'] . " selected = 'selected'>".$value['name'] ."</option>";
                } else {
                    echo "<option value=" . $value['id'] . ">".$value['name'] ."</option>";
                }
        }
        ?>
        </select>
        <input type="submit" name="sub" value="选择店铺" />
    </form>
    <!--这里是user的结束------>
</div>
<div id = "frameCon">
<?php
if($type === 1){
    $src = $siteUrl.('/bg/order/ontime');
}else {
    $src = $siteUrl.('/bg/wrong/index');
}
?>
    <iframe id = "main" frameborder="0" name="content" src="<?php echo $src?>"></iframe>
</div>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . '/js/jquery.min.js' ?>"></script>
<!-- 以后使用原生的js来做-->
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . '/js/bghome.js' ?>"></script>
</body>
 </html>
