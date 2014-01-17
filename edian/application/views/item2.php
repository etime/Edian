<?php
$baseUrl = base_url();
$siteUrl = site_url();
?>
<!DOCTYPE html>
<html lang = "zh">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="<?php echo $baseUrl .'css/item2.css' ?>" type="text/css" media="all" />
    <title>
    <?php echo $item['title'] ?>
</title>
</head>
<body>
    <!-- 这个什么class header 是伪造的header,可以不存在的。。-->
    <div class="header">
    <?php
        $this->load->view("homeHeader");
    ?>
    <!--
        <div class="tab">
            <ul class="clearfix">
                <li>首页</li>
                <li>商城</li>
                <li>二手</li>
                <li>活动</li>
            </ul>
        </div>
    -->
        <div class="path">
            <div>
                <a href="<?php echo $siteUrl ?>">e点</a> >>
<!--
                <a href="<?php echo $siteUrl .'/shop/index/' . $store['storeId'] ?>">商城</a>>>
-->
                <a href="<?php echo $siteUrl .'/shop/index/' . $store['storeId'] ?>"><?php echo $store['name'] ?></a> >>
                <a><?php echo $item['title'] ?></a>
            </div>
        </div>
    </div>
    <div id = "top" >
        <div class = "clearfix">
            <div class="showImg ">
                <div id = "mainImg" class = "mainImg">
                    <img src="<?php echo $item['mainThumbnail'] ?>" alt="这里是图片" />
                </div>
                <div class = "thumb">
                    <img src="<?php echo $item['mainThumbnail'] ?>" alt="这里是图片" />
                <?php
                    if($item['thumbnail']){
                        foreach ($item['thumbnail'] as $value) {
                            echo "<img src = '" . $value . "' alt = '图片' />";
                        }
                    }
                ?>
                </div>
            </div>
            <!--
            <div class="details">
            -->
            <form action="<?php echo $siteUrl .'/order/' . $itemId  ?>" method="post" accept-charset="utf-8" class = "details">
                <ul>
                <h2><?php echo $item['title'] ?></h2>
        <!--
                    <p class = 'suply'>
                        <?php echo $item['briefInfo'] ?>
                    </p>
        -->
                    <li class="priStore">
                        <span class="item">价格</span>
                        <span class="ps"><strong id = "price" class = "price"><?php echo $item['price'] ?></strong>元</span>
                        <span class="item">评分</span>
                        <span class="ps">
                        <strong id = "score"><?php echo $item['satisfyScore'] ?></strong>/10<a class = "cnt"> 共4774条</a>
                        </span>
                    </li>
                    <li>
                        <span class="item">月销量</span>
                        <strong id = "num">
                           <?php echo $item['orderNum'] ?>
                        </strong>
                    </li>
                    <li>
                        <span class = "item">库存</span>
                        <span><strong id = "store"><?php echo $item['storeNum'] ?></strong>件</span>
                    </li>
                    <li class = "clearfix">
                    <?php
                    if(is_array($item['attr'])){
                        foreach ($item['attr']['idx'] as $key => $value) {
                            $list = "<span class = 'item' style = 'float:left'>" . $key . "</span>";
                            $list.= "<ul class = 'attr'>";
                                foreach ($value as $attr) {
                                    if($attr['img']){
                                        $list .= "<li><img  class = 'attrValue test' src = '" . $attr['img'] . "' alt = '" . $attr['font']. "'><span class = 'attrValue' style = 'display:none'>" . $attr['font']. "</span></li>";
                                    } else {
                                        $list .= "<li><span class = 'attrValue' alt = '" . $attr['font'] . "'>" . $attr['font']. "</span></li>";
                                    }
                                }
                            $list.="</ul>";
                            echo $list;
                        }
                    }
                    ?>
                    </li>
                    <li>
                        <span class = "item">购买量</span>
                        <input type="text" name="buyNum" value = "2" />
                    </li>
                </ul>
                <button name = "toCart">加入购物车</button>
             </form>
        </div>
    </div>
    <div id = "detail">
        <div class = "store">
            <div class = "">
                <h3>店铺信息</h3>
                <div class = 'storelogo'>
                    <img src = "<?php echo $store['logo'] ?>" alt = "图片" id = "logo"/>
                    <p>
                        <a class="button" href = "<?php echo $siteUrl . '/shop/index/' . $store['storeId'] ?>"> <?php echo $store['name'] ?></a>
                    </p>
                </div>
                <p>
                    <span class="list">电话:</span>
                    <span id = "phone"><?php echo $store['servicePhone'] ?></span>
                </p>
                <p>
                    <span class = "list">QQ:</span>
                    <span> <?php  echo $store['serviceQQ'] ?></span>
                </p>
                <p>
                    <span class="list">地址:</span>
                    <span class="storeAddr">
                        <?php echo $store['address']?>
                    </span>
                </p>
            </div>
            <div >
                <!--
                <h3>本店信息</h3>
                -->
                <div class="comment clearfix">
                    <div class="score">
                        <h5>店铺评分</h5>
                        <span><em>7.8</em>/10</span>
                    </div>
                    <div class = "speed">
<!--
                        <h5>本店共1345人评价</h5>
-->
                        <p>送货速度:<em>4.3</em></p>
                        <p>店月销量:<em>10132</em></p>
                    </div>
                </div>
            </div>
        </div>
        <div id = "item">
            <ul class="ittab">
                <li><h3>商品详情</h3></li>
                <li><h3 style="border-right:none">评价</h3></li>
            </ul>
        </div>
    </div>
    <div id = "footer">
    </div>
</body>
<script type="text/javascript" charset="utf-8">
    var site_url = "<?php echo $siteUrl ?>";
    var itemId = "<?php echo $itemId ?>";
</script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl. 'js/jquery.min.js'?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl. 'js/cart2.js'?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl. 'js/item.js'?>"></script>
</html>
