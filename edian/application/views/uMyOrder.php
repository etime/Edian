<?php
/**
 * @name        ../../views/uMyOrder.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-26 12:59:34
 */
    $baseUrl = base_url();
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
        <div class = "cart">
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
                    <li class="seller">dianpu mingz+</li>
                    <li class="orderId"><?php echo  $seller .'_' . strtotime($time) ?></li>
                    <li class="time"><?php  echo $time?></li>
                    <li class="comment"> ping lun  cic+gouma+</li>
                </ul>
                <table border="none" class = "det">
                    <tr class = "tr">
                        <td class="state">yingjia </td>
                        <td class="cnt">$20.21 </td>
                        <td class = "good">
                            <table border="none">
                            <?php while(($order[$i]['time'] === $time )&& ($order[$i]['seller'] === $seller )):?>
                                <tr>
                                    <td> <img src="" alt="store Img" /></td>
                                    <td>
                                         <p> sheng fan chuli tuan tuan zhang</p>
                                        <p> note </p>
                                    </td>
                                    <td class="orderNum">123</td>
                                    <td class="sp">dan ping lun</td>
                                </tr>
                            <?php
                                $i++;
                            ?>
                            <?php  endwhile?>
                            </table>
                        </td>
                       <td class="num">sdfa sadfas sdf</td>
                       <td class="price">sdfa sadfas sdf</td>
                        <td class="oper">dasd sdf as</td>
                    </tr>
                </table>
            </div>
            <?php endfor?>
        </div>
    </div>
    <div class="reply" id = "reply">
        <p>
            <span class="item">songhuo sudu :</span>
            <span class = "star sec"></span>
        </p>
        <p>
            <span class="item">songhuo sudu :</span>
            <span class = "star sec"></span>
        </p>
        <div>
            <span class="item"></span>
            <textarea name="content" class = "sec"></textarea>
        </div>
    </div>
</body>
</html>
