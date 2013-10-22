<?php
/*************************************************************************
    > File Name :     ../../views/onTimeOrder.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-06 10:20:23
************************************************************************/

?>
<!DOCTYPE html>
<html lang = "en">
<head>
<?php
$siteUrl = site_url();
$baseUrl = base_url();
?>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title>E点</title>
    <link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/timeorder.css') ?>" type="text/css" media="all" />
<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var base_url = "<?php echo base_url()?>";
var user_name="<?php echo trim($this->session->userdata('user_name'))?>";
var user_id="<?php echo trim($this->session->userdata('user_id'))?>";
</script>
</head>
<body>
<table >
    <tr>
        <th class = "oid">订单号</th>
        <th>商品名</th>
        <th>买家信息</th>
        <th>状态</th>
        <th>下单时间</th>
<!--操作分为两种，一个已发货，一个是举报-->
    </tr>
    <tbody>
<?php
    if($order)
    $len = count($order);
    else{
        $len = 0;
    }
?>
    <?php  for($i = $len-1;$i >= 0 ;$i--):?>
        <?php
            $temp = $order[$i];
            $ordorId = $temp["ordor"];
            $usrInf = "<p>".$temp["ordorInfo"]["name"]."</p>";
            $usrInf .= "<p>手机:".$temp["ordorInfo"]["phone"]."</p>";
            $usrInf .= "<p>地址:".$temp["ordorInfo"]["addr"]."</p>";
        ?>
        <tr>
            <td> <?php echo $temp["id"] ?></td>
            <td class = "det">
                <p style = "border:none">
                    <a href = " <?php echo $siteUrl.('/item/index/').$temp['item_id'] ?>" target = "_blank"> <?php echo $temp["title"].$temp["info"]["info"] ?></a>
                    <br/>
                    <span>
                    <?php
                        $price = (float)$temp["info"]["price"];
                        $num = (int)$temp["info"]["orderNum"];
                        echo "￥".$price." x ".$num."=".($price*$num)."(元)";
                    ?>
                    </span>
                        <?php
                            if($temp["info"]["more"]){
                                echo "<br/><span>备注:".$temp["info"]["more"]."</span>";
                            }
                        ?>
                </p>
            </td>
            <td class = "addr">
                <?php echo $usrInf ?>
            </td>
            <td>
                <?php
                    if($temp["state"] == 1)echo "下单完成,期待发货..";
                    elseif($temp["state"] == 2) echo "订单打印完毕，请即时发货哦";
                    elseif($temp["state"] == 3) echo "发货了";
                    elseif($temp["state"] == 4) echo "买家签收了";
                    elseif($temp["state"] == 5) echo "<span style = 'color:#82C263'>买家在下单前改变了主意,最后还是没有买</span>";
                    elseif($temp["state"] == 6) echo "<span style = 'color:red'>退货</span>";
                ?>
            </td>
            <td> <?php echo $order[$i]["time"] ?></td>
        </tr>
    <?php endfor ?>
<!--
        <tr>
            <td>13</td>
            <td>
                <a href = "#">
                    <p>红烧鸡爪(泡椒)（散装）注:免费送我可以送好评哦</p>
                </a>
            </td>
            <td >
                ￥13.00 x 12 = 156(元)
            </td>
            <td class = "addr">
               <p>田乙的世界</p>
                <p>手机:1238320992</p>
                <p>地址:
                    清远街北巷404040号清远街北巷404040号清远街北巷404040号清远街北巷404040号清远街北巷404040号清远街北巷404040号
                </p>
            </td>
            <td>2012-2-12 12:12:12</td>
            <td>
                <a href = "#">发货</a>
                <a href = "#">拒绝</a>
                <a href = "#">举报</a>
            </td>
        </tr>
-->
    </tbody>
</table>
</body>
</html>
