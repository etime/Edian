$(document).ready(function  () {
	var value,doc = document;
	$("#sorry").click(function  () {
		alert("抱歉，让您选择\"其他\"是我们分类的不够细致，请联系管理员"+admin+"帮忙");
	})
	$("input[name = 'price']").blur(function  () {
		$(this).unbind("keypress");
	}).focus(function  (event) {
		$(this).keypress(function  (event) {
			if((event.which<46)||(event.which>57)){
				return false;	
			}
		})
	}).change(function  () {
		value = $.trim($(this).val());
		reg = /^\d+.?\d*$/;
		if(!reg.exec(value)){
			$("#patten").text("请输入小数或者整数");
		}
	});
	$("input[type = 'file']").change(function  () {
		value = $.trim($(this).val());
		console.log(value);
		reg = /.[gif|jpg|jpeg|png]$/i;//图片只允许gif,jpg,png三个格式
		if(!reg.exec(value)){
			$("#imgAtten").text("只有gif,png,jpg格式图片可以");	
		}
		var size = $(this)[0].files[0].size / 1000;
		size = parseInt(size)/1000;
		if(size>2){
			$("#imgAtten").text(size+"超过2M了，上传失败的风险很大");	
		}
	})
	$("form").submit(function  () {
		value = $.trim($("input[name = 'price']").val());
		if(value.length  == 0){
			$.alet("请输入价格");
			return false;
		}
		value = $.trim($("#title").val());
		if(value.length == 0){
			$.alet("忘记添加标题");
			return false;
		}
		value = doc.getElementById("cont");
		value = $.trim(value.value);
		if(value.length == 0){
			$.alet("请添加内容");
			return false;
		}
	})
	/************控制title中的字体显隐**************/
	//var temp = $("label[for = 'title']");
	//if(temp.text().length!=0)temp.hide();//如果有长度，就隐藏
	//$("label[for = 'title']").hide();//因为开始一般都会有title，所以隐藏提示
	var label;
	$(".title").focus(function(){
		label = $(this).siblings("label");
		$(label).css("display","none");
		//$(label).hide();
		//$("label[for = 'title']").hide();
		//$(this).siblings("label").hide();
	}).blur(function  () {
		value = $.trim($(this).val());
		if(value.length == 0){
			$(label).css("display","block");
		//	$("label[for = 'title']").show();
		}
	});
	dir = eval(dir);
	part(dir);
})
function part (list) {
	var part = $("#part"),temp,tempk = null,valuek,valuej;//不同层次对应的list 中value
	keyword = keyword.split(" ");
		part.delegate("input","click",function () {
		var texts = $(this.nextSibling).text();
		getSon(texts);
	})
	$("#part input").each(function  () {
		if(this.checked){
			//getSon($(this.nextSibling).text());
			var text = $(this.nextSibling).text(),check;
			$.each(list,function  (key,value) {
				if(key == text){
				valuej = value;
				var kj;//keyj为第二层找到的关键字，就是被checked的部分，需要根据它添加关键字呢
					temp = "<p id = 'kj'><span class = 'item'>"+text+"</span>";
					var flag = 0;
					for(var keyj in value){
						check = "";
							for(var i = 0,len = keyword.length;i<len;i++){
								if(keyword[i] == keyj){
									check = "checked = 'checked'";
									flag = 1;
									kj = keyj;
									break;
								}
						}
						temp+="<input type = 'radio' name = 'keyj' value = "+keyj+" "+check+"><span>"+keyj+"</span>";
					}
					if(flag == 0){
						temp+="<input type = 'radio' name = 'keyj' value = '其他' checked = 'checked'><span>其他</span><p>";
						part.after(temp);
						return;
					}
					temp+="<input type = 'radio' name = 'keyj' value = '其他'><span>其他</span>";
					temp+="</p>";
					part.after(temp);
					$.each(value,function  (key,valk) {
						if(key == kj){
							valk = decodeURI(valk).split(",");
							valuek = valk;
							temp = "<p id = 'kk'><span class = 'item'>"+key+"</span>";
							flag = 0;
							for(var k = 0,len = valk.length;k<len;k++){
									check = "";
									for(var i = 0,ilen = keyword.length;i<ilen;i++){
										if(keyword[i] == valk[k]){
											check = "checked = 'checked'";
											flag = 1;
											break;
										}
									}
								temp+="<input type = 'radio' name = 'keyk' value = "+valk[k]+" "+check+"><span>"+valk[k]+"</span>";
							}
							if(flag == 0)check = "checked = 'checked'";
							temp+="<input type = 'radio' name = 'keyk' value = '其他' "+check+"><span>其他</span></p>";
							$("#kj").after(temp);
						}
					});
				}
			})
		}
	})
	$("#kj").delegate("input","click",function  () {
		text = $(this.nextSibling).text();
		$("#kk").detach();
		$.each(valuej,function  (keyj,vj) {
			if(text == keyj){
				vj = decodeURI(vj).split(",");
				tempk="<p id = 'kk'><span class = 'item'>"+keyj+"</span>";
				for (var k = 0,len = vj.length;k<len;k++) {
					tempk+="<input type = 'radio' name = 'keyk' value = "+vj[k]+"><span>"+vj[k]+"</span>";
				}
				tempk+="<input type = 'radio' name = 'keyk' value ='其他' ><span>其他</span>";
				tempk+="</p>";
				$("#kj").after(tempk);
				return;
			}
		})
	})
	function getSon (text) {
		$("#kk").detach();
		$("#kj").detach();//清空之前添加的，防止错误
		$.each(list,function  (key,value) {
			if(key == text){
				if (temp)$("#kj").detach();
				temp = "<p id = 'kj'><span class = 'item'>"+text+"</span>";
				for(var keyj in value){
					temp+="<input type = 'radio' name = 'keyj' value = "+keyj+"><span>"+keyj+"</span>";
				}
				temp+="<input type = 'radio' name = 'keyj' value = '其他'><span>其他</span>";
				temp+="</p>";
				part.after(temp);
				return;
			};
		})
	}
}
