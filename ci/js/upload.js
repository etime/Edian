$(document).ready(function(){
	$("#textintro").focus(function  () {
		if(this.value == "")
		$("#spanintro").fadeOut();
	});
	$("#file").change(function  () {
		var size = $(this)[0].files[0].size/1000;
		size = parseInt(size*10)/10;
		if(size > 2000){
			$("#showsize").text(size+"KB,超过2M会导致上传失败,请压缩后上传");
			$("#showsize").css("color","red");
		}
		else{
			var reg = /.(png|jpg|jpeg|gif)$/i;
			if(!reg.exec(this.value)){
				$("#showsize").text("支持png，jpg，gif格式图片，其他的文件会上传失败");
			}else {
				if(this.value.length> 100){
					$("#showsize").text("文件名太长了，请重命名后上传");
					$("#showsize").css("color","red");
				}else{
					reg = /[%].(png|jpg|gif|jpeg)$/i;
					var name = this.value;
					console.log(name);
					console.log(reg.exec(name));
					$.ajax({
						url:site_url+"/chome/check/"+name,
						success:function(data){
							console.log(data);
						},
						error:function  (xml) {
							console.log(xml);
						}
					});
				}
				
				$("#showsize").text("没有问题，可以上传");
				$("#showsize").css("color","green");
			}
		}
	});
})
