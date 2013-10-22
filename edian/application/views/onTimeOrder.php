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
    <meta http-equiv="refresh" content="50">
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
<h4>2分钟内状态不变,打印机没有出纸则打印失败,请检查打印机,并联系客服</h4>
<table >
    <tr>
        <th>商品名</th>
        <th>买家信息</th>
        <th>下单时间</th>
        <th class = "oper">操作</th>
<!--操作分为两种，一个已发货，一个是举报-->
    </tr>
    <tbody>
<?php
if($order)$len = count($order);
else $len = 0;
?>
    <?php  for($i = 0;$i< $len;):?>
        <tr>
            <td class = "det">
            <?php
                $ordorId = $order[$i]["ordor"];
                $usrInf = "<p>".$order[$i]["ordorInfo"]["name"]."</p>";
                $usrInf .= "<p>手机:".$order[$i]["ordorInfo"]["phone"]."</p>";
                $usrInf .= "<p>地址:".$order[$i]["ordorInfo"]["addr"]."</p>";
                $calId = "";
            ?>
            <?php while(($i < $len)&&($ordorId == $order[$i]["ordor"])):?>
            <?php
                $temp = $order[$i];
                $calId .= $temp["id"]."|"
            ?>
                <p>
                    <span>订单号:
                    <span class = "orderNum"> <?php echo $temp["id"] ?></span></span>
                    <?php
                        if($temp["state"] == 1)echo "下单完毕,等待打印";
                        else if($temp["state"] == 2)echo "打印完毕,店家处理中";
                    ?>
                    <br/>
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
                <?php
                    $last = $i;
                    $i++ ;
                ?>
                <?php endwhile?>
            </td>
            <td class = "addr">
                <?php echo $usrInf ?>
            </td>
            <td> <?php echo $order[$last]["time"] ?></td>
            <td>
                <a href = "<?php echo $siteUrl.'/order/sended?id='.$calId ?>">发货</a>
                <a href = "#">拒绝</a>
                <a href = "#" title = "举报恶意订单">举报</a>
            </td>
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
