function getInfo (type) {
	var xml=new XMLHttpRequest();
	if(xml==null){
		alert("您的浏览器版本太低，请更新浏览器，或者使用谷歌或火狐浏览器");
		return;
	}
	xml.open("post",url+now_type+"/"+partId[type],false);
	console.log(url+now_type+"/"+partId[type]);
	xml.onreadystatechange=function()	{
		if(xml.readyState==4){
			if(xml.status==200){
				var resxml=xml.responseXML;
				var art_id=resxml.getElementsByTagName('art_id');
				var title=resxml.getElementsByTagName('title');
				var user_id=resxml.getElementsByTagName('user_id');
				var time=resxml.getElementsByTagName('reg_time');
				var author=resxml.getElementsByTagName('author');
				var ul = append(art_id,author,title,user_id,time);
				var pagenation=document.createElement("p");
				pagenation.className="pageDir";
				pagenation.innerText="第"+partId[type]+"页";
				partId[type]++;
				ul.appendChild(pagenation);
			}
			else {
				console.log("not ready");
			}
		}
	}
	xml.send(null);
}
function getValue (node) {
	return node.childNodes[0].nodeValue;
}
function dump (obj) {
	//用来输出的对象的函数,表示很好用
	var s="";
	for( var property in obj){
		s=s+"\n" +property +":" +obj[property];
		console.log(property);
		console.log(obj[property]);
	}
}
function append (art_id,author,title,user_id,time) {
	//这个是调用所有其他的函数的函数，就是只是负责分配生成ul中内容的函数的函数
	var ul=document.getElementById("ulCont");
	var flag=0,team;
	team=document.createElement("div")	;
	team.className="team block shadow";
	for (var i = 0; i < art_id.length; i++) {
		var li=ulCreateLi(getValue(art_id[i]),getValue(user_id[i]),getValue(title[i]),getValue(time[i]),getValue(author[i]));
		///这里的author还没有用到，因为没有添加对应的数据在数据库中
		//var li=ulCre ateLi(getValue(art_id[i]),getValue(user_id[i]),getValue(author[i]),getValue(time[i]),getValue(title[i]));
		team.appendChild(li);
		if((i%6)==5){
			ul.appendChild(team);
			team=document.createElement("div")	;
			team.className="team block shadow";
		}
	}
	return ul;
}
function autload(id) {
	//这里是进行自动加载的，根据用户的鼠标而改变
	/*id表示当前浏览的版块，
	*/
	var height=$(window).scrollTop()+$(window).height();
	if((height+download_height)>document.height){//不能到底部的时候才开始加载，提前一些才好，这里是100，在前面设置
		if(total>=(partId[id])*18){
			getInfo(id);
		}
		else {
			console.log("已经没有数据申请了");
		}
	}
}
function getTotal(part,totalurl) {
	//part表示当前版块的id
	$.ajax({
		url:totalurl,
		success:function  (data,textStatus) {
			var temp=data.getElementsByTagName('total');
			if (textStatus=="success") {
				total=getValue(temp[0]);
				console.log(total);
			}
			else {
				console.log("读取总数失败");
			}
		},
		error: function  () {
			console.log("申请总数出错");
		}
	});
}
function ulCreateLi(art_id,user_id,title,time,author) {
	//这个文件创建一个li，并将其中的节点赋值
	var li=document.createElement("li");
	var ArtDiv=document.createElement("div");
	var img=document.createElement("img");
	var ptitle=document.createElement("p");
	var attenDiv=document.createElement("div");
	var psea=document.createElement("p");
	var ptime=document.createElement("p");
	var spanSea=document.createElement("span");
	var spanFlo=document.createElement("span");
	var spanAuth=document.createElement("span");
	var spanTime=document.createElement("span");
	ptime.appendChild(spanAuth);
	ptime.appendChild(spanTime);
	psea.appendChild(spanSea);
	psea.appendChild(spanFlo);
	attenDiv.appendChild(psea);
	attenDiv.appendChild(ptime);
	ArtDiv.appendChild(ptitle);
	ArtDiv.appendChild(attenDiv);
	li.appendChild(img);
	li.appendChild(ArtDiv);
	li.className="contLi block";
	img.className="block";
	ArtDiv.className="contArt";
	ptitle.className="conTitle";
	attenDiv.className="atten";
	spanAuth.className="author oneAtten";
	spanTime.className="time";
	/*
	   ptitle.innerText=title;
	   spanTime.innerText=time;
	   spanAuth.innerText=author;
	   */
	ptitle.innerHTML=title;
	spanAuth.innerHTML=author;
	spanTime.innerHTML=time;
	return li;
}
