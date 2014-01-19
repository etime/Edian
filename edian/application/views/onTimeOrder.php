<!DOCTYPE html>
<html lang = "en">
<head>
<?php
$siteUrl = site_url();
$baseUrl = base_url();
?>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8"/>
    <meta http-equiv="refresh" content="50">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title>E点</title>
    <link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/timeorder.css') ?>" type="text/css" media="all" />
<script type="text/javascript" >
    var site_url = "<?php echo site_url()?>";
    var base_url = "<?php echo base_url()?>";
</script>
</head>
<body>
    <h3>
        <span class = "state">状态</span>
        <span class = "order">订单号</span>
        <span class = "buyer">买家</span>
        <span class="num">金额</span>
        <span class="time">下单时间</span>
    </h3>
    <ul>
        <li>
            <div class = "init">
                <span class="state">打印失败</span>
                <span class="order">1292832322</span>
                <span class="buyer">黄洁</span>
                <span class="num">￥23.00</span>
                <span class="time">1293-32-32 32:12:21</span>
                下拉
            </div>
            <div>
                <ul>
                    <li>
                        <img src = "www.baidu.com" / >
                        <h4>金华火腿</h4>
                        <span>￥12.00 x 12</span>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</body>
</html>
