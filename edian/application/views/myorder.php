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
    <link rel="stylesheet" href=" <?php echo $baseUrl.'css/order.css' ?>" type="text/css" media="all" />
<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var base_url = "<?php echo base_url()?>";
var user_name="<?php echo trim($this->session->userdata('user_name'))?>";
var user_id="<?php echo trim($this->session->userdata('user_id'))?>";
</script>
</head>
<body>
    <div id = "header">
        <span>下单成功,等待打印..</span>
        <span>打印成功,店家处理..</span>
        <span>已经发货..</span>
        <span>签收</span>
        <span>完成</span>
    </div>
<form action=" <?php echo $siteUrl.'/order/set' ?>" method="post" accept-charset="utf-8" >
    <table border = "0" class = "ordlist">
        <tr>
                <th class = "tmb">图片</th>
                <th class = "til">商品</th>
                <th class="num">数量</th>
                <th class="price">单价</th>
                <th class = "time">下单时间</th>
                <th class = "note" placeholder = "给店家的备注留言">
                    留言备注
                </th>
                <th class="state">状态</th>
                <th class = "del">操作</th>
        </tr>
    </table>
<?php
if($cart)
$len = count($cart);
else $len = 0;
?>
    <?php for($cnt = 0;$cnt < $len;):?>
        <?php
            $nows = $cart[$cnt]["seller"];
        ?>
            <span class = "<?php echo $nows ?>">
            店家:
            <a href = "<?php echo $siteUrl."/space/index/".$nows ?>"><?php echo $cart[$cnt]["selinf"]["user_name"] ?></a>
        </span>
        <table border="0" name = "<?php echo $nows ?>" class = "ordlist <?php echo $nows.'tab' ?>">
        <?php while(($cnt < $len) && ($nows == $cart[$cnt]["seller"])):?>
                <?php
                $info = $cart[$cnt]["info"];
                $tmp = explode("|",$cart[$cnt]["item"]["img"]);
                $img = $tmp[0];//直接以商品图片为图，以后再细化
                $img = $baseUrl."upload/".$img;
                $item = $cart[$cnt]["item"];
                ?>
            <tr name = "<?php echo $cnt ?>">
                <td class = "tmb">
                    <img src = "<?php echo $img ?>" class = "thumb">
                </td>
                <td class = "til">
                    <a href = " <?php echo $siteUrl.'/item/index/'.$cart[$cnt]["item_id"] ?>">
                    <?php
                        echo $item["title"].$info["info"];
                    ?>
                    </a>
                </td>
                <td class="num" style = "text-align:center">
                    <?php echo $info["orderNum"] ?>
                </td>
                <td class="price">￥<span class = "pri"><?php echo $info["price"]?></span></td>
                <td class = "time"> <?php echo $cart[$cnt]["time"] ?></td>
                <td class = "note">
                    <?php echo $info["more"] ?>
                </td>
                <td class = "state">
<?php
    $state = $cart[$cnt]["state"];
        if($state == $Ordered){
            echo "下单成功,等待打印..";
        }elseif($state == $printed){
            echo "打印成功，店家处理中..";
        }elseif($state == $signed){
            echo "已经签收";
        }elseif($state == $sended){
            echo "已经发货..";
        }else echo $state;
                ?>
                </td>
                <td class = "del" name = "<?php echo $nows.'tab'?>">
                    <a  name = "del" class = "clk" href = "<?php echo $siteUrl.'/order/del/'.$cart[$cnt]["id"] ?>">删除</a>
                <?php
                    if($state < $signed ){
                        echo "<a name = 'got' href = '".$siteUrl."/order/signed/".$cart[$cnt]["id"]."'>收到</a>";
                    }
                ?>
                </td>
            </tr>
            <?php $cnt++;?>
        <?php endwhile ?>
    </table>
    <?php endfor?>
</form>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/jquery.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/order.js' ?>"></script>
</body>
</html>
