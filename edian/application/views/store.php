<?php
    $baseUrl = base_url();
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
    <div id = "nav">
        <div class="cnav width clearfix">
            <h4>商品类别</h4>
            <h4>首页</h4>
            <h4>二手</h4>
            <h4>活动</h4>
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
            <ul id = "list" class = 'list'>
        <?php foreach ($category as $value):?>
            <li><?php echo $value ?></li>
        <?php endforeach?>
            </ul>
            <div class = "store">
                <h5>店铺信息</h5>
                <div class = "bustime clearfix">
                    <span class = "item">营业时间</span>
                    <ul>
                        <li>9:00-12:00</li>
                        <li>9:00-12:00</li>
                        <li>9:00-12:00</li>
                    </ul>
                </div>
                <p>
                    <span class = "item">店铺评分</span>
                    <strong class = "bc">9.3</strong>
                </p>
                <p><span class = "item">送货范围</span><strong>900</strong>米</p>
                <p>
                    <span class = "item">送货速度</span>
                    <strong>30</strong>分钟
                </p>
                <p><span class = "item">距离    </span>    <strong>4.5</strong>km</p>
                <p><span class = "item">客服电话</span>12321232211</p>
                <p><span class = "item">客服QQ  </span>123212123</p>
                <img src = "<?php echo $baseUrl.'image/52/mix/map.png' ?>" alt = "地图图片">
            </div>
        </div>
        <div class = "good">
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
                            <a><?php echo $item['title'] ?></a>
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
</html>
