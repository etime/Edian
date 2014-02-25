<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
<!DOCTYPE html>
<html lang = "zh">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="<?php echo $baseUrl.'css/home2.css' ?>" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/flexslider.css')?>" type="text/css" charset="UTF-8">
    <title>首页</title>
</head>
<body>
    <?php
        $this->load->view("homeHeader");
    ?>
<!--
    <div id="magic" class = "width">
        <img src = "<?php echo $baseUrl.'bgimage/magic.png' ?>" />
    </div>
-->
    <div class = "flexslider" id = "flexslider" style = "">
        <ul class="slides">
            <li data-thumb = "http://pwg2.gtimg.cn/wanggou/855006089/855006089_aed3382b46ae135ac3db91250bfc948_530aa95c.jpg/0"><img src = "http://pwg2.gtimg.cn/wanggou/855006089/855006089_aed3382b46ae135ac3db91250bfc948_530aa95c.jpg/0"></li>
            <li data-thumb = "http://pwg1.gtimg.cn/wanggou/855006089/855006089_3ed5cd9fbef6292d8d339daea5d21be_5305a45f.jpg/0"><img src = "http://pwg1.gtimg.cn/wanggou/855006089/855006089_3ed5cd9fbef6292d8d339daea5d21be_5305a45f.jpg/0"></li>
            <li data-thumb = "http://pwg0.gtimg.cn/wanggou/855006089/855006089_3021c2ee9ae208b7a5762a7d88e22a2_530aaae5.jpg/0"><img src = "http://pwg0.gtimg.cn/wanggou/855006089/855006089_3021c2ee9ae208b7a5762a7d88e22a2_530aaae5.jpg/0"></li>
            <li data-thumb = "http://pwg1.gtimg.cn/wanggou/855006089/855006089_3ed5cd9fbef6292d8d339daea5d21be_5305a45f.jpg/0"><img src = "http://pwg1.gtimg.cn/wanggou/855006089/855006089_3ed5cd9fbef6292d8d339daea5d21be_5305a45f.jpg/0"></li>
        </ul>
    </div>
    <div id="main" class = "width">
        <div >
            <div class = "bar">
                <span class = "title">热卖商品</span>
                <ul id = "itemLi">
                    <li class = "chose" name = "0">中式快餐</li>
                    <li name = "1">西式快餐</li>
                    <li name = "2">特色小吃</li>
                    <li name = "3">粉面</li>
                    <li name = "4">甜食</li>
                    <li name = "5">小炒</li>
                </ul>
            </div>
            <ul class = "item clearfix 0">
                <li>
                    <img src = "http://cache.wowsai.com/data/files/groupidea/201401111807143824.jpg">
                    <p class = "nowrap">
                        <a href = "<?php echo $siteUrl . '/item/index/' . 56 ?>">
                            茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳
                        </a>
                    </p>
                    <p >
                        <strong>￥4.00</strong>
                        <span class = "det">已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://uestc.0xiao.com/Public/upload/shop/commodity/menu/image/uestc/5145a99e3ab05.jpg"  />
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p >
                        <strong>￥4.00</strong>
                        <span class = "det">已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://gi1.md.alicdn.com/bao/uploaded/i1/12128021278700757/T1TYN5XwJaXXXXXXXX_!!0-item_pic.jpg_460x460q90.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p >
                        <strong>￥4.00</strong>
                        <span class = "det">已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://uestc.0xiao.com/Public/upload/shop/commodity/menu/image/uestc/52a293a5430cd.jpg" />
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p >
                        <strong>￥4.00</strong>
                        <span class = "det">已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://uestc.0xiao.com/Public/upload/shop/commodity/menu/image/uestc/5145a60e708b3.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p >
                        <strong>￥4.00</strong>
                        <span class = "det">已售1200</span>
                    </p>
                </li>
            </ul>
            <ul class = "item clearfix 1" style = 'display:none'>
                <li>
                    <img src = "http://cache.wowsai.com/data/files/groupidea/201401111807143824.jpg">
                    <p class = "nowrap">
                        <a href = "<?php echo $siteUrl . '/item/index/' . 56 ?>">
                            茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳
                        </a>
                    </p>
                    <p >
                        <strong>￥4.00</strong>
                        <span class = "det">已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://uestc.0xiao.com/Public/upload/shop/commodity/menu/image/uestc/5145a99e3ab05.jpg"  />
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p >
                        <strong>￥4.00</strong>
                        <span class = "det">已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://gi1.md.alicdn.com/bao/uploaded/i1/12128021278700757/T1TYN5XwJaXXXXXXXX_!!0-item_pic.jpg_460x460q90.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p >
                        <strong>￥4.00</strong>
                        <span class = "det">已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://uestc.0xiao.com/Public/upload/shop/commodity/menu/image/uestc/52a293a5430cd.jpg" />
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p >
                        <strong>￥4.00</strong>
                        <span class = "det">已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://uestc.0xiao.com/Public/upload/shop/commodity/menu/image/uestc/5145a60e708b3.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p >
                        <strong>￥4.00</strong>
                        <span class = "det">已售1200</span>
                    </p>
                </li>
            </ul>
        </div>
        <div>
            <div class = "bar">
                <span class = "title">周围商店</span>
            </div>
            <ul class = "item clearfix">
                <li>
                    <img src = "http://cache.wowsai.com/data/files/groupidea/201401111812209161.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p class = "det">
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>

                </li>
                <li>
                    <img src = "http://cache.wowsai.com/data/files/store_5278/goods_118/wgood_201208082228386543.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p class = "det">
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://cache.wowsai.com/data/files/groupidea/201401111811239620.jpg">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p class = "det">
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://gd2.alicdn.com/bao/uploaded/i2/13752026681275362/T146efFfVdXXXXXXXX_!!0-item_pic.jpg_460x460.jpg_.webp">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p class = "det">
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
                <li>
                    <img src = "http://gd1.alicdn.com/imgextra/i1/745663752/T29JgWXd0XXXXXXXXX_!!745663752.jpg_540x540.jpg_.webp">
                    <p class = "nowrap">茶菇老鸦汤，鲜美营养，上好调料，来自黑龙江的黑木耳</p>
                    <p class = "det">
                        <span><strong>￥4.00</strong></span>
                        <span>已售1200</span>
                    </p>
                </li>
            </ul>
        </div>
        <div>
            <div class = "bar">
                <span class = "title">身边活动</span>
                <ul>
                    <li class = "chose" >团购</li>
                    <li>促销</li>
                    <li>清仓</li>
                    <li>热卖</li>
                    <li>大甩卖</li>
                </ul>
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
    </div>
    <div id="footer">
        <p>蜀字132</p>
    </div>
</body>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/jquery.min.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/home2.js' ?>"></script>
    <script defer src="<?php echo $baseUrl.('js/flexslider-min.js') ?>"></script>
    <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "fade",
        controlNav: "thumbnails",
        animationSpeed:"1000",
        slideshowSpeed:"5000",
        easing:"swing",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
</html>
