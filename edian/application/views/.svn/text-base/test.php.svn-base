<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">

		<title>这里现在是用来的是移动图片的</title>
			<link rel="stylesheet" href="<?php echo base_url('css/test.css')?>" type="text/css" harset="utf-8">
<script type="text/javascript" src="<?php echo base_url('js/jquery.js')?>" ></script>
<script type="text/javascript" >
$(document).ready(function(){
	$("button").click(function(){
		var obj = $.ajax({
			url:"<?php echo site_url('test/respon')?>",
				complete:function (XHR,TS)
				{
					console.log("before complete");
					console.log(XHR);
					 console.log(TS);
					console.log("here is the complete`");
				},
				success:function (data,textStatus)
				{
					console.log(data);
					console.log(textStatus);
					$("#atten").html(textStatus);
				},
				error: {
					console.log("button.ajax请求错误");
				}

		});
});
});
</script>
	</head>
<body>
	<div class="ttt">
		<span> here is the span</span>
		<p>asdfsda</p>
	</div>
	<h2>This is the headingmainpage2</h2>
	<p id="test">This is a paragraph</p>
	<p>This the the second paragraph</p>
	<span id="atten"></span>
	<span id="atten"></span>
<button>Click me </button>
</body>
</html>
