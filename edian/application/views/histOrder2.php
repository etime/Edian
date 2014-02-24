<!DOCTYPE html>
<html lang = "en">
<head>
<?php
$siteUrl = site_url();
$baseUrl = base_url();
?>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8"/>
<!--
    <meta http-equiv="refresh" content="50">
-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title>E点</title>
    <link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/timeorder.css') ?>" type="text/css" media="all" />
<script type="text/javascript" >
    var site_url = "<?php echo site_url()?>";
    var base_url = "<?php echo base_url()?>";
</script>
</head>
<body>
    <form action="" method="post" accept-charset="utf-8">
        <span>选择店铺</span>
        <select name="storeId">
    <?php
        $list = "";
        foreach ($storeList as $store) {
            $list .="<option  value = '" .$store['id']. "'>" . $store['name']. "</option>";
            }
            echo $list;
    ?>
        </select>
        <input type="submit" name="sub"  value="确定选择" />
    </form>
    <h3>
        <span class = "state">状态</span>
        <span class = "order">订单号</span>
        <span >买家</span>
        <span >合计金额</span>
        <span >下单时间</span>
    </h3>
    <ul id = "list" class = "list">
        <?php for($i = 0,$len = ($order ? count($order) : 0) ; $i < $len; $i++):?>
        <li>
            <div class = "init">
                <span class="state">打印失败</span>
                <span class="order"><?php echo $storeId . strtotime($order[$i]['time']) ?></span>
                <span>黄洁</span>
                <span>￥<?php echo $order[$i]['total'] ?></span>
                <span><?php echo $order[$i]['time'] ?></span>
                <font class = "up"> </font>
            </div>
            <div class = "buyer clearfix" style = "display:none">
                <div class = "clearfix">
                    <div class = "info">
                        <ul>
                        <?php
                            $item = $order[$i]['item'];
                            $user = $order[$i]['user'];
                        ?>
                        <?php foreach($item as $value): ?>
                            <li>
                                <a href = "<?php echo $siteUrl . '/item/index/' . $value['id']?>" target = '__blank'><?php ?>
                                    <strong><?php echo $value['title'] . $value['info']['info']?></strong>
                                </a>
                                <span>￥<?php echo $value['info']['price'] ?> x <?php  echo $value['info']['orderNum']?></span>
                                <span class = "note"><?php echo $value['info']['more'] ?></span>
                            </li>
                        <?php endforeach?>
                        </ul>
                        <ul>
                            <li>
                                <span class="item">买家:</span>
                                <span class="user">
                                    <?php  echo $user[0]?>
                                </span>
                            </li>
                            <li>
                                <span class="item">联系方式:</span>
                                <span class="phone"><?php echo $user[1] ?></span>
                            </li>
                            <li>
                                <span class="item">地址:</span>
                                <span><?php echo $user[2] ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class = "oper">
                        <a href = "">接单</a>
                        <a href = "">打印</a>
                        <a name = 'refuse' href = "">拒绝订单</a>
                        <a name = "sick" href = "">恶意订单</a>
                    </div>
                </div>
                <!-- 店家对商品的反馈-->
                <form action="<?php echo $siteUrl . '/order/changeNote/1' ?>" method="post" accept-charset="utf-8" class = "refuse" style = "display:none" >
                    <fieldset>
                        <legend >拒绝订单:</legend>
                        <textarea name="context" placeholder = "请输入拒绝理由"></textarea>
                        <input type="button" name="reject"  value="提交" />
                    </fieldset>
                </form>
                <form action="<?php echo $siteUrl . '/order/changeNote/2' ?>" method="post" accept-charset="utf-8" class = "sick" style = "display:none">
                    <fieldset>
                        <legend >恶意订单:</legend>
                        <textarea name="context" placeholder = "请说明详情"></textarea>
                        <input type="button" name="reject"  value="提交" />
                    </fieldset>
                </form>
            </div>
        </li>
        <?php endfor ?>
    </ul>
    <?php  echo @$pageNumFooter;?>
</body>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/jquery.min.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/histOrder.js'?>"></script>
</html>
