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
    <h3>
        <span class = "state">状态</span>
        <span class = "order">订单号</span>
        <span >买家</span>
        <span >金额</span>
        <span >下单时间</span>
    </h3>
    <ul id = "list" class = "list">
        <?php foreach ($order as $value) :?>
        <?php
            $orderNum = $storeId . '_' . strtotime($value['time']);
        ?>
        <li>
            <div class = "init">
                <span class="state"><?php echo $orderState[$value['state']] ?></span>
                <span class="order"><?php echo $orderNum?></span>
                <span><?php  echo $value['user'][0]?></span>
                <span>￥<?php echo $value['total'] ?></span>
                <span><?php echo $value['time'] ?></span>
                <font class = "down"> </font>
            </div>
            <div class = "buyer">
                <div class = "clearfix">
                    <div class = "info">
                        <ul>
                            <?php foreach ($value['item'] as $item):?>
                            <li>
                                <strong><a href = "<?php  echo $siteUrl .'/item/index/' . $item['id']?>"><?php echo $item['title'] . $item['info']['info']?></a></strong>
                                <span>￥<?php echo $item['info']['price'] ?> x <?php echo $item['info']['orderNum'] ?></span>
                                <span class = "note">
                                    <?php
                                        if($item['info']['more'])
                                        echo '备注：' . $item['info']['more'] ;
                                    ?>
                                </span>
                            </li>
                            <?php endforeach?>
                        </ul>
                        <ul>
                            <li>
                                <span class="item">买家:</span>
                                <span class="user"><?php echo $value['user'][0] ?></span>
                            </li>
                            <li>
                                <span class="item">联系方式:</span>
                                <span class="phone"> <?php echo $value['user'][1]?></span>
                            </li>
                            <li>
                                <span class="item">地址:</span>
                                <span><?php echo $value['user'][2] ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class = "oper">
                    <?php $val = 8;?>
                        <a href = "<?php echo $siteUrl .'/bg/order/changeNote/' . "$orderNum/$val"?>"><?php echo $orderState[$val] ?></a>
                        <a href = "<?php echo $siteUrl .'bg/order/rePrint/' . $orderNum?>">重新打印</a>
                    <?php $val = 11;?>
                        <a name = 'reject' href = "<?php echo $siteUrl .'/bg/order/changeNote/' . "$orderNum/$val"?>"><?php echo $orderState[$val] ?></a>
                    <?php $val = 12;?>
                        <a name = 'evil' href = "<?php echo $siteUrl .'/bg/order/changeNote/' . "$orderNum/$val"?>"><?php echo $orderState[$val] ?></a>
                    </div>
                </div>
                <form action = "<?php echo $siteUrl .'/bg/order/changeNote/' . "$orderNum/$val"?>" method="post" accept-charset="utf-8" class = "reject" style = "display:none" >
                    <fieldset>
                        <legend >拒绝订单:</legend>
                        <textarea name="context" placeholder = "请输入拒绝理由"></textarea>
                        <input type="button" name="reject"  value="提交" />
                    </fieldset>
                </form>
                <form action="<?php echo $siteUrl .'/bg/order/changeNote/' . "$orderNum/$val"?>" method="post" accept-charset="utf-8" class = "evil" style = "display:none">
                    <fieldset>
                        <legend >恶意订单:</legend>
                        <textarea name="context" placeholder = "请说明详情"></textarea>
                        <input type="button" name="evil"  value="提交" />
                    </fieldset>
                </form>
            </div>
        </li>
        <?php endforeach?>
        <li>
            <div class = "init">
                <span class="state">打印失败</span>
                <span class="order">1292832322</span>
                <span>黄洁</span>
                <span>￥23.00</span>
                <span>1293-32-32 32:12:21</span>
                <font class = "down"> </font>
            </div>
            <div class = "buyer clearfix">
                <div class = "info">
                    <ul>
                        <li>
                            <strong>金华火腿(2斤,红烧)</strong>
                            <span>￥12.00 x 12</span>
                            <span class = "note">要嫩猪肉</span>
                        </li>
                        <li>
                            <strong>金华火腿</strong>
                            <span>￥12.00 x 12</span>
                            <span class = "note">要嫩猪肉</span>
                        </li>
                        <li>
                            <strong>金华火腿</strong>
                            <span>￥12.00 x 12</span>
                            <span class = "note">要嫩猪肉</span>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <span class="item">买家</span>
                            <span class="user">黄洁</span>
                        </li>
                        <li>
                            <span class="item">联系方式</span>
                            <span class="phone">12832792288</span>
                        </li>
                        <li>
                            <span class="item">地址</span>
                            <span>东门大桥西侧</span>
                        </li>
                    </ul>
                </div>
                <div class = "oper">
                    <a href = "">接单</a>
                    <a href = "">打印</a>
                    <a href = "">拒绝订单</a>
                    <a href = "">恶意订单</a>
                </div>
            </div>
        </li>
    </ul>
</body>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/jquery.min.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/histOrder.js' ?>"></script>
</html>
