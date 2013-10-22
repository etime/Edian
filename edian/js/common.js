/*************************************************************************
    > File Name :  ../js/common.js
    > Author  :      unasm
    > Mail :         douunasm@gmail.com
    > Last_Modified: 2013-05-31 20:38:29
 ************************************************************************/
function showInfo () {
	//控制用户信息悬浮的函数I;
	var inarea = 0,show = 0,info = null,lastCon = null;//在可悬浮区域内部外部标志变量
	//lastCon 上一个显示出来的aImg,在进入aImg 的时候判断
	$("#ulCont").delegate(".aImg","click",function  (event) {
			if((info != null)&&(lastCon != this)){//在上一个,因为有进入另一个的可能性，所以需要判断新进入的和上一个是不是同一个
				var temp = info;
				temp.slideUp();//让他慢慢消失吧,一个的消失是另一个的开始
				show = 0;
			}
			lastCon = this;//现在正在有一个显示中,将正在显示的复制
			inarea = 1;
			info = $(this).siblings(".userCon");
			/*
			if(show)
				info.slideUp();
			else 
				info.slideDown();
				*/
			show?info.slideUp():info.slideDown();
			show = 1-show;
			//ct(this);//不必再计时，立刻显示
		event.preventDefault();
	}).delegate(".aImg","mouseleave",function  () {
		//info = $(this).siblings(".userCon");//离开的时候将她赋值，成为全局变量,方便之后隐藏
		//既然click过，必然enter，不必在查找dom
		inarea = 0;
		if(show)close();//自由在落下来的情况下，会开始计时
	}).delegate(".userCon","mouseenter",function  () {
		inarea = 1;//单纯的延长时间
	}).delegate(".userCon","mouseleave",function  () {
		inarea = 0;
		if(show)close();
	})
	function ct (node) {
		//count Time,在一个图片停放一定时间才决定要不要显示信息
		setTimeout(function  () {
			if((lastCon == node)&&(inarea))//只有是同一个图片，中间没有改变，并且还在区域内部才可以
				$(node).siblings(".userCon").slideDown();
		},350);//或许事件有点短，步步哦，太长了就不好，而且，只是针对滑过的情况其实足够了
	}
	function close () {
		//延迟0.5S，之后不在显示区域就隐藏
		setTimeout(function  () {
			if(inarea == 0){
				$(info).slideUp();
				info = null;
				show = 0;
			}
		},9990);
	}
}
function ulCreateLi(data,search) {
	//这个文件创建一个li，并将其中的节点赋值,psea有待完成,photo还位使用
	//肮脏的代码，各种拼字符串
	var doc = document;
	var li=doc.createElement("li");
	$(li).addClass("block");
	$(li).append("<a class = 'aImg' href = '"+site_url+"/showart/index/"+data["art_id"]+"' ><img  class = 'imgLi block' src = '"+base_url+"thumb/"+data["img"]+"' alt = '商品压缩图' title = "+data["user"]["user_name"]+"/></a>");
	$(li).append("<a class = 'detail' href = '"+site_url+"/showart/index/"+data["art_id"]+"'>"+data["title"]+"</a>");
	$(li).append("<p class = 'user tt '><a href = "+site_url+"/space/index/"+data["author_id"]+"><span class = 'master tt'>店主:"+data["user"]["user_name"]+"</span></a><span class = 'time'>￥:"+data["price"]+"</span></p>");
	$(li).append("<p class = 'user tt'><span class = 'time'>"+data["time"]+"</span>浏览:"+data["visitor_num"]+"/评论:"+data["comment_num"]+"</p>");
	var div = doc.createElement("div");
	$(div).addClass("clearfix userCon").css("display","none");
	$(div).append("<a  target = '_blank' href = "+site_url+"/space/index/"+data["author_id"]+"><img class = 'block' src = '"+base_url+"upload/"+data["user"]["user_photo"]+"'/></a><p ><a target = '_blank' href = "+site_url+"/space/index/"+data["author_id"]+" class = 'fuName tt'>sdfasdfasdfasdfas"+data["user"]["user_name"]+"</a><a class = 'mess' target = '_blank' href = "+site_url+"/message/write/"+data["author_id"]+">站内信联系</a></p><p><span>联系方式:</span>"+data["user"]["contract1"]+"</p>");
	if(data["user"]["addr"])
		$(div).append("<p><span>地址:</span>"+data["user"]["addr"]+"</p>");
	$(li).append(div);
	return li;
}
function search () {
	return;
	$("#sea").focus(function  () {
		$("#seaatten").text("");
	}).blur(function  () {
		if(($.trim($("#sea").val()))=="")//只有去掉空格才可以，不然会出bug
			$("#seaatten").html("搜索<span class = 'seatip'>请输入关键字</span>")
	})
	//所有关于search操作的入口函数
	$("#seaform").submit(function  () {
			var keyword = $.trim($("#sea").val());
			if(keyword == last)return false;//担心用户的连击造成重复申请数据
			if(keyword.length == 0){
				$.alet("请输入关键字");
				return false;	
			}
			var temp = window.location.href.split("#");
			temp = temp[0];
			window.location.href = temp+"#"+keyword;
			getSea(keyword);
			return false;
		})
}
var last;
function getSea (keyword) {
		//在search触发之后，对key进行审查之后的开始搜索
			last = keyword;
			seaFlag = 1;
			debugger;
			now_type = -1;
			var enkey = encodeURI(keyword);
			$.getJSON(site_url+"/search/index?key="+enkey,function  (data,status) {
				if(status == "success"){
					if(data.length == 0){
						$.alet("你的搜索结果为0");
					}else{
						$("#cont").empty();
						$("#bottomDir ul li").detach();
						var last = $("#dirUl").find(".liC");
						$(last).removeClass("liC").addClass("dirmenu");
						$(last).find(".tran").removeClass("tran");
						formPage(data,1,1);
						$("#np").removeAttr("id").attr("id","seaMore");
						//$("#content").append("<p style = 'text-align:center'><button id = 'seaMore'>更多....</button></p>")
						getNext();
					}
				}
			});
			function getNext () {//获得搜索下一页的函数
				var page = 1,seaing = 0;
				var more = $("#seaMore");
				more.click(function  () {
						if(seaing == 0){
							seaing = 1;
							$.alet("seaing");
							more.text("加载中..");
							$.getJSON(site_url+"/search/index/"+(page)+"?key="+enkey,function  (data,status,xhr) {
								if(status == "success"){
										if(data.length == 0){
										$.alet("你的搜索结果为0");
										more.text("没有了");
									}else{
										seaing = 0;
										formPage(data,++page,1);
										(data.length<16)?(more.text("没有了")):(more.text("下一页"));
									}
								}
								//else console.log(xhr);
							});
						}
				});
			}	
}
