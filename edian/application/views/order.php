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
    </div>
<form action=" <?php echo $siteUrl.'/order/set' ?>" method="post" accept-charset="utf-8" >
    <table border = "0">
        <tr>
                <th class = "chose">选择</th>
                <th class = "tmb">图片</th>
                <th class = "til">商品</th>
                <th class = "num">库存</th>
                <th class="num">数量</th>
                <th class="price">单价</th>
                <th class = "note" title = "给店家的备注留言">
                    留言备注
                </th>
                <th class = "del">操作</th>
        </tr>
    </table>
<?php
if($cart)
$len = count($cart);
else $len = 0;
$idx = -1;
?>
    <?php for($cnt = 0;$cnt < $len;):?>
        <?php
            $nows = $cart[$cnt]["seller"];
            $idx ++;
        ?>
            <span class = "<?php echo $nows ?>">
            店家:
            <a href = "<?php echo $siteUrl."/space/index/".$nows ?>"><?php echo $cart[$cnt]["selinf"]["user_name"] ?></a>
            </span>
            <span class = "rt">
                <?php
                if($lsp[$idx]["lestPrc"]){
                    echo "起送价:<span class = 'lestPrc'>".$lsp[$idx]["lestPrc"]."</span>元";
                }else echo "无起送价<span class = 'lestPrc'></span>";
                ?>
            </span>
            <span>
                小计:
                <span class = 'slCal'></span>
                元
            </span>
        <table border="0" name = "<?php echo $nows ?>" class = "ordlist <?php echo $nows.'tab' ?>">
        <!-- ordlist 表示内容的类-->
        <?php while(($cnt < $len) && ($nows == $cart[$cnt]["seller"])):?>
                <?php
                $info = $cart[$cnt]["info"];
                $tmp = explode("|",$cart[$cnt]["item"]["img"]);
                $img = $tmp[0];//直接以商品图片为图，以后再细化
                $img = $baseUrl."upload/".$img;
                $item = $cart[$cnt]["item"];
                ?>
            <tr name = "<?php echo $cnt ?>">
                <td class = "chose">
                <input type="checkbox" name="chose" class = "clk" checked = "null" id = "<?php echo $cart[$cnt]["id"] ?>"/>
                </td>
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
                <td class = "num">库存<span class = "tS"><?php echo $item["store_num"]?></span></td>
                <td class="num">
                    <input type = "button" name = 'dec' class = "clk" value = "-" />
                    <input type="text" name="buyNum" class = "buyNum"  value="<?php echo $info["orderNum"]?>" />
                    <input type = "button" name = 'inc' class = "clk" value = "+" />
                </td>
                <td class="price">￥<span class = "pri"><?php echo $info["price"]?></span></td>
                <td class = "note" title = "给店家的留言，说明你的特殊需求">
                    <textarea name="note" placeholder = "备注,特殊需求说明"></textarea>
                </td>
                <td class = "del" name = "<?php echo $nows.'tab'?>"><a  name = "del" class = "clk" href = "<?php echo $siteUrl.'/order/del/'.$cart[$cnt]["id"] ?>">删除</a></td>
            </tr>
            <?php
                $cnt++;
            ?>
        <?php endwhile ?>
    </table>
    <?php endfor?>
    <div class = "adiv clearfix" id = "adiv">
    <?php for($i = 0,$len = count($buyer);$i < $len;$i++):?>
        <div class = "addr <?php if($i == 0) echo "addCse"?>" name = "<?php echo $i ?>">
            <div class = "fir">
            <span><?php echo $buyer[$i]["name"] ?></span>(收)
                <span><?php echo $buyer[$i]["phone"] ?></span>
            </div>
            <div>
                <?php echo $buyer[$i]["addr"]?>
            </div>
            <span class = "aten">收货地址</span>
        </div>
    <?php endfor ?>
       <div class = "addr nad" id = "nad">
            <textarea name="naddr" class = "naddr" placeholder = "新地址,尽量精确到房间哦"></textarea>
            <p>
                <span>手机号码</span><input type="text" name="phone" />
            </p>
            <p>
                <span>收件人</span><input type="text" name="geter" />
                <input type="button" name="adsub" id="adsub" value="提交" />
            </p>
            <span class = "aten">新地址</span>
        </div>
    </div>
    <input type="hidden" name="addr" id="addr" value="<?php if($len > -1)echo "0" ?>" />
    <input type="hidden" name="orderId" id="orderId"  />
    <input type="hidden" name="more" id="more"  />
    <input type="hidden" name="buyNums" id="buyNums"  />
   <div class = "tBt">
        全选 <input type="checkbox" name="allChe" id="allChe" checked = "checked" />
        <span class = "money">总计:￥<span id = "calAl"></span>(元)</span>
        <input type="submit" name="sub" id="sub" value="提交订单" />
    </div>
</form>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/jquery.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/order.js' ?>"></script>
</body>
</html>
