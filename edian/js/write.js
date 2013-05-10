$(document).ready(function  () {
	var value,NoImg = 1,doc = document;
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
		value = $.trim($("input[type = 'file']").val());
		if((value.length==0)&&(NoImg == 1)){
			NoImg = 0;//第一次见到之后，就去掉这个提示
			alert("忘记添加图片，如果确实不需要图片，再次点击发表即可");//这里或许给出一些改进
			return false;
		}
	})
	/************控制title中的字体显隐**************/
	$("#title").focus(function(){
		$("label[for = 'title']").hide();
	}).blur(function  () {
		value = $.trim($(this).val());
		if(value.length == 0){
			$("label[for = 'title']").show();
		}
	});
})
