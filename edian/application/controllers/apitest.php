<?php

require_once 'dsprint.class.php';

//utf-8格式
header("Content-Type:text/html;charset=UTF-8");

//测试打印
//testSendFreeMessage();

//测试更改URL
testChangeURL();

die;


function testSendFreeMessage(){
	/*
	$freeTxt = "\n**订餐网\n" .
					"订单时间：".date("Y-m-d H:i:s")."\n".
					"订单号码：112233445566\n" .
					"送餐员："."李**"."\n" .
					"\x1B\x21\x08".#打印机粗体指令
					"姓名："."冯先生"."\n" .
					"电话："."1391111111"."\n" .
					"发货店面："."永和豆浆 1店 "."\n" .
					"送餐地址："."测试地址456"."\n" .
					"单位："."测试地址123"."\n" .
					"会员积分："."1210"."\n" .
					"特殊要求："."不要红烧肉 带瓶可乐"."\n" .
					"\x1B\x21\x00".#取消打印机粗体指令
					"            "."订餐明细\n".#每行16个汉字，32个字符，可以以此来判断空行
					"商品名称"."        "." 单价"." 份数"."  合计"."\n" .
					"土豆丝"."          "."    8"."    2"."   16"."\n" .
					"\n" .			
					"\x1B\x21\x10".  #打印机汉字高度放大2倍指令
					"支付方式："."现金/积分消费/签单"."\n" .
					"本次消费："."50.00"."\n" .
					"本次积分："."50"."\n" .
					"\x1B\x21\x00".						#取消打印机粗体
					"订餐电话："."11111111"."\n" .
					"订餐QQ："."11111111"."\n" .
					"营业时间："."7:00---20:00"."\n" .
					"365天天天为你服务"."\n" .
					"\n" .
					"------------------------------\n" .
					"订单号码：111111\n" .
					"       请您评价我们的服务"."\n".
					"非常满意|基本满意|不满意|"."\n"."\n"."\n".
					"客户签名_______________\n" .
					"\n\n\n"; 						#多走三行，便于撕纸
	*/
	
	$freeTxt = "\n**订餐网\n" .
					"订单时间：".date("Y-m-d H:i:s")."\n".
					"订单号码：112233445566\n" .
					"送餐员："."李**"."\n" .
					"\x1B\x21\x08".#打印机粗体指令
					"姓名："."冯先生"."\n" .
					"特殊要求："."不要红烧肉 带瓶可乐"."\n" .
					"\x1B\x21\x00";#取消打印机粗体指令
	
	//此处修改为用户的密码以及appid。
	$client = new DsPrintSend('your_password','your_appid');
	//$client = new DsPrintSend();
	//打印字符串，此处修改为用户名下对应的在线的且连接打印机的dtuid。
	echo $client->printtxt('your_dtuid',$freeTxt,60);
	//查询打印机状态
	//echo $client->printtxt('your_dtuid');
}

function testChangeURL(){
	$client = new DsPrintSend('your_password','your_appid');
	//更改URL
	echo $client->changeurl();
}
?>
