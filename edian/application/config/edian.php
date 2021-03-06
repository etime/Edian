<?php
/*************************************************************************
    > @文件名:     edian.php
    > @作者:       unasm
    > @邮件:       1264310280@qq.com
    > @创建时间:   2013-09-24 15:35:36
 ************************************************************************/
/**
 * 这个是作为配置文件使用的，在这里确定很多变量的参数,比如起送价的补偿，比如订单的各种状态
 */
/**
 * 这些是为了定义订单的各种状态而确立的,中间留下的空格为预留的将来添加的状态
 */
//0代表加入了购物车，但是没有下单
$config["Ordered"] = 1;//下单完毕
$config["printed"] = 2;//打印完毕
$config["smsed"] = 3;//短信发送完毕
$config["infFaild"] = 9;//各种通知方式失败，推荐联系店家
//这个变化，将是不可逆的变化，一旦高上去就再也下不来
/**
 * 2-8之间的各种状态都是下单成功和未送货,准备7中状态，应该是够了吧
 */
//中间的状态作为预备吧，将来或许添加什么其他的状态

$config["sended"] = 10;//已经开始发货了
$config["signed"] = 20;//已经收货了
$config["afDel"] = 30;//下单后删除,数字不能太大，因为不太可能这么多状态，也为了将来的扩展

/**
 * 这些是为了确立管理员的位置和权限确立的
 * 代表userType 各种的状态，
 */
$config["ADMIN"] = 3;//管理员为3,这个是写入数据库的，不可乙轻易更改


$config["lestPrc"] = 2;//代表没有达到最低起送价的时候，需要额外的支付
$config["pageNum"] = 12;//代表如二手专区，热区之类的部分条目的的页面的每页数据量
$config["lineNum"] = 4;//代表每行，如水果饮料 显示的数据量

$config["maxStoreNum"] = 65535; //最大的库存量，这个数字视为诬陷数量，从不递减
?>
