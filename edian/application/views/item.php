<!DOCTYPE html>
<html lang = "en">
<head>
<?php
$siteUrl = site_url();
$baseUrl = base_url();
if($item['attr']){
    $attr = json_encode($item['attr']['storePrc']);
}else {
    $attr = '';
}
for ($i = 0,$len = strlen($attr); $i < $len ; $i++) {
    if($attr[$i] === '"')$attr[$i] = '\'';
}
echo $this->session->userdata('userId');
?>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title>E点</title>
    <link rel="stylesheet" href=" <?php echo $baseUrl."css/item.css" ?>" type="text/css" media="all" />
    <link rel="stylesheet" href=" <?php echo $baseUrl."css/cart.css" ?>" type="text/css" media="all" />
<script type="text/javascript" charset="utf-8">
var attr = "<?php echo $attr ?>";
var user_id = "<?php  echo $this->session->userdata('userId')?>";
var site_url = "<?php echo $siteUrl ?>";
var itemId = "<?php  echo $itemId?>";
</script>
</head>
<body>
<?php
    $this->load->view("header");
    $comtLen = 0;
    //  评价的条数
?>
    <div class = "nav body" >
        <a href = "<?php echo $baseUrl ?>">首页</a>
        >>
        <?php
    /*
        if($user_type == 1 && ((strpos($work,"外卖") !== FALSE)||(strpos($work,"送货")))){
            echo "<a href = '".$siteUrl."/waimai/index' />送货上门</a> >>";
        }
            echo "<a href = '".$siteUrl."/space/index/".$author_id."'>".$user_name."</a>";
     */
        ?>
    </div>
    <div id="body"  class = "clearfix body">
        <div class = "clearfix imgA">
    <!--集中了对图片的显示-->
            <ul id = "thumb" class = "thumb">
                <li> <img src = " <?php echo $item['mainThumbnail'] ?>" /></li>
                <?php foreach ($item['thumbnail'] as $value) :?>
                <li> <img src = " <?php echo $value ?>" /></li>
                <?php endforeach?>
            </ul>
            <img id = "mImg" src = " <?php echo $item['mainThumbnail']?>" />
        </div>
        <div class = "det clearfix">
            <form action = "<?php echo $siteUrl.'/order/index/'.$itemId ?>" enctype = "multipart/form-data" method = "post" class = "info" accept-charset = "utf-8" id = "fmIf">
    <!--这里将来修改成为快速购买的action -->
                <h3 id = "title">
                <?php echo $item['title'] ?>
                </h3>
                <p><span class = "item">价格:</span>￥  <em class = "sp" id = "price"> <?php echo $item['price'] ?></em></p>
                <p><span class = "item">评分:</span>
                    <span class = "sep">
                    <?php
                        if($comtLen == 0){
                            echo "0";
                        }else{
                            echo $judgescore/$comtLen;
                        }
                    ?>
                    </span>
                </p>
                <p>
                        <span class = "item">销量:</span>
                        <span class = "sep"> <?php echo $item['orderNum'] ?></span>

                        <span class = "item">评价:</span>
                        <span class = "sep">
                            <a id = "judge" href = "#tojudge" > <?php echo $comtLen ?></a>
                        </span>
                </p>
                <p>
                <input type="hidden" name="getAttr" id = "getAttr" />
                <?php
                $posX = 0;
                if($item['attr']){
                    foreach ($item['attr']['idx'] as $key => $val) {
                        echo "<p class = 'attr' alt = '$posX'><span class = 'item' >" . $key . "</span>";
                        $posY = 0;
                        foreach ($val as $itemValue) {
                            $itemValue['img'] = trim($itemValue['img']);
                            if($itemValue['img']){
                                echo "<img class = 'attrValue' alt = " . $posY . " src = '" . $itemValue['img'] . "' title = '" . $itemValue['font']. "' />";
                            } else {
                                echo "<span alt = '$posY' class = 'attrValue' title = '". $itemValue['font'] . "'>" .$itemValue['font'] . "</span>";
                            }
                            $posY++;
                        }
                        $posX++;
                        echo "</p>";
                    }
                }
                ?>
                </p>
                <p><span class = "item">营业起止时间:</span> <?php  echo $store['deliveryTime']?></p>
                <input type="hidden" name="info"  id = "info" />
                <input type="hidden" name="price"  id = "iprice" />
                <p id = "num">
                    <span class = "item">购买数量:</span>
                    <input type="text" name="buyNum" id="buyNum" value="1" />
                    <span id = "storeNum">库存: <span id = "tS"><?php echo $item['storeNum'] ?></span></span>
                        <!--totol store-->
                    <span id = "numCon">
                        <button class="inc">+</button>
                        <button  class="dec">-</button>
                    </span>
                </p>
                <?php
                //if($user_type == 1 && (strpos($work,"送货") !== FALSE))
                //这里是为了增加数据，以后要去掉上面的注释
                    echo "<p><input type = 'submit' name = 'inst' class = 'bton ba' value = 'e点购买' /><input type = 'submit' name = 'cart' class = 'bton bcl' href = 'userId/itemId' value = '加入购物车'></p>"
                ?>
            </form>
        </div>
         <div id="user" class = "user">
            <div class = "urAten">店家信息</div>
            <p><a href = "<?php echo $siteUrl."/space/index/".$item['belongsTo']?>">店主: <?php echo $store['name']?></a></p>
            <p>联系方式:<?php echo $store['servicePhone'] ?></p>
            <?php
                //将来去掉这些赋值
                if ($store['serviceQQ']) {
                    echo "<p>QQ:<a href = 'http://wpa.qq.com/msgrd?v=3&uin=".$store['serviceQQ']."&site=qq&menu=yes' target = '_blank'>".$store['serviceQQ']."</a></p>";
                }
            ?>
            <p>地址: <?php  echo $store['address']?></p>;
            <div id="allmap">
            </div>
        </div>
        <div class="pdc">
            <!-- short for product 就是介绍商品内容的页面-->
            <ul class="pg clearfix" id = "pg">
                <li class = "cse" name = "more">详情</li>
                <li name = "comment">评价</li>
                <li name = "rec">推荐</li>
            </ul>
            <div class="des" id = "des" >
                <!-- short for descript-->
                <?php echo $item['detail'] ?>
            </div>
            <div class = "dcom" id = "dcom"  style = "display:none">
                <p id = "coms" class = "coms">
                    <a name = "a">全部()</a><a name = "h">超赞(<span></span>)</a><a name = "m">还不错(<span></span>)</a><a name = "l">勉强(<span></span>)</a><a  name = "w">暴走(<span></span>)</a>
                </p>
                <ul class = "com" id = "com">
                <!-- short for comment-->
                <?php for($i = 0;$i < $comtLen;$i++):?>
                    <?php $temp = $comt[$i]?>
                    <li>
                        <p class = "cp">
                            <span >评分:</span><span class = "sp mk"> <?php echo $temp["score"] ?></span>
                            <span > <?php echo $temp["user_name"]?></span>
                            <span > <?php echo $temp["time"]?></span>
                        </p>
                        <blockquote>
                            <?php echo $temp["context"][0] ?>
                        </blockquote>
                        <?php
                            //对text进行拆解分化
                            $len = count($temp["context"]);
                            if($len > 1){
                                $reCom = "";
                                for($j = 1; $j < $len ;$j++){
                                    $re = explode("|",$temp["context"][$j]);
                                    $reCom.="<div class = 'reCom'><p>".$re[0]."</p><span>".$re[2]."</span><span>".$re[1]."</span></div>";
                                }
                                echo $reCom;
                            }
                        ?>
                        <div class = "reCom" >
                            <span name = "comRe" class = "comRe">回复</span>
                            <form action="<?php echo $siteUrl.'/item/appcom/'.$temp["id"]?>" method="post" accept-charset="utf-8" enctype = "multipart/form-data" style = "display:none">
                                <textarea  name = "context" placeholder = "评论..." ></textarea>
                                <input type="submit" name="sub" id="<?php echo $temp["id"] ?>" value="回复" />
                                <!--设置id方便插入-->
                            </form>
                        </div>
                    </li>
                <?php endfor?>
                </ul>
                <form action="<?php echo $siteUrl.'/item/newcom/'.$itemId?>" method="post" enctype = "multipart/form-data" accept-charset="utf-8" id = "comForm" class = "comForm" >
                    <textarea name="context" id="context" placeholder = "评论..."></textarea>
                    <p id = "mark">
                        评分:<span id = "txts">9</span>
                        <?php for($i = 0;$i< 10;$i++): ?>
                            <img name = "<?php echo $i ?>"/>
                        <?php endfor ?>
                        <img class = "no" name = "10"/>
                    </p>
                    <input type="hidden" name="score" id="score" value = "9" />
                    <input type="submit" name="sub" value="提交" />
                </form>
            </div>
        </div>
        <div class = "botmenu" >
            <div id = "cart"  style = "display:none">
                <div id = "ordor" class = "ordor clearfix">

<!--
                    <div class = "buton">
                        <a href = "javascript:javascript" >
                            去购物车
                        </a>
                    </div>
                    <div>
                        <p class = "addr" title="adsa a df ads fa dsf a sdf adsf a dsf asdf a ds  asdfa ">电子科技大学清水河404房sdsss asd  asd 间</p>
                        <p>手机:13648044299</p>
                    </div>
                    <div class = "buton">
                        <a href = "javascript:javascript" >
                            e点下单
                        </a>
                    </div>
-->
                </div>
                <ul class = "order" id = "order" >
<!--
                    <li class = "clearfix">
                        <a href = "javascript:javascript">
                            <img src = "http://www.edian.cn/upload/191374326184.jpg" />
                        </a>
                        <div>
                            <p>
                                红色
                            </p>
                            <p>
                                藏青色XL
                            </p>
                        </div>
                        <span>￥12.00</span>x<input type="text" name="buyNum"  value="" />
                        <a href = "javascript:javascript">删</a>
                    </li>
-->
                </ul>
            </div>
            <p class = "lok atten">
                <span id = "cap" title = "不足起送价，加2元"></span>
                <span id = "atten"></span>
                <!-- cal price-->
            </p>
        </div>
        <div id="footer">
        </div>
    </div>
    <form action="<?php echo $siteUrl.'/login/loginCheck' ?>" method="get" accept-charset="utf-8" id = "login" class = "login" style = "display:none">
        <a href = "#" id = "cel"></a>
        <p>
            用户名/手机号码:
            <input type="text" name="userName" id="userName"  />
        </p>
        <p>
            密码:
            <input type="password" name="password" id="passwd"  />
        </p>
        <input type="submit" name="losub" id="losub" value="登录" />
    </form>
    <script type="text/javascript" charset="utf-8" src = " <?php echo $baseUrl.'js/jquery.js' ?>"></script>
    <script type="text/javascript" charset="utf-8" src = " <?php echo $baseUrl.'js/cookie.js' ?>"></script>
    <script type="text/javascript" charset="utf-8" src = " <?php echo $baseUrl.'js/cart.js' ?>"></script>
    <script type="text/javascript" charset="utf-8" src = " <?php echo $baseUrl.'js/item.js' ?>"></script>
<!--
    <script type="text/javascript" charset="utf-8" src = "http://api.map.baidu.com/api?v=1.5&ak=672fb383152ac1625e0b49690797918d"></script>
    <script type="text/javascript" charset="utf-8">
    window.onload = mapInit;
    function mapInit(){
        console.log("test");
        var map = new BMap.Map("allmap");
        map.enableScrollWheelZoom();                            //启用滚轮放大缩小
        map.enableInertialDragging();
        map.enablePinchToZoom();//双指缩放
        map.enableAutoResize();
        var lat = "<?php echo $lat ?>",lng = "<?php echo $lng ?>";//可以的话，就更大体定位吧,这种方式不好
        var point = new BMap.Point(lng,lat);
        map.centerAndZoom(point,17);//默认开始定位在科大附近
    }
    </script>
-->
</body>
</html>

