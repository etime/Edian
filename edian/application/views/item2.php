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
    <div id = "top"  >
        <div class = "clearfix" id = "itemList">
            <div class="showImg ">
                <div class = "mainImg">
                    <img id = "mainImg" src="<?php echo $item['mainThumbnail'] ?>" alt="这里是图片" />
                </div>
                <div class = "thumb"  id = "thumb">
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
<?php
//对str进行转换，方便重新js获取
if(is_array($item['attr'])){
    $str = json_encode($item['attr']['storePrc']);
    for($i = 0,$len = strlen($str) ; $i < $len ; $i++){
        if($str[$i] === '"')$str[$i] = '\'';
    }
} else $str = ' ';

?>
            <form action="<?php echo $siteUrl .'/order/add/' . $itemId  ?>" method="post" accept-charset="utf-8" class = "details" name = "<?php echo  $str ?>" >
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
                        <strong id = "score"><?php echo $item['satisfyScore'] ?></strong>/10<a class = "cnt"> 共<?php  echo $comment ? count($comment) : 0?>条</a>
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
                        <span><strong id = "store" class = "storeNum"><?php echo $item['storeNum'] ?></strong>件</span>
                    </li>
                    <?php
                    if(is_array($item['attr'])){
                        $cnt = 0;
                        foreach ($item['attr']['idx'] as $key => $value) {
                            $list = "<li class = 'clearfix'><span class = 'item' style = 'float:left'>" . $key . "</span>";
                            $list.= "<ul class = 'attr' name = '" . $cnt. "'>";
                            for ($i = 0 , $len = count($value); $i < $len; $i++) {
                                $attr = $value[$i];
                                 if($attr['img']){
                                    $list .= "<li><img  class = 'attrValue' src = '" . $attr['img'] . "' alt = '" . $attr['font']. "' title = '" . $attr['font'] . "' name = '" . $i. "'><span class = 'attrValue' style = 'display:none' alt = '" . $attr['font'] . "' name = '" . $i . "'>" . $attr['font']. "</span></li>";
                                } else {
                                    $list .= "<li><span class = 'attrValue' alt = '" . $attr['font'] . "' title = '" . $attr['font'] . "' name = '" . $i. "'>" . $attr['font']. "</span></li>";
                                }
                            }
                            $list.="</ul></li>";
                            echo $list;
                        }
                        $cnt ++;
                    }
                    ?>
                    <!-- 这里由item.js sellNum控制-->
                    <li id = "NumCon">
                        <span class = "item">购买量</span>
                        <input type="button" name="dec"  value="-" />
                        <input type="text" name="buyNum" value = "1" />
                        <input type="button" name="add"  value="+" />
                    </li>
                </ul>
                <button name = "toCart" class = "toCart">加入购物车</button>
             </form>
        </div>
    </div>
    <div id = "detail" class = "clearfix">
        <div class = "store">
            <div class = "">
                <h3>店铺信息</h3>
                <div class = 'storelogo'>
                    <img src = "<?php echo $store['logo'] ?>" alt = "图片" id = "logo"/>
                    <p>
                        <a class="bton" href = "<?php echo $siteUrl . '/shop/index/' . $store['storeId'] ?>"> <?php echo $store['name'] ?></a>
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
            <ul class="ittab clearfix" id = "ittab">
                <li name = "good"><h3>商品详情</h3></li>
                <li name = "ucom"><h3 style="border-right:none">评价</h3></li>
            </ul>
            <div>
                <div id = "good">
                    <?php echo $item['detail'] ?>
                </div>
                <ul id = "ucom" class = "ucom" style = "display:none">
                <?php for($i = 0 ,$len = $comment ? count($comment) : 0; $i < $len ; $i++):?>
                <?php
                    $com = $comment[$i];
                    $context = $com['context'];
                    $head = $context[0];
                ?>
                    <li class = "clearfix">
                        <div class = "cuser">
                            <img src = "http://img1.bdstatic.com/img/image/694f9dcd100baa1cd110f5b0146bb12c8fcc2ce2de2.jpg" />
                            <p><?php echo $head['0']['nickname'] ?></p>
                        </div>
                        <div class = "comt">
                            <p>
                                <span><?php echo $head[2] ?></span>
                                <span>质量评分:<strong> <?php echo $com['score']?></strong>/10</span>
                            </p>
                            <blockquote>
                                <?php echo $head[3] ?>
                            </blockquote>
                            <ul>
                            <?php for($i = 1 , $len = count($context) ; $i < $len ; $i++): ?>
                                <li class = "reply">
                                    <div>
                                        <a href = "www.baidu.com">王二</a>
                                        <span>回复</span>
                                        <a href = "王二的冬季">王二的东西几</a>
                                        <span>呵呵，人间不柴dfas asdfas df asd fa sdf as sd f asdf asd fa sdf asd fas df asdf ads f asdf asd f 地方商店商店 商店还是地方商店 商店 是
                                        </span>
                                    </div>
                                    <p style = "text-align:right">
                                        <a href = "<?php echo $com['id'] ?>">回复</a>
                                        <span> 2012-12-21</span>
                                    </p>
                                </li>
                            <?php endfor ?>
                            </ul>
                        </div>
                    </li>
                <?php endfor ?>
                </ul>
            </div>
        </div>
    </div>
    <div id = "footer">
    </div>
</body>
<script type="text/javascript" charset="utf-8">
    var site_url = "<?php echo $siteUrl ?>";
    var baseUrl  = "<?php echo $baseUrl ?>";
    var itemId   = "<?php echo $itemId ?>";
</script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl. 'js/jquery.min.js'?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl. 'js/cart3.js'?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl. 'js/item.js'?>"></script>
</html>
