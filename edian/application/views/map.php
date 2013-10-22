<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body, html,#allmap {
	width: 100%;
	height: 100%;
	overflow: hidden;
	margin:0 auto;
}
	#l-map{height:100%;width:78%;float:left;border-right:2px solid #bcbcbc;}
	#r-result{height:100%;width:20%;float:left;}
	.arrow:after{
	 position:absolute;
	 border-right:14px dashed transparent;
	 border-left:14px dashed transparent;
	 border-bottom:8px solid #193047;
	 content:"";
	 top:-8px;
	 left:0;
	 border-radius:2px;
	}
	.mapli{
		background:"#193047",
		padding:"2px",
		color:"#D1D1D1",
		line-height:"18px",
		whiteSpace:"nowrap",
		font-size:"1em",
		position:"absolute",
		border-radius:2px,
		width:250px	
	}
	.test{
		width:80px;
		height:80px;
	}
</style>
<?php $baseUrl = base_url()?>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/jquery.js')?>" > </script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=672fb383152ac1625e0b49690797918d"></script>
<title>百度地图的Hello, World</title>
</head>
<body>
<div id="allmap"></div>
</body>
</html>
<script type="text/javascript" src = "<?php echo base_url('js/map.js')?>"></script>
