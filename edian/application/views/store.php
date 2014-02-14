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
            <a href = "<?php echo $siteUrl.'/shop/index/' .$storeId ?>"><li <?php  if(!$key) echo "class = 'ccd'"?> >全部</li></a>
                <?php foreach ($category  as $value): ?>
                    <a href = "<?php echo $siteUrl . '/shop/select/' . $storeId . '/' . '?name='.$value?>"><li <?php if($key === $value) echo "class = 'ccd'"?>> <?php echo $value ?></li></a>
                <?php endforeach?>
            </ul>
            <form class = "shopsea" action="<?php echo $siteUrl . '/shop/search/' .$storeId ?>" method="get" accept-charset="utf-8">
                <div>
                    <input type="text" name="key" id="sea"  placeholder = "搜索" autofocus = 'off'/>
                </div>
                <input type="submit" name="but"  value="店内搜" />
            </form>
        </div>
    </div>
    <div id = 'body' class = "width clearfix">
        <div id = "side">
            <div class = "stCom block">
            <!-- 店铺评分，商店距离，-->
                <h3>何氏专辑店</h3>
                <blockquote>
                    银鳞胸甲，蓝色品质，五金一件，先到先得
                </blockquote>
                <img src="<?php echo $logo?>" alt="商店logo" />
            </div>
            <div class = "store block">
                <p>
                    <span class = "item">店铺评分</span>
                    <strong class = "bc"><?php echo $credit ?></strong>
                </p>
                <p><span class = "item">距离您</span>    <strong class = "bc">4.5</strong>km</p>

                <p><span class = "item">电话</span><?php  echo $servicePhone?></p>
                <p><span class = "item">客服 </span><?php  echo $serviceQQ?></p>
                <div class = "bustime clearfix">
                    <span class = "item">营业时间</span>
                    <ul alt = "<?php echo $deliveryTime ?>">
                        <li>9:00-12:00</li>
                        <li>9:00-12:00</li>
                        <li>9:00-12:00</li>
                    </ul>
                </div>
                <p>
                    <span class = "item">送货速度</span>
                    <strong><?php echo $duration ?></strong>分钟
                </p>
                <p><span class = "item">送货范围</span><strong><?php echo $deliveryArea ?></strong>米</p>
                <img id = "mapImg" src = "<?php echo $baseUrl.'image/52/mix/map.png' ?>" alt = "地图图片" title = "双击打开地图" />
            </div>
        </div>
        <div class = "good block">
            <h5>
                <a href = "<?php echo $siteUrl ?>">
                    e点
                </a>
                    >>
                <a href = "<?php echo $siteUrl .'/shop/index/' .$storeId ?>">指尖蛋糕店</a>
                >>
                <?php if($key) echo $key ;else echo "全部"?>
                <span>共35件商品</span>
            </h5>
            <div class="snav">
                价格区间
                <input type="text" name="dprc"  value="12" />--
                <input type="text" name="tprc"  value="12" />
                <input type="submit" name="sub"  value="确定" />
<!--
                <div class="psplit">
                    <span>1/3页</span>
                    <span>第一页</span>
                    <span>上一页</span>
                    <span>下一页</span>
                    <span>跳转到 <input type="text" name="pgNum" /></span>
                    <span>尾页</span>
                </div>
-->
            <?php
                echo $pageNumFooter;
            ?>
            </div>
            <ul class = "goodlist clearfix">
            <?php for($i = 0,$len = ($item ? count($item) : 0); $i < $len; $i++): ?>
                <?php
                    $val = $item[$i];
                ?>
                <li>
                    <div class = "img">
                        <img class = "main" src = "<?php echo $val['mainThumbnail']?>" />
                        <span class = "cart" alt = "123"> Cart </span>
                    </div>
                    <div class = "info">
                        <p>
                            <span class = "right">评分<strong><?php echo $val['satisfyScore'] ?></strong></span>
                            <a href = "<?php echo $siteUrl.'/item/index/' . $val['id'] ?>"><?php echo $val['title'] ?></a>
                        </p>
                        <p>
                            <span class = "right">已售<strong><?php echo $val['sellNum'] ?></strong></span>
                            <strong>￥<?php echo $val['price'] ?></strong>
                        </p>
                    </div>
                </li>
            <?php endfor?>
            <p><?php if($len === 0) echo '没有商品哦'?></p>
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
                <!--
                                <div class="psplit">
                                    <span>1/3页</span>
                                    <span>第一页</span>
                                    <span>上一页</span>
                                    <span>下一页</span>
                                    <span>跳转到 <input type="text" name="pgNum" /></span>
                                    <span>尾页</span>
                                </div>
                -->
                <?php
                    echo $pageNumFooter;
                ?>
            </div>
        </div>
    </div>
<!--
    <form action="<?php $siteUrl . '/order/setPrint'?>" method="post" accept-charset="utf-8" id = "dcart" class = "dcart">
        <div class="info">
            <p class = "addr">斯蒂芬斯蒂芬商店 </p>
            <div class = "buyer">
                <p>豆家敏收</p>
                <p>12832321222</p>
            </div>
        </div>
        <div class="shop">
            <p title = "店铺小计/最低起送价" class = "tp">
                <span class = "cnt"><span class = 'cntNum'>12.02</span>/<span class = "sendPrc">15</span></span>
                <input type="checkbox" name="chose"  />
                <span>指尖蛋糕店</span>
            </p>
            <table class = "clist" border = "1">
                <tr>
                    <td>
                        <input type="checkbox" name="tobuy[]" value = "1" checked = "checked"/>
                    </td>
                    <td>
                        <img src="http://c.hiphotos.baidu.com/image/w%3D2048/sign=22a06418be315c6043956cefb989ca13/c83d70cf3bc79f3d3a822c3db8a1cd11728b2958.jpg" alt="zhoutong" />
                    </td>
                    <td class = "title">
                        <p title = "牧师蛋糕是世界上最好的蛋糕">牧师蛋糕是世界上最好吃的东西</p>
                        <p>(巧克力味道)(红色)</p>
                    </td>
                    <td>
                        <p class = "sp">￥<span class = "price">18.00</span> x <input type="text" name="ordNum"  value="3" /></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tobuy[]" value = "1" />
                    </td>
                    <td>
                        <img src="http://c.hiphotos.baidu.com/image/w%3D2048/sign=22a06418be315c6043956cefb989ca13/c83d70cf3bc79f3d3a822c3db8a1cd11728b2958.jpg" alt="zhoutong" />
                    </td>
                    <td class = "title">
                        <p title = "牧师蛋糕是世界上最好的蛋糕">牧师蛋糕是世界上最好吃的东西</p>
                        <p>(巧克力味道)(红色)</p>
                    </td>
                    <td>
                        <p class = "sp">￥<span>18.00</span> x 3</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="shop">
            <p title = "店铺小计/最低起送价" class = "tp">
                <span class = "cnt"><span>12.02</span>/15</span>
                <input type="checkbox" name="chose"  />
                <span>指尖蛋糕店</span>
            </p>
            <table class = "clist" border = "1">
                <tr>
                    <td>
                        <input type="checkbox" name="tobuy[]" value = "1" />
                    </td>
                    <td>
                        <img src="http://c.hiphotos.baidu.com/image/w%3D2048/sign=22a06418be315c6043956cefb989ca13/c83d70cf3bc79f3d3a822c3db8a1cd11728b2958.jpg" alt="zhoutong" />
                    </td>
                    <td class = "title">
                        <p title = "牧师蛋糕是世界上最好的蛋糕">牧师蛋糕是世界上最好吃的东西</p>
                        <p>(巧克力味道)(红色)</p>
                    </td>
                    <td>
                        <p class = "sp">￥<span class = "price">18.00</span> x 3</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tobuy[]" value = "1" />
                    </td>
                    <td>
                        <img src="http://c.hiphotos.baidu.com/image/w%3D2048/sign=22a06418be315c6043956cefb989ca13/c83d70cf3bc79f3d3a822c3db8a1cd11728b2958.jpg" alt="zhoutong" />
                    </td>
                    <td class = "title">
                        <p title = "牧师蛋糕是世界上最好的蛋糕">牧师蛋糕是世界上最好吃的东西</p>
                        <p>(巧克力味道)(红色)</p>
                    </td>
                    <td>
                        <p class = "sp">￥<span>18.00</span> x 3</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class = "con">
            <div>
                <p>共计<span>￥<strong id = "total">1123</strong></span></p>
                <p>查看详情</p>
            </div>
            <input type="submit" name="cart"  value="下单" />
        </div>
    </form>
-->
</body>
<script type="text/javascript" charset="utf-8">
    var site_url = "<?php echo $siteUrl?>";
    var baseUrl = "<?php echo $baseUrl ?>";
    var storeId = "<?php echo $storeId ?>";
</script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/jquery.min.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/shop.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/cart3.js' ?>"></script>
</html>
