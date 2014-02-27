<?php
/**
 * @name        ../../views/uMyOrder.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-26 12:59:34
 */
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>用户中心</title>
    <link rel="stylesheet" href="<?php echo $baseUrl . 'css/myorder.css' ?>" type="text/css" media="all" />
</head>
<body>
    <?php
        $this->load->view("homeHeader");
    ?>
    <div class = "content width">
        <div class="route">
            <p>
            <span>
                您的位置:
            </span>
                <a>首页</a>
                >
                <a>我的E点</a>
                >
                <a href = "#">已完成订单</a>
            </p>
        </div>
        <div class = "dir">
            <ul>
                <p class="title">我的E点</p>
                <li>已完成订单</li>
                <li>购物车</li>
                <li>设置</li>
                <li>我的收藏</li>
                <li>我的积分</li>
                <li>售后维权</li>
            </ul>
        </div>
        <div class = "cart" id = "cart">
            <ul class = "header clearfix">
                <li class = "state">交易状态</li>
                <li class = "cnt">总额</li>
                <li class = "good">商品</li>
                <li class="num">数量</li>
                <li class="price">价格</li>
                <li class="oper">操作</li>
            </ul>
            <?php  for($i = 0, $len = count($order) ; $i < $len ; ):?>
            <?php
            $value = $order[$i];
                $time = $value['time'];
                $seller = $value['seller'];
            ?>
            <div class="store">
                <ul class = "user clearfix">
                <li class="seller"><?php echo $order[$i]['selinf']['nickname'] ?></li>
                    <li class="orderId">订单编号: <?php echo  $seller .'_' . strtotime($time) ?></li>
                    <li class="time"><?php  echo $time?></li>
                    <li class="comment">
                        <input type="button" name="toreply"  class = "btn button glow button-flat re" value="对本次购买评论" />
                        <div class="reply" id = "reply" style = "display:none">
                            <p class = "clearfix">
                                <span class="item">送货速度 :</span>
                                <span class = "star sec"></span>
                            </p>
                            <p class = "clearfix">
                                <span class="item">服务态度 :</span>
                                <span class = "star sec"></span>
                            </p>
                            <div class = "clearfix">
                                <span class="item">评价 :</span>
                                <textarea name="content" class = "sec"></textarea>
                            </div>
                        </div>
                    </li>
                </ul>
                <table border="none" class = "det">
                    <tr class = "tr">
                    <td class="state"><?php  echo $order[$i]['state']?> </td>
                    <?php
                        $ori = $i;
                        $cnt = 0;
                        while( ($len > $i ) && ($order[$i]['time'] === $time )&& ($order[$i]['seller'] === $seller )){
                            $cnt += (int)($order[$i]['info']['orderNum'] ) * (float)$order[$i]['item']['price'];
                            $i++;
                        }
                        $i = $ori;
                    ?>
                        <td class="cnt"><?php echo $cnt?> </td>
                        <td class = "li">
                            <table border="none">
                            <?php while( ($len > $i ) && ($order[$i]['time'] === $time )&& ($order[$i]['seller'] === $seller )):?>
                                <?php
                                    $val = $order[$i];
                                ?>
                                <tr>
                                    <td>
                                        <a href = "<?php echo $siteUrl .'/item/index/' . $val['item_id'] ?>">
                                            <img src="<?php echo $val['item']['mainThumbnail'] ?>" alt="store Img" />
                                         </a>
                                    </td>
                                    <td class = "good">
                                        <a href = "<?php echo $siteUrl .'/item/index/' . $val['item_id'] ?>">
                                            <p><?php echo $val['item']['title'] . $val['info']['info'] ?> </p>
                                        </a>
                                    <p>
                                    <?php
                                    if($val['info']['more'])
                                        echo '备注:' . $val['info']['more']
                                    ?>
                                    </p>
                                    </td>
                                    <td class="num"><?php echo $val['info']['orderNum'] ?></td>
                                    <td class="price">
                                        <?php echo $val['item']['price'] ?>
                                    </td>
                                    <td class = "oper">
                                        <input type="button" name="signal"  class = "btn button glow button-flat re" value="单品评论" />
                                        <div class="reply" id = "reply" style = "display:none">
                                            <p class = "clearfix">
                                                <span class="item">商品质量 :</span>
                                                <span class = "star sec"></span>
                                            </p>
                                            <div class = "clearfix">
                                                <span class="item">评价 :</span>
                                                <textarea name="content" class = "sec"></textarea>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $i++;
                            ?>
                            <?php  endwhile?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <?php endfor?>
        </div>
    </div>
</body>
<script src="<?php echo $baseUrl . '/js/jquery.min.js' ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $baseUrl . '/js/myorder.js' ?>" type="text/javascript" charset="utf-8"></script>
</html>
