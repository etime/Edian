<?php
/*************************************************************************
    > File Name :     ../views/waimai.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-01 01:14:43
 ************************************************************************/
/*
 * 目前遭到废弃，因为有了一个更好的选择吧
 */
?>
<!DOCTYPE html>
<html lang = "en">
<head>
<?php
$siteUrl = site_url();
$baseUrl = base_url();
?>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title>e点外卖</title>
    <link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
    <link rel="stylesheet" href="<?php echo $baseUrl.'css/waimai.css' ?>" type="text/css" media="all" />
<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var base_url = "<?php echo base_url()?>";
var user_name="<?php echo trim($this->session->userdata('user_name'))?>";
var user_id="<?php echo trim($this->session->userdata('user_id'))?>";
</script>
</head>
<body>
    <div class="header">
        <form  action = "" class = "sea" method = "get" accept-charset = "utf-8">
            <div id = "inpt">
                <input type="text" name="sea" id="sea" value=""  autofocus = "autofocus"/>
            </div>
            <input type="submit" name="sub" id="sub" value="搜店" />
        </form>
    </div>
    <div id = "body">
        <?php for($i = count($shop)-1;$i >= 0;$i--):?>
<?php
    $temp = $shop[$i];
    /*
    $fornow = preg_split("/\:[\d]2$/",$temp["operst"]);
    preg_match("/^[\d]{1,2}\:[\d]{1,2}/",$temp["operst"],$temp["operst"]);
    preg_match("/^[\d]{1,2}\:[\d]{1,2}/",$temp["opered"],$temp["opered"]);
     */
?>
        <div class="shop">
            <a href = "<?php echo $siteUrl.'/space/index/'.$temp['user_id'] ?>">
                <img src="<?php echo $baseUrl.'upload/'.$temp['user_photo'] ?>" alt="<?php echo $temp['user_name'] ?>" />
            </a>
            <a href = "<?php echo $siteUrl.'/space/index/'.$temp['user_id'] ?>">
                <p class = "user" name = "<?php echo $temp['work'] ?>"> <?php echo $temp["user_name"]?></p>
                <p class = "det">
                    <span>订单数:
                        <span class = "impt"> <?php echo $temp['order'] ?></span>
                    </span>
                    <span>营业时间:<span class = "impt"> <?php echo $temp["operst"] ?>-- <?php echo $temp["opered"] ?></span></span>
                </p>
            </a>
        </div>
        <?php endfor ?>
    </div>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/jquery.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/waimai.js' ?>"></script>
</body>
</html>

