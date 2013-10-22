/***********
 *	author:			unasm
 *	email:			douunasm@gmail.com
 *	Last_Modefied:	2013/05/07 09:10:49 PM
 *	这里是为了修改用户的个人信息而存在的js
 */
$(document).ready(function  () {
	console.log("change");
	var name = true,phone = true,userName = $("#content input[name = 'userName']");
	$(userName).blur(function  () {
		namecheck(userName);
	})
	function namecheck(node){
		name = $(node).val();
		if(name == user_name)return false;
		reg = /[\[\];\"\/?:@=#&<>%{}\\|~`^]/;
		var temp = reg.exec(name);
		if(temp){
			report("抱歉,符号"+temp[0]+"不可以用","#name","red");
			name = false;
			return false;
		}
		if(name != ""){
			$.get(site_url+"/reg/get_user_name/"+encodeURI(name),function(data,status) {
				if(status === "success"){
					var id = $(data.getElementsByTagName('id')[0]).text();
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
		}
	}
	$("input[name = 'contra']").blur(function  () {
		$(this).unbind("keypress");
	}).focus(function  (event) {
		$("#contra").text("请输入手机或电话");
		$(this).keypress(function  (event) {
			console.log(event.which);
			if(((event.which<48)||(event.which>57))&&(event.which != 45)){
				return false;	
			}
		})
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
	$("#content input[name = 'userfile']").change(function  () {
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
	$("form").submit(function  () {
		if (!name) {
			report("请输入适合的用户名","#name","red");
			return false;
		}
		if(!phone){
			report("请至少输入一种联系方式","#contra","red");
			return false;
		}
	});
})
function report (cont,select,color) {
	$(select).text(cont);
	$(select).css("color",color);
}
