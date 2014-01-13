<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
<!DOCTYPE html>
<html lang = "zh">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>何时专辑店</title>
    <link rel="stylesheet" href="<?php echo $baseUrl.'/css/store.css' ?>" type="text/css" media="all" />
</head>
<body>
<!--
    <div id="header">
        <div class="dtop width">
            <h1>eDian</h1>
            <input type="text" name="sea" id="sea" placeholder = "搜索" />
        </div>
    </div>
-->
<?php
    $this->load->view('head');
?>
    <div id = "nav" class = "nav">
        <div class="cnav width clearfix">
            <h4>商品类别</h4>
            <ul class = "list">
                <li class = "ccd">全部</li>
                <?php foreach ($category  as $value): ?>
                <li> <?php echo $value ?></li>
                <?php endforeach?>
            </ul>
            <div class = 'search'>
                <div>
                    <input type="text" name="sea" id="sea"  placeholder = "搜索" autofocus = 'on'/>
                </div>
                <input type="submit" name="but"  value="店内搜" />
            </div>
        </div>
    </div>
    <div id = 'body' class = "width clearfix">
        <div id = "side">
            <div class = "stCom block">
                <h3>何氏专辑店</h3>
                <blockquote>
                    银鳞胸甲，蓝色品质，五金一件，先到先得
                </blockquote>
                <img src="<?php echo $logo?>" alt="商店logo" />
            </div>
            <div class = "store block">
<!--
                <h5>店铺信息</h5>
-->
                <div class = "bustime clearfix">
                    <span class = "item">营业时间</span>
                    <ul alt = "<?php echo $deliveryTime ?>">
                        <li>9:00-12:00</li>
                        <li>9:00-12:00</li>
                        <li>9:00-12:00</li>
                    </ul>
                </div>
                <p>
                    <span class = "item">店铺评分</span>
                    <strong class = "bc"><?php echo $credit ?></strong>
                </p>
                <p><span class = "item">送货范围</span><strong><?php echo $deliveryArea ?></strong>米</p>
                <p>
                    <span class = "item">送货速度</span>
                    <strong><?php echo $duration ?></strong>分钟
                </p>
                <p><span class = "item">商店距离您</span>    <strong class = "bc">4.5</strong>km</p>
                <p><span class = "item">电话</span><?php  echo $servicePhone?></p>
                <p><span class = "item">客服QQ  </span><?php  echo $serviceQQ?></p>
                <img id = "mapImg" src = "<?php echo $baseUrl.'image/52/mix/map.png' ?>" alt = "地图图片" title = "双击打开地图" />
            </div>
        </div>
        <div class = "good block">
            <h5>
                e点 >> 指尖蛋糕店 >> 曲奇
                <span>共35件商品</span>
            </h5>
            <div class="snav">
                价格区间
                <input type="text" name="dprc"  value="12" />--
                <input type="text" name="tprc"  value="12" />
                <input type="submit" name="sub"  value="确定" />
                <div class="psplit">
                    <span>1/3页</span>
                    <span>第一页</span>
                    <span>上一页</span>
                    <span>下一页</span>
                    <span>跳转到 <input type="text" name="pgNum" /></span>
                    <span>尾页</span>
                </div>
            </div>
            <ul class = "goodlist clearfix">
            <?php foreach($itemlist as $item): ?>
                <li>
                    <div class = "img">
                        <img class = "main" src = "<?php echo $item['mainThumbnail']?>" />
                        <span class = "cart" alt = "123"> Cart </span>
                    </div>
                    <div class = "info">
                        <p>
                            <span class = "right">评分<strong><?php echo $item['satisfyScore'] ?></strong></span>
                            <a href = "<?php echo $siteUrl.'/item/index/' . $item['id'] ?>"><?php echo $item['title'] ?></a>
                        </p>
                        <p>
                            <span class = "right">已售<strong><?php echo $item['sellNum'] ?></strong></span>
                            <strong>￥<?php echo $item['price'] ?></strong>
                        </p>
                    </div>
                </li>
            <?php endforeach?>
                <li>
                    <div class = "img">
                        <span class = "flag">新</span>
                        <img class = "main" src="http://gd3.alicdn.com/bao/uploaded/i3/T1.mvOXjFqXXXSjdfX_114544.jpg_460x460.jpg_.webp" alt="蛋糕"/>
                        <!-- cart中的数值是id -->
                        <span class = "cart" alt = "123"> Cart </span>
                    </div>
                    <div class = "info">
                        <p>
                            <span class = "right">评分<strong>4.7</strong></span>
                            <a>巧克力牧师蛋糕</a>
                        </p>
                        <p>
                            <span class = "right">已售<strong>123</strong></span>
                            <strong>￥99.00</strong>
                        </p>
                    </div>
                </li>
                <li>
                    <div class = "img">
                        <img class = "main" src="http://gd1.alicdn.com/bao/uploaded/i1/10348039655176187/T1lXmGFc8bXXXXXXXX_!!0-item_pic.jpg_460x460.jpg_.webp" alt="蛋糕" />
                    </div>
                    <div class = "info">
                        <p>
                            <span class = "right">评分<strong>4.7</strong></span>
                            <a>巧克力牧师蛋糕</a>
                        </p>
                        <p>
                            <span class = "right">已售<strong>123</strong></span>
                            <strong>￥99.00</strong>
                        </p>
                    </div>
                </li>
                <li>
                    <div class = "img">
                        <img class = "main" src="http://gd3.alicdn.com/bao/uploaded/i3/T1.mvOXjFqXXXSjdfX_114544.jpg_460x460.jpg_.webp" alt="蛋糕" />
                    </div>
                    <div class = "info">
                        <p>
                            <span class = "right">评分<strong>4.7</strong></span>
                            <a>巧克力牧师蛋糕</a>
                        </p>
                        <p>
                            <span class = "right">已售<strong>123</strong></span>
                            <strong>￥99.00</strong>
                        </p>
                    </div>
                </li>
                <li>
                    <div class = "img">
                        <img class = "main" src="http://gd3.alicdn.com/bao/uploaded/i3/T1.mvOXjFqXXXSjdfX_114544.jpg_460x460.jpg_.webp" alt="蛋糕" />
                    </div>
                    <div class = "info">
                        <p>
                            <span class = "right">评分<strong>4.7</strong></span>
                            <a>巧克力牧师蛋糕</a>
                        </p>
                        <p>
                            <span class = "right">已售<strong>123</strong></span>
                            <strong>￥99.00</strong>
                        </p>
                    </div>
                </li>
            </ul>
            <div class="snav">
                价格区间
                <input type="text" name="dprc"  value="12" />--
                <input type="text" name="tprc"  value="12" />
                <input type="submit" name="sub"  value="确定" />
                <div class="psplit">
                    <span>1/3页</span>
                    <span>第一页</span>
                    <span>上一页</span>
                    <span>下一页</span>
                    <span>跳转到 <input type="text" name="pgNum" /></span>
                    <span>尾页</span>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" charset="utf-8">
    var site_url = "<?php echo $siteUrl?>";
</script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/jquery.min.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/shop.js' ?>"></script>
</html>
