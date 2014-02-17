<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/bgcom.css') ?>" type="text/css" media="all" />
    <title><?php echo $title?></title>
</head>
<body>
    <h3>
        <span >评价得分</span>
        <span class = "state">订单号</span>
        <span class = "order">商品</span>
        <span >评论人</span>
        <span >下单时间</span>
    </h3>
    <ul id = "list" class = "list">
        <li>
            <div class = "init">
                <span><strong>8</strong>/10</span>
                <span class="state">12029y288782</span>
                <span class="order">望着的祝福</span>
                <span>黄洁</span>
                <span>1293-32-32 32:12:21</span>
                <font class = "down"> </font>
            </div>
            <div class = "buyer clearfix">
                <div class = "user">
                    <img src = "http://imgstatic.baidu.com/img/image/3b87e950352ac65c761aab7ef9f2b21193138aa4.jpg" />
                    <p>淡定</p>
                </div>
                <blockquote>
                    啦啦啦啦，蛋炒饭真是好吃的很呢
                </blockquote>
                <div class = "oper">
                    <a href = "">回复评论</a>
                    <a href = "">举报</a>
<!--
                    <a href = "">恶意订单</a>
-->
                </div>
            </div>
        </li>
    </ul>
</body>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/jquery.min.js' ?>"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function () {
        console.log("yes");
    $("#list").delegate("li","click",function (event) {
        console.log(event.target);
        var name = $(event.target).attr('class');
        if(name === 'down'){
            $(this).find(".buyer").slideUp();
            $(event.target).removeClass("down").addClass("up");
        } else if(name === 'up'){
            $(this).find(".buyer").slideDown();
            $(event.target).removeClass("up").addClass("down");
        }
    })
})
</script>
</html>
