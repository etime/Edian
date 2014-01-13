<?php
$baseUrl = base_url();
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
                <a href="">e点</a>>>
                <a href="">商城</a>>>
                <a href="">e何氏专辑</a>>>
                <a href="">林夕《大明宫词》</a>
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
            <div class="details">
                <ul>
                <h2><?php echo $item['title'] ?></h2>
        <!--
                    <p class = 'suply'>
                        <?php echo $item['briefInfo'] ?>
                    </p>
        -->
                    <li class="priStore">
                        <span class="item">价格</span>
                        <span class="ps"><strong id = "price"><?php echo $item['price'] ?></strong>元</span>
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
                    <li >
<?php
if(is_array($item['attr'])){
    foreach ($item['attr']['idx'] as $key => $value) {
        $list = "<span class = 'item' style = 'float:left'>" . $key . "</span>";
        $list.= "<ul class = 'attr'>";
            foreach ($value as $attr) {
                $list .= "<li><span>" . $attr['font']. "</span></li>";
            }
        $list.="</ul>";
        echo $list;
    }
}
?>
<!--
                        <span class="item" style="float:left">颜色</span>
                        <ul class="attr">
                            <li><span>红色</span></li>
                            <li><span>红色</span></li>
                            <li><span>红色</span></li>
                        </ul>
                    </li>
-->
                </ul>
                <div id = "tobuy">
                    <button name = 'instant' style = "display:none">立即购买</button>
                    <button name = "toCart">加入购物车</button>
                </div>
            </div>
        </div>
    </div>
    <div id = "detail">
        <div class = "store">
            <div class = "">
                <h3>店铺信息</h3>
                <div class = 'storelogo'>
                    <img src = "../../image/store.jpg" alt = "图片" />
                    <a class="button"> <?php echo $store['name'] ?></a>
                </div>
                <p>
                    <span class="list">电话:</span>
                    <span id = "phone"><?php echo $store['servicePhone'] ?></span>
                </p>
                <p>
                    <span class = "list">QQ</span>
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
</html>
