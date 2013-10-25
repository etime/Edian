<!DOCTYPE html>
<html lang = "en">
<head>
<?php
$siteUrl = site_url();
$baseUrl = base_url();
?>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title>E点</title>
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/atten.css')?>" type="text/css" charset="UTF-8">
    <link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
</head>
<body>
<?php
    $this->load->view("userCenter");
    $img = $baseUrl."upload/191376230890.jpg";
?>
    <div id = "cont" class = "cont clearfix">
        <ul class = "goods" class = "goods">
            <li class = "clearfix">
                <a>
                    <img src = "<?php echo $img ?>" class = "thumb">
                </a>
                <div class = "dinfo">
                    <a>王石羊肉汤</a><br/>
                    <img src = "<?php echo $img ?>"/>
                    <div class = "det">
                        <p>价格:<em>230.00</em>元</p>
                        <p>浏览:123</p>
                        <p>评论:321</p>
                        <p>购买:23</p>
                        <p>时间:5月12日12:12</p>
                    </div>
                    <div class = "comment">
                        <textarea name="judge" placeholder = "说两句说.." ></textarea>
                        <div>
                            <input type="button" name="judbtn"  value="发表" />
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <ul class = "fels" id = "fels">
            <li><p>老王</p></li>
        </ul>
    </div>
</body>
</html>

