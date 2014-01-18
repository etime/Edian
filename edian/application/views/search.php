<?php
/**
 * @name        ../views/search.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-01-18 16:09:47
 */
 $baseUrl = base_url();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>搜索页面</title>
    <link rel="stylesheet" href="<?php echo $baseUrl .'css/search.css' ?>" type="text/css" media="all" />
</head>
<body>
    <div class = "header">
    <?php
        $this->load->view("homeHeader");
    ?>
    </div>
    <div id="context" class = "width context">
        <div class = "snav">
            <span>综合</span>
            <span>价格</span>
            <span>销量</span>
            <span style = "display:none">距离</span>
            <span>送货速度</span>
            <span>评分</span>
        </div>
        <ul class = "good">
            <li class = "details">
                <div class = "img">
                    <img src="http://www.pkusky.com/upfile/images/MEI%20NV.jpg" alt="图片" class = "mainImg"/>
                </div>
                <div class = "deinfo">
                    <p>斯蒂芬阿斯顿发商店阿斯顿还是地方</p>
                    <p class = "sep">
                        <span>评分3.2</span>
                        <strong>￥90.00</strong>
                    </p>
                    <p class = "sep">
                        <span>已售32</span>
                        <span>奥蒂旗舰店</span>
                    </p>
                </div>
            </li>
            <li class = "details">
                <div class = "img">
                    <img src="http://www.pkusky.com/upfile/images/MEI%20NV.jpg" alt="图片" class = "mainImg"/>
                </div>
                <div class = "deinfo">
                    <p>斯蒂芬阿斯顿发商店阿斯顿还是地方</p>
                    <p class = "sep">
                        <span>评分3.2</span>
                        <strong>￥90.00</strong>
                    </p>
                    <p class = "sep">
                        <span>已售32</span>
                        <span>奥蒂旗舰店</span>
                    </p>
                </div>
            </li>
        </ul>
    </div>
</body>
</html>
