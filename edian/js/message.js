function delDir (string) {
	//只是处理刚刚来到时候的高亮问题;
	//其实还可以通过this和find liC更简单的实现，只是我觉得这样在成功之后再更改颜色更加合理
	var reg = /\/(\w+)$/i;
	$(".mail").find(".liC").removeClass("liC").addClass("dirmenu");
	$(".mail").find(".tran").removeClass("tran");
	$(".mail").each(function  () {
		if(reg.exec(this.href)[1] == string){
			$(this).find(".dirmenu").removeClass("dirmenu").addClass("liC");
			$(this).find("span").addClass("tran");
			return false;
		}
	})
}
$(document).ready(function  () {
	$(".mail").click(function  (event) {
		var href = $(this)[0].href;
		var reg = /dex$/;
		if (reg.exec(href)) {
			if(get == "index"){
				return false;//如果原来就是这个的话，就直接返回;
			}
			get = "index";
		}
		else{
			if(get == "sendbox"){
				return false;
			}
			get = "sendbox";
		}
	getData(get);
	event.preventDefault();
	});

});
function getData (path) {
	//在路径后面加上1，标示ajax请求
	$.getJSON(site_url+"/message/"+path+"/1",function  (data,status) {
		if((data["get"]!=path)||(status!="success"))return false;
		//不成功返回，如果返回的不是最新的请求也舍弃
		var cont = document.createElement("ul"),li;
		$(cont).addClass("clearfix").attr("id","ulCont");
		for (var i = 0; i < data["cont"].length; i++) {
			li = document.createElement("li");
			$(li).addClass("block");
			if(get == "sendbox")//发件箱->收件人
			{
				$(li).append("<a href = "+site_url+"/space/index/"+data["cont"]["geterId"]+"><img class = 'imgLi block' src = '"+base_url+"upload/"+data["cont"][i]["geter"]["user_photo"]+"' /></a><a href = '"+site_url+"/message/send/"+data["cont"][i]["messageId"]+"'><p class = 'detail' title ='"+data["cont"][i]["title"]+"'>"+data["cont"][i]["title"]+"</p></a><p class = 'user tt'>"+data["cont"][i]["geter"]["user_name"]+"</p>");
			}else{
				if(data["cont"][i]["read_already"] == 0){
					data["cont"][i]["title"] = "<strong><em>"+data["cont"][i]["title"]+"</em></strong>";
				}
				$(li).append("<a href = "+site_url+"/space/index/"+data["cont"]["senderId"]+"><img class = 'imgLi block' src = '"+base_url+"upload/"+data["cont"][i]["sender"]["user_photo"]+"' /></a><a href = '"+site_url+"/message/get/"+data["cont"][i]["messageId"]+"'><p class = 'detail' title ='"+data["cont"][i]["title"]+"'>"+data["cont"][i]["title"]+"</p></a><p class = 'user tt'>"+data["cont"][i]["sender"]["user_name"]+"</p>");
			}
			$(li).append("<p class = 'user'>"+data["cont"][i]["time"]+"</p>");
			$(cont).append(li);
		};
		$("#content").empty().append(cont);
		delDir(get);
	}
	);
}
