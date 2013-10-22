var geter = "#content input[name = 'geter']";
$(document).ready(function  () {
	user_id = $.trim(user_id);
	if(user_id.length == 0){
		$.alet("请首先登陆，不然发送会失败哦");
		return false;
	}
	$(geter).change(function  () {
		user = $.trim($(this).val()).split("(")[0];//获取其中的用户名，没有（）的话，直接得到其中的内容
		getId(user);
	});
	$("#content form").submit(function  () {
		userId = $.trim($(geter).val());
		if(userId.length == 0){
			$.alet("请输入用户名");//不再修改用户名，这么复杂的判断，在服务端判断去吧
			return false;
		}
		var title = $.trim($("input[name = 'title']").val());
		if(title.length  == 0){
			$.alet("请输入标题");
			return false;
		}
	});
});
function getId(user){
	$.ajax({
		url:site_url+"/reg/get_user_name/"+user,
		success:function  (data,textStatus) {
			if(textStatus == "success"){
				var id = data.getElementsByTagName("id");
				id = $(id["0"]).text();
				if(id == "0"){
					$(geter).val($(geter).val()+"(请检查收件人用户名，数据库中找不到匹配)");
				}
				else $(geter).val($(geter).val()+"("+id+")");
			}
			else {
				console.log(textStatus+"出错了，请联系管理员1264310280@qq.com,谢谢");
			}
		}
	});
}
