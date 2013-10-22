$(document).ready(function  () {
	$("#face").hide();
	comconstru();
	com();
	var reg = /([0-9]+)$/;
	var messId = (reg.exec(window.location.href))[0];
});
function comconstru () {
	//初始化的函数
	var doc = document;
	$("#face").delegate("img","click",function(){
		var temp=getGifName(this.src);
		var content=doc.getElementsByName("com")[0];
		content.value=content.value+"[face:"+temp+"]";
	});
	$("form").submit(function(){
		var node=doc.getElementById("comcon");
		var content=$.trim(node.value);
		if(content.length == 0){ $.alet("没有内容");return false;}
		var url = this.action;
		content=content.replace(/\n/g,"<br/>");
		$.ajax({
			url:url+"/1",type:"POST",dataType:"json",data:{"com":content},
			success:function(data) {
				if(data == 1){
					content=content.replace(/\[face:(\(?[0-9]+\)?)]/g,"<img src="+base_url+"face/$1.gif>");
					var li = CCA(content,nowTime(),user_id,sPhoto,now_type);
					$("#ulCont").append(li);
					giveUpFun (); 
				}else $.alet("发表失败，请联系管理员1264310280@qq.com");
			},
			error:function(xml){
				console.log(xml);
			}
		});
		node.value="";//这里表明，其实原生的js更好,目前支持火狐，chrome
		return false;
	});
}
function getGifName (name) {
	//通过传入的url获得其中隐藏的图片名称,其实使用正则超级简单的
	var reg = /(\d+).gif$/;
	return reg.exec(name)[1];
}
function com() {//controller the comment area hide or show
	$("#comcon").focus(function(){
		if((user_id == "")||(user_id == null)){
			$.alet("出错了，请联系管理员1264310280@qq.com,谢谢");
			return false;
		}
		$("#judge .pholder").hide();
		$(".sli").animate({
			height:"200px",
			width:"590px",	
		},'fast');
		$("#comcon").animate({
			height:"200px",
		},'fast');
		$("#face").fadeIn();
	});
	$("#giveup").click(function(){
		giveUpFun();
	});
}
function giveUpFun () {
	var node  = document.getElementById("comcon").value = "";
	$("#face").fadeOut();
	$(".sli").animate({
		width:"351px",
		height:"33px"
	},'fast');
	$("#comcon").animate({
		height:"33px",
	});
	$("#judge .pholder").show();
}
function nowTime () {
	//获得本地的时间"2013-4-6 20:27:32"的形式
	var time=new Date();
	return time.getFullYear()+"-"+(time.getMonth()+1)+"-"+time.getDate()+" "+time.getHours()+":"+time.getMinutes()+":"+time.getSeconds();
}
function CCA(cont,time,userId,photo,comId){
	//comId目前不准备使用,以后添加修改评论功能吧，创建评论的li
	//用户评论后生成内容,好挫
	var li = document.createElement("li");
	$(li).append("<a href = '"+site_url+"/space/index/"+userId+"' target = '_blank'><img class = 'thumb' title = '"+name+"' src = '"+base_url+"upload/"+photo+"'/></a>");
	$(li).append("<p >"+cont+"</p>");
	$(li).append("<span class = 'time'>"+time+"</span>");
	$("#ulCont").append(li);
}
