<?php
/*************************************************************************
    > File Name :     ../views/ordtoday.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-17 22:58:46
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
    <title>E点今日订单</title>
</head>
<body>
    <table border = "1">
        <tr>
            <th>
                商品
            </th>
            <th>
                价格X数量
            </th>
            <th class = "note">备注</th>
            <th>
                时间
            </th>
            <th>
                状态
            </th>
        </tr>
<?php
if($today)
    $len = count($today);
else $len = 0;
?>
        <?php for($i = 0;$i < $len ;$i++):?>
        <?php
            $now = $today[$i];
        ?>
            <tr>
                <td>
                    <a href = " <?php echo $siteUrl.'/item/index/'.$now['item_id'] ?>" target = "__blank">
                         <?php echo $now["title"].$now["info"]["info"]?>
                    </a>
                </td>
                <td> <?php echo $now["info"]["price"]." X ".$now["info"]["orderNum"] ?></td>
                <td class = "note"> <?php echo $now["info"]["more"] ?></td>
                <td> <?php echo $now["time"] ?></td>
                <td>
                <?php
                    if($now["state"] == 1){
                        echo "下单完成,期待发货..";
                    }
                    elseif($now["state"] == 2) {
                        echo "订单打印完毕，请即时发货哦";
                    }elseif($now["state"] == 3) echo "发货了";
                    elseif($now["state"] == 4) echo "买家签收了";
                    elseif($now["state"] == 5) echo "<span style = 'color:#82C263'>买家在下单前改变了主意,最后还是没有买</span>";
                    elseif($now["state"] == 6) echo "<span style = 'color:red'>退货</span>";
                ?>
                </td>
            </tr>
        <?php endfor ?>
    </table>
</body>
<style type="text/css" media="all">
    table{
        border:1px solid #FAFAFA;
        border-spacing:0px;
        width:100%;
    }
    td{
         text-align:center;
    }
    .note{
        width:150px;
        word-break:break-all;
     }
</style>
</html>

