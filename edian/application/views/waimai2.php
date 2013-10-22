<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title>E点送货人家</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl.('css/waimai2.css') ?>" />
<script type="text/javascript" charset="utf-8">
    var user_name="<?php echo trim($this->session->userdata('user_name'))?>";
    var user_id="<?php echo trim($this->session->userdata('user_id'))?>";
</script>
</head>
<body>
<?php
    $this->load->view("header");
?>
    <div class='wrapper clearfix'>
        <div class="contain">
<?php
    if($shop)$len = count($shop);
    else $len = 0;
?>
        <?php for($i = 0;$i < $len;$i++):?>
<?php
    $temp = $shop[$i];
?>
            <div class='pull-left pull'>
                <a href=" <?php echo $siteUrl.('/space/index/'.$temp['user_id']) ?>">
                    <div class='introduce'>
<?php
    $sn = "storeName".rand(1,4);
?>
                        <p class='<?php echo $sn ?> shop'><?php echo $temp["user_name"] ?></p>
                        <p class='yingtime'>营业时间：<span><?php echo $temp["operst"] ?>-<?php echo $temp["opered"] ?></span></p>
                        <p class = 'yingtime'>公告:<?php echo $temp["intro"] ?></p>
                        <p class='dingdan'>订单数：<span><?php echo $temp["order"] ?></span></p>
                    </div>
                    <div class='img'>
                        <img src = "<?php echo $baseUrl.('/upload/'.$temp["user_photo"]) ?>">
                    </div>
                </a>
                <div class='jieshao'>
                    <span class='name area' >经营范围： <?php echo $temp["work"] ?></span>
                    <a href="">查看详情</a>
                </div>
            </div>
            <div class='pull-right pull'>
                <a href=" <?php echo $siteUrl.('/space/index/'.$temp['user_id']) ?>">
                    <div class='introduce'>
<?php
    $sn = "storeName".rand(1,4);
?>
                        <p class='<?php echo $sn ?> shop'><?php echo $temp["user_name"] ?></p>
                        <p class='yingtime'>营业时间：<span><?php echo $temp["operst"] ?>-<?php echo $temp["opered"] ?></span></p>
                        <?php
                            if($temp["intro"])
                                echo "<p>公告:<span>".$temp["intro"]."</span></p>";
                        ?>
                        <p class='dingdan'>订单数：<span><?php echo $temp["order"] ?></span></p>
                    </div>
                    <div class='img'>
                        <img src = "<?php echo $baseUrl.('/upload/'.$temp["user_photo"]) ?>">
                    </div>
                </a>
                <div class='jieshao'>
                    <span class='name area'>经营范围： <?php echo $temp["work"] ?></span>
                    <a href="">查看详情</a>
                </div>
            </div>
        <?php endfor ?>
        </div>
    </div>
<script type="text/javascript" charset="utf-8" src = " <?php echo $baseUrl.('js/jquery.js') ?>"></script>
<script type="text/javascript" charset="utf-8" src = " <?php echo $baseUrl.('js/waimai.js') ?>"></script>

</body>
</html>
