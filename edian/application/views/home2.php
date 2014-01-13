<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
<!DOCTYPE html>
<html lang = "zh">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="<?php echo $baseUrl.'css/home2.css' ?>" type="text/css" media="all" />
    <title>首页</title>
</head>
<body>
    <?php
        $this->load->view("homeHeader");
    ?>
    <div id="magic" class = "width">
        <img src = "<?php echo $baseUrl.'bgimage/magic.png' ?>" />
    </div>
    <div id="main" class = "width">
        <div>
            <div class = "bar">
                <ul>
                    <li>中式快餐</li>
                    <li>西式快餐</li>
                    <li>特色小吃</li>
                    <li>粉面</li>
                    <li>甜食</li>
                    <li>小炒</li>
                </ul>
                <h2>
                    <strong>1</strong>
                   <span>附近外卖</span>
                </h2>
            </div>
            <ul class = "item clearfix">
                <li>
                    <img src = "http://cache.wowsai.com/data/files/groupidea/201401111807143824.jpg">
                    <p class = "nowrap">
                        <a href = "<?php echo $siteUrl . '/item/index/' . 56 ?>">
                            茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳
                        </a>
                    </p>
                    <p>
                        <strong>￥4.00</strong>
                        <span>已售<strong>1200</strong></span>
                    </p>

                </li>
                <li>
                    <img src = "http://uestc.0xiao.com/Public/upload/shop/commodity/menu/image/uestc/5145a99e3ab05.jpg"  />
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <strong>￥4.00</strong>
                        <span>已售<strong>1200</strong></span>
                    </p>
                </li>
                <li>
                    <img src = "http://gi1.md.alicdn.com/bao/uploaded/i1/12128021278700757/T1TYN5XwJaXXXXXXXX_!!0-item_pic.jpg_460x460q90.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <strong>￥4.00</strong>
                        <span>已售<strong>1200</strong></span>
                    </p>
                </li>
                <li>
                    <img src = "http://uestc.0xiao.com/Public/upload/shop/commodity/menu/image/uestc/52a293a5430cd.jpg" />
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <strong>￥4.00</strong>
                        <span>已售<strong>1200</strong></span>
                    </p>
                </li>
                <li>
                    <img src = "http://uestc.0xiao.com/Public/upload/shop/commodity/menu/image/uestc/5145a60e708b3.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <strong>￥4.00</strong>
                        <span>已售<strong>1200</strong></span>
                    </p>
                </li>
            </ul>
        </div>
        <div>
            <div class = "bar">
<!--
                <ul>
                    <li>中式快餐</li>
                    <li>西式快餐</li>
                    <li>特色小吃</li>
                    <li>粉面</li>
                    <li>甜食</li>
                    <li>小炒</li>
                </ul>
-->
                <h2><strong>2</strong> <span>周围商店</span></h2>
            </div>
            <ul class = "item clearfix">
                <li>
                    <img src = "http://cache.wowsai.com/data/files/groupidea/201401111812209161.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>

                </li>
                <li>
                    <img src = "http://cache.wowsai.com/data/files/store_5278/goods_118/wgood_201208082228386543.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://cache.wowsai.com/data/files/groupidea/201401111811239620.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://gd2.alicdn.com/bao/uploaded/i2/13752026681275362/T146efFfVdXXXXXXXX_!!0-item_pic.jpg_460x460.jpg_.webp">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://gd1.alicdn.com/imgextra/i1/745663752/T29JgWXd0XXXXXXXXX_!!745663752.jpg_540x540.jpg_.webp">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
            </ul>
        </div>
        <div>
            <div class = "bar">
                <ul>
                    <li>团购</li>
                    <li>促销</li>
                    <li>清仓</li>
                    <li>限时抢购</li>
                </ul>
                <h2><strong>3</strong> <span>身边活动</span></h2>
            </div>
            <ul class = "item clearfix">
                <li>
                    <div class = "saleImg">
                        <span>团</span>
                        <img src = "http://uestc.0xiao.com/Public/upload/tuan/image/201312/52ba39e10f588.jpg" />
                    </div>
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>

                </li>
                <li>
                    <div class = "saleImg">
                        <span>抢</span>
                        <img src = "http://uestc.0xiao.com/Public/upload/tuan/image/201312/52b95a407bbd3.jpg">
                    </div>
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <strong>￥4.00</strong>
                        <span>已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p>
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div id="footer">
        <p>蜀字132</p>
    </div>
</body>
</html>
