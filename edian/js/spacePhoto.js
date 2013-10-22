var download_height;
$(document).ready(function  () {
	//初始化的函数
	var reg = /\d+/;
	var userId = reg.exec(window.location.href);
	if(userId == null){
		userId = user_id;	
	}else userId = userId[0];
	$.ajax({
		url:site_url+"/spacePhoto/getThumb/"+userId,
		dataType:"json",
		success:function(data,textStatus){
			var len = data.length;
			if((textStatus == "success")&&(len)){
				if(data == "0")console.log("没有登陆");
				var a,nowNode = 0;//nowNode为将要到dom中的thumb的节点代号,当然要从0开始
				var div = document.createElement("div");
				$("#mainPhoto")[0].src = base_url+"/upload/"+data['0']["img_name"];
				var nowImgName = 0;
				var nowImg = data[0]["img_id"];//nowImg表示正要浏览的大图片的位置
				getJudge(nowImg);
				for (var i = 0; i < len&&(i<18);i++) {
					//首先创立18个，然后每次添加6个，因为如果一次添加太多，就会很消耗时间，所以每当阅读6个之后，再次申请6个
					a = creThumb(data[nowNode]["img_id"],data[nowNode]["img_name"]);
					$(a).attr("name",nowNode);
					nowNode++;
					$(div).append(a);
				};
				var flag = 0,now = 0,nowa;//now表示当前正要隐藏，或者显示的节点号码,nowa，表示对应的节点对象,当前正在浏览的大图片,当前正在浏览的大图片
				$(div).attr("id","thumbInner").insertBefore("#arrowdown");
				$("#arrowdown").mousedown(function  () {//给节点添加mousedown和click事件
					flag = setInterval(function  () {
						now = hideThumb(now);
					},300);
				}).click(function  () {
					now = hideThumb(now);
				});
				$("#arrowup").mousedown(function  () {
					flag = setInterval(function  () {
						now = showThumb(now);
					},300);
				}).click(function  () {
					now = showThumb(now);
				});

				$("#thumb").mouseup(function  () {
					if(flag)
					clearInterval(flag);
				});
				var time = 0;
				function showThumb (now) {
					nowa = $(div).children().eq(now);//获得第n个。
					nowa.slideDown(500);
					if(now!=0)now--;
					return now;
				}
				function hideThumb (now) {//处理隐藏和添加节点的函数
					time++;
					if(((time%5)==0)&&(nowNode < data.length)){//之所以分批次添加是因为担心网速和服务器消耗的问题，分批次加载
						for (var i = 0; i < 6 && data.length > nowNode; i++) {
							a = creThumb(data[nowNode]["img_id"],data[nowNode]["img_name"]);
							$(a).attr("name",nowNode);
							$("#thumbInner").append(a);
							nowNode++;
						};
						div = $("#thumbInner");
					}
					if(now < ($(div).children().length-2)){//没有什么可以隐藏的时候，就不再添加了
						nowa = $(div).children().eq(now);//获得第n个。
						nowa.slideUp(500);
						now++;
					}
					return now;
				}
				var mainSrc = $("#main img")[0].src,reg = /\d+.jpg$/i;
				var index = reg.exec(mainSrc)["index"];
				var upBase = site_url+"/spacePhoto/judgePhp/";
				mainSrc = mainSrc.substring(0,index);
				//当缩略图显示之后，阻止调转
				$("#thumbInner").delegate("#thumbInner a","click",function  (event) {
					index = reg.exec(this.href)[0];
					nowImg = this.title;
					$("form")[0].action = upBase+this.title;//修改form对应的imgId，保存在a的title中
					$("#mainPhoto")[0].src = mainSrc+index;
					nowImgName = this.name;
					for (var temp = now+3;(temp!=this.name);temp = now+3) {
						//这里是移动缩略图而用的函数
						if(temp>this.name)now = showThumb(now);
						else now = hideThumb(now);
						if(now == 0)break;
					};
					getJudge(nowImg);
					event.preventDefault();
					event.stopPropagation();
				});
				$(".leftarrow").click(function  () {
					now = showThumb(now);
					if(nowImgName<=0){
						nowImgName = 0;
						return false;
					}
					arrow(--nowImgName);
				})
				var contro=0,temp;//contro表示控制信号，0为刚刚执行完毕，正处于等待状态，1表示正在等待中,2呢，表示已经有一个在处理，要抛弃之前的，
				$(".rightarrow").click(function  () {
					now = hideThumb(now);
					if(nowImgName>= ($(div).children().length-1))
					return;

					arrow(++nowImgName);
				});
				function arrow (imgName) {//左右箭头控制时候的内容显示，包括300ms后才开始读取评论，避免无意义的申请，
					//通过imgName修改图片名称，修改主要图片
					temp  = $("#thumbInner a[name = "+imgName+"]");
					//now = hideThumb(now);
					index = reg.exec(temp[0].href)[0];
					$("#mainPhoto")[0].src = mainSrc+index;
					if(contro == 0){
						contro = 1;
						var interval = setInterval(function  () {
							if(contro == 2)contro = 1;
							else if(contro ==1){
								getJudge(temp[0].title);
								if(interval){
									clearInterval(interval);
								}
								contro = 0;
							}
						},400);
					}else {
						contro = 2;
					}
				}
				$("form").submit(function(){
					if((user_id == "")||(user_id == null)){
						alert("请先登陆");
						return ;
					}
					var node=document.getElementById("commentContent");
					var content=node.value;
					if(content == "")return false;
					content=content.replace(/\n/g,"<br/>");
					$.ajax({
						url:site_url+"/spacePhoto/judge/"+nowImg,type:"POST",data:{"content":content},dataType:"json",
						success:function(data,testStatus) {
							if(data["mark"]=="1"){
								content=content.replace(/\[face:(\(?[0-9]+\)?)]/g,"<img src="+base_url+"face/$1.gif"+" />");//只允许一个的（），读取其中的序号，然后添加，自己增加其他的地址之类的
								create(user_name,user_id,data["photo"],nowTime(),content);
							}
							else if(data["mark"] == -1) {
								$.alet("请先登陆");
							}else console.log(textStatus);
						},
						error:function(xml){
							console.log(xml);
						}
					});
					node.value="";//这里表明，其实原生的js更好,目前支持火狐，chrome
					return false;
				});	
			}
		},
			error:function  (xml) {
				console.log(xml);
			}
	});
	faceAdd();
	$("#main").mouseenter(function  () {
		$("#mainName").fadeIn();
	}).mouseleave(function  () {
		$("#mainName").fadeOut();
	})
	$("#uploadBt").click(function  () {
		creWin();//这里是上传的部分
		function cancel () {
			$("#uparea").detach();
			$(document).unbind("keydown");
		}
		$("#cancel").click(cancel);
		$(document).keydown(function  () {
			if(window.event.keyCode == 27)
			cancel();
		});
	})
	function getJudge(imgId) {
		//为文章获得评论内容,同时为减少ajax请求，将关于imgId的信息也获取，比如名称，简介等等
		//abort现在在本机，响应速度太快，需要将来实体测试
		console.log(imgId);
		$.ajax({
			url:site_url+"/spacePhoto/getJudge/"+imgId,dataType:'json',
		success:function(data,textStatus){
			if(textStatus == "success"){
				var main = data["main"];
				var intro = document.getElementById("introText");
				intro.value = main["intro"];//时间目前还没有用上，不知道该怎么使用
				data = data["judge"];
				$("#mainName span").text(main["upload_name"]);
				console.log("testing");
				$("#comUl").stop(true,true);
				$("#comUl").fadeOut(300,function  () {
					$("#comUl").empty();
					for (var i = 0,lent = data.length; i <lent; i++) {
						data[i]["comment"] = data[i]["comment"].replace(/\[face:(\(?\d+\)?)]/g,"<img src = "+base_url+"face/$1.gif "+"/>");
						create(data[i]["name"],data[i]["userId"],data[i]["photo"],data[i]["time"],data[i]["comment"]);
					};
					$("#comUl").fadeIn();
				});
			}
		},
			error:function  (xml) {
				console.log(xml);
			}
		});
	}
});
function getThumb (userId) {

}
function creThumb (id,name) {
	var a = document.createElement("a");
	$(a).attr("href",base_url+"upload/"+name);
	$(a).attr("title",id);
	$(a).append("<img alt = '缩略图' src = '"+base_url+"thumb/"+name+"' class = 'thumb block'/>");
	return a;
}
function creWin () {
	var div = document.createElement("div");
	var div2 = document.createElement("div");
	$(div2).attr("id","inner");
	$(div).attr("id","uparea");//uploadarea
	$(div2).append("<iframe src = '"+site_url+"/chome/upload"+"' scrolling = 'No' frameborder = 'no' name = 'load'></iframe>");
	$(div2).append("<span id = 'cancel' src = '"+base_url+"bgimage/arrow.png"+"'/></span>");
	$(div).append(div2);
	$("body").append(div);
}

function create (userName,id,name,time,content) {
	debugger;
	var li = document.createElement("li");
	$(li).append("<a href = "+site_url+"/space/index/"+id+" target = '__blank'><img class = 'liImg block thumb' src = '"+base_url+"/upload/"+name+"' title = "+userName+"/></a><p class = 'title'>"+content+"</p><p class = 'user'>"+userName+"-----"+time+"</p>");
	$("#comUl").append(li);
}
function getGifName (name) {//通过传入的url获得其中隐藏的图片名称
	var reg = /(\d+).gif$/;
	return reg.exec(name)[1];
}
function nowTime () {//获得本地的时间"2013-4-6 20:27:32"的形式
	var time=new Date();
	return time.getFullYear()+"-"+(time.getMonth()+1)+"-"+time.getDate()+" "+time.getHours()+":"+time.getMinutes()+":"+time.getSeconds();
}
function faceAdd () {
	$("#face").delegate("img","click",function(){
		var temp=getGifName(this.src);
		var content=document.getElementById("commentContent");
		content.value=content.value+"[face:"+temp+"]";
	});
}

