/*
 * 这里是修改用户信息时候的，因为这个时候添加了地图等信息，大改，所以重新使用了一个文件，并逐步将之前的change.js移动过来
 */
$(document).ready(function(){
	var reg,name = false,pass = false,photo = false,phone = false,imgCheck = false;
	var userName = $("#content input[name = 'userName']");
	$("#check").click(function  () {
		$.get(site_url+"/checkcode/index",function  (data,status) {
			document.getElementById("check").src = site_url+"/checkcode/index/"+(new Date()).getTime();
		});
	})
	/********对输入的用户名检查*************/
	 function namecheck(node){
		name = $.trim($(node).val());
		reg = /[\[\];\"\/?:@=#&<>%{}\\|~`^]/;
		var temp = reg.exec(name);
		if(temp){
			report("抱歉,符号"+temp[0]+"不可以用","#name","red");
			name = false;
			return false;
		}
		if(name.length){
			$.get(site_url+"/reg/get_user_name/"+encodeURI(name),function(data,status) {
				if(status === "success"){
					var id = data.getElementsByTagName('id');
					id = $(id[0]).text();
					console.log(id);
					if(id == user_id)return; 
					if(id != "0"){
						report("该用户已经存在，请更改","#name","red");
						name = false;
					}
					else {
						name = true;
						report("恭喜，用户名可用","#name","green");
					}
				}
				else {
					$("#name").text(status);
				}
			});
		}else report("请输入用户名","#name","red");
	}
	 var temp = $.trim(userName.val());
	if(temp != "")
		namecheck(userName);//担心发表失败后返回没有检查的情况
	$(userName).blur(function  () {
		namecheck(this)	;
	});
	 /**********************************/

	$("input[name = 'passwd']").blur(function  () {
		value = $.trim($(this).val());
		if(value.length<=5)
			report("太短,太简单的密码容易被破解哦","#pass","green");
		else $("#pass").text("");
	});
	/****************密码检查*******************/
	$("#incheck").blur(function  () {
		var value = $.trim($(this).val());
		if(value.length == 0)return false;
		$.get(site_url+"/checkcode/check/"+value,function  (data,status) {
			if(status == "success" && (data == 1)){
				imgCheck = true;
				report("验证码正确","#spanCheck","green");
			}else{ report("验证码错误","#spanCheck","red");
				imgCheck = false;
			}
		})	
	}).focus(function(){
		$('#spanCheck').text('点击图片切换验证码');
	})
	/***************图片验证码检查****************/
	$("input[name = 'contra']").blur(function  () {
		$(this).unbind("keypress");
	}).focus(function  (event) {
		$("#contra").text("请输入手机或电话");
		$(this).keypress(function  (event) {
			console.log(event.which);
			if(((event.which<48)||(event.which>57))&&(event.which != 45)){
				return false;	
			}
		});
	}).change(function  () {
		value = $.trim($(this).val());
		reg = /^[\d-]{8,13}$/;
		if(reg.exec(value)){
			phone = true;
			report("验证正确","#contra","green");
		}else {
			phone = false;
			report("请正确输入号码","#contra","red");
		}
	})
	/****************手机号码的验证******************/
	$("#content input[name = 'userfile']").change(function (){
		photo = $(this).val();
		reg = /\.(jpg|jpeg|png|gif)$/i;
		if(reg.exec(photo) === null){
			report("图片格式应该为jpg,png,gif","#photo","red");
			photo = false;
		}
		else {
			report("正确","#photo","green");
			photo = true;	
		}
	});
	/*****************图片格式的验证*********************/
	$("#content form").submit(function  () {
		var pass = $("#content input[name = 'passwd']").val();
		var repass = $("#content input[name = 'repasswd']").val();
		if(name == false)	{
			report("请根据提示检测用户名","#name","red");
			return false;
		}
		if(pass == ""){
			report("请输入密码","#pass","red");
			return false;
		}
		if(pass === repass){
			if(phone == false){
				reg = /^[\d-]{8,13}$/;
				value = $.trim($("input[name = 'contra']").val());
				if(!reg.exec(value)){
					report("请输入联系方式","#contra","red");
					return false;
				}
			}
		}
		else {
			report("两次输入密码不相同","#pass","red");
			return false;
		}
		if(imgCheck == false){
			report("请输入验证码","#spanCheck","red");
			return false;
		}
	})
	$("#utype").click(function  (event) {
			//usertype 选择用户时候的控制
		if(event.target.value == 1){
			$.alet("请允许我们对您进行定位,或您在地图上标注您的店铺位置");
			$("#typeatten").text("店家的要求和管理比较严格,可以在所有区域销售");
			$("#map").slideDown();
		}else if(event.target.value == 2){
			$("#typeatten").text("买家只可以在二手市场销售商品");		
			$("#map").slideUp();
		}
	})
	map();
});
function report (cont,select,color) {
	$(select).text(cont);
	$(select).css("color",color);
}
function map () {
	//和地图，定位有关的，都在这里
var map = new BMap.Map("allmap");            // 创建Map实例
var marker = 0;//在后面会因为执行顺序的问题，被再次初始化
map.enableScrollWheelZoom();                            //启用滚轮放大缩小
map.enableInertialDragging();
map.enablePinchToZoom();//双指缩放
map.enableAutoResize();
/*************变量的初始化*********************/
var icon = new BMap.Icon(base_url+"favicon.ico",new BMap.Size(24,24));//站点图标logo
var markeOpt = {//标注的样式和属性初始化
	icon:icon,
	enableDragging:true,
	raiseOnDrag:true
}
var temp = $("#pos").val().split(";");
var bePoint = {
	point:{
		lng:temp[0],
		lat:temp[1]
	}
}
//bePoint.point.lat = temp[1];
console.log(bePoint);
console.log(bePoint.point);
success(bePoint);
var locinit = {
	locationIcon:icon,
}
/************定位**************/
var loc = new BMap.GeolocationControl(locinit),point;
function success(opt) {
	var opts = {title:"<i style = 'font-size:10px'>贴心小提示:可以右键修改位置哦</i>"}
	var info = new BMap.InfoWindow("您的店在这里",opts);
	point = new BMap.Point(opt.point.lng,opt.point.lat);
	map.openInfoWindow(info,point);
	overlay(point);//这个，在不是自动定位的时候发挥作用,正常定位下会多以个，不过，没事
	$("#pos").val(opt.point.lng+";"+opt.point.lat);
	map.centerAndZoom(point,18);//定位成功之后，将图片放到到比较大的位置，即使失败，也按照一般来说放大
}
function error (StatusCode) {
	var lat = "30.757588",lng = "103.93707";
	point = new BMap.Point(lng,lat);
	map.centerAndZoom(point,18);
}
loc.addEventListener("locationSuccess",success);
loc.addEventListener("locationError",error);
map.addControl(loc);
/*************关于右键定位******************/
map.addEventListener("rightclick",function  () {
	//右键单击添加标注，之所以是右键，因为需要移除之前添加的那些
	var menu = new BMap.ContextMenu();
	var textItem = [{
			text:'我的店在这里',
			callback:function  (p) {
				map.clearOverlays();//将之前的的自动定位之类，手动添加全部清除
				overlay(p);//
				map.removeContextMenu(menu);
			}
	}];
	var item = new BMap.MenuItem(textItem[0].text,textItem[0].callback);
	menu.addItem(item);
	map.addContextMenu(menu);
})
function overlay (po) {
	if(marker)map.removeOverlay(marker);
	marker = new BMap.Marker(po,markeOpt);
	$("#pos").val(po.lng+";"+po.lat);
	map.addOverlay(marker);
	marker.setAnimation(BMAP_ANIMATION_BOUNCE);
	setTimeout(function  () {
		marker.setAnimation(null);
	},800);//一直跳觉得有点讨厌，这里跳两下停止
}
}
