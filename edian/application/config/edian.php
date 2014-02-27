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
/*
$config["Ordered"] = 1;//下单完毕
$config["printed"] = 2;//打印完毕
$config["smsed"] = 3;//短信发送完毕
 */
$config["infFailed"] = 9;//各种通知方式失败，推荐联系店家,这个保留，处理通知失败情况
$config['rejectOrder'] = 11;
//下面的好处是将内容和信息对应出来，除了在更改状态的时候需要注意之外，其他的时候，只是需要一个对应而已
$config['orderState']  = array(
    1 => '下单完成' ,
    2 => '打印完毕' ,
    3 => '短信发送完毕' ,
    8 => '接单' , //定义为在通知失败之后,不再通过任何软件的方式追求打印，而只是手动记录进行接单的方式
    9 => '各种通知均告失败' ,
    11=> '拒绝订单' ,
    //店家在网页端已经查看 ， 以后需要加的状态
 );
//这个变化，将是不可逆的变化，一旦高上去就再也下不来
/**
 * 2-8之间的各种状态都是下单成功和未送货,准备7中状态，应该是够了吧
 */
//中间的状态作为预备吧，将来或许添加什么其他的状态

$config["sended"] = 10;//已经开始发货了
$config["signed"] = 20;//已经收货了
$config["afDel"] = 30;//下单后删除,数字不能太大，因为不太可能这么多状态，也为了将来的扩展

$config["lestPrc"] = 2;//代表没有达到最低起送价的时候，需要额外的支付
$config["pageNum"] = 12;//代表如二手专区，热区之类的部分条目的的页面的每页数据量
$config["lineNum"] = 4;//代表每行，如水果饮料 显示的数据量

$config["maxStoreNum"] = 65535; //最大的库存量，这个数字视为诬陷数量，从不递减

// 确定用户的权限
$config['userCreditMin'] = 0;
$config['userCreditMax'] = 100;
$config['bossCredit'] = 110;
$config['adminCredit'] = 120;


// 确定图片的大小不能超过 5M
$config['imageSize'] = 5 * 1024 * 1024;

// 确定 1:1 图片最小宽度，图片存在 main 中
$config['mainLength'] = 460;

// 确定 thumb 图片中的 big 中的短边的宽度，图片存在 big 中
$config['bigLength'] = 700;

// 确定 thumb 图片中的 small 中的短边的宽度，图片存在 small 中
$config['smallLength'] = 460;

// 确定商店 logo 的长和宽
$config['storeLogoH'] = 200;
$config['storeLogoW'] = 200;

// 分页，每页显示的条数
$config['pageSize'] = 5;
// 商品的映射状态，
$config['itemState'] = array(0 =>'销售中', 1 => '预备', 2 => '删除', 3 => '下架' , 4 => '缺货') ;
$config['storeState'] = array(0 => '审查中' , 1 => '营业' , 2 => '歇业' , 3 => '关闭' );
$config['userState'] = array(0 => '新注册' , 1 => '普通' , 2 => '加黑' , 3=> '删除' );
// 设置管理员邮箱
$config['adminMail'] = '1264310280@qq.com';

// 设置sellNum + 1 rating 线性变化的幅度
$config['sellNumAffect'] = 1400;
// 设置visitorNum + 1 rating 线性变化的幅度
$config['visitorNumAffect'] = 100;
// 设置对 rating 的影响
$config['satisfyScoreAffect'] = 300;
?>
