<!DOCTYPE html>
<html lang = "en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title><?php echo $user_name?>的空间</title>
<?php
    $siteUrl = site_url();
    $baseUrl = base_url();
?>
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/userSpace.css')?>" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/cart.css')?>" type="text/css" media="screen" charset="utf-8">
    <link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
<script type="text/javascript" >
    var user_id = "<?php echo $this->session->userdata('user_id')?>";
    var site_url = "<?php echo site_url()?>";
    var base_url = "<?php echo base_url()?>";
//master 和 lestprc 需要额外添加
    var masterId = "<?php echo $masterId ?>";
    var masterName = "<?php echo $user_name ?>";
    var lestPrc = "<?php echo $lestPrc ?>";
    //这些都是常量，不允许修改,不允许修改的常量使用大写，以后
    var lsp = Array();//保存商家的最低起送价的信息
</script>
</head>
<body>
    <!------------------header开始---------------------->
    <div id="header" class = "header" >
            <ul class = "clearfix">
                <a href = "<?php echo $siteUrl?>"><li class = "st">e点</li></a>
                <a href = "#name"><li class = "st">名片</li></a>
                <a href = "#list">
                    <li class = "st index">清单</li>
                </a>
                <li class = "st">
                    <form action="#" method="get" id = "keySea" accept-charset="utf-8">
                        <input type="text" name="sea" id="sea" value=""  autofocus = "autofocus"/>
                        <input type="submit" name="sub" id="sub" value="搜站内" />
                    </form>
                 </li>
            </ul>
    </div>
    <!---------------------结束------------------------>
<?php
    $torderNum = 0;
    for($i = count($cont)-1;$i>=0;$i--){
        $torderNum+=$cont[$i]["order_num"];
    }
?>
    <!--这里显示的是店家的一些信息-->
    <div id = "info" class = "block clearfix">
        <div class = "infoLef">
            <a name = "name"></a>
            <h2> <?php echo $user_name ?></h2>
            <?php
                if($intro){
                    echo "<p><span>公告:</span><strong>".$intro."</strong></p>";
                }
                if($contract1){
                    echo "<p><span>联系方式:</span>".$contract1."</p>";
                }
                if($contract2){
                    echo "<p><span>QQ:</span>".$contract2."</p>";
                }
                if($work){
                    $work2 = explode(";",$work);
                    $temp = "";
                    for($i = 0,$lwork = count($work2);$i < $lwork;$i++){
                        if($work2[$i]){
                            $temp.=$work2[$i].",";
                        }
                    }
                    echo "<p><span>主营业务:</span>".$temp."</p>";
                }
                if($addr){
                    echo "<p><span>地址:</span>".$addr."</p>";
                }
                if($impress){
                    echo "<p><span>印象:</span>".$impress."</p>";
                }
            ?>
            <p><span>最近订单数:</span> <?php echo $torderNum ?></p>
            <p><span>营业时间:</span><?php echo $operst ?>--<?php echo $opered ?></p>
        </div>
        <div class = "infoRit">
            <img src = "<?php echo $baseUrl."upload/".$user_photo ?>">
        </div>
    </div>
    <!--信息结束-->
<!-- 这里是最近动态，包括邮箱，图片，还有帖子,如果有动态，则显示，否则不显示，邮箱在前，帖子其次，其他看情况-->

    <div id="recent">
        <a name = "list"></a>
        <p class="partT"><span>商品清单</span></p>
        <ul class = "clearfix content">
    <?php
        $flag = strpos($work,"外卖");
        if($cont)$len = count($cont);
        else $len = 0;
    ?>
        <?php for($i = 0;$i < $len;$i++):?>
    <?php
    $temp = $cont[$i];
    ?>
            <li class = "block">
                <a href = "<?php echo $siteUrl.('/item/index/').$temp['id']?>">
                    <img class = "block liImg" src = "<?php echo $baseUrl.('thumb/'.$temp['img'])?>" alt = "<?php echo "商品图"?>" />
                </a>
                <a class = "detail" href = "<?php echo $siteUrl.('/item/index/').$temp['id']?>" name = "<?php echo $temp['keyword']?>">
                    <?php echo $temp["title"]?>
                </a>
                <p class = "user st">
                    ￥<em><?php echo $temp["price"] ?></em>
                    <span>订单数:<?php echo $temp["order_num"] ?><span>
                    <?php
                        if($temp["comment_num"]){
                            $now = 100*($temp['judgescore']/$temp['comment_num']);
                            echo "<span>评分:".(floor($now)/100)."</span>";//保留两位整数
                        }
                    ?>
                </p>
                <p class = "user st">
                    评价:<?php echo $temp["comment_num"]?>/浏览:<?php echo $temp["visitor_num"]?>
                    <?php
                        if($flag){
                            echo "<span class = 'item' name = '".$temp["id"]."' title = '".$temp["price"]."'>加入购物车</span>";
                        }
                    ?>
                     <span class = "time"></span>
                </p>
            </li>
        <?php endfor?>
        </ul>
    </div>
    <div class = "botmenu" id = "botmenu" >
        <div id = "cart"  style = "display:none" class = "clearfix">
            <div id = "ordor" class = "ordor clearfix">
            </div>
            <ul class = "order" id = "order" >
            </ul>
        </div>
        <p class = "atten">
            <span id = "cap"></span>
            <span id = "atten"></span>
        </p>
    </div>
<script type="text/javascript" src="<?php echo $baseUrl.('js/jquery.js')?>"> </script>
<script type="text/javascript" src="<?php echo $baseUrl.('js/cookie.js')?>"> </script>
<script type="text/javascript" src="<?php echo $baseUrl.('js/cart.js')?>"> </script>
<script type="text/javascript" src="<?php echo $baseUrl.("js/space.js")?>"></script>

<!--the end of the recent-->
<!-----------join在这里由js生成-------------->
<!--这里显示的是空间主人的朋友的动态，按照value排序吧,没有顺序，随意排-->
</body>
</html>
