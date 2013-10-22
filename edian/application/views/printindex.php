<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html style="overflow-y:scroll"; xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<meta name="keywords" content="GPRS 无线 打印机">
<meta name="description" content="GPRS 无线 打印机">
<title>COMWAY云打印中心 - 信息打印</title>
<link href="css/css.css" rel="stylesheet" type="text/css">

<script src="js/base.js" type="text/javascript"></script>
<script src="js/jquery_cookie.js"></script>
<script src="js/jqUtils.js" type="text/javascript"></script>
<script src="js/boxy.js" type="text/javascript"></script>
<script src="js/common.js"></script>
<script src="js/jquery_table.js" type="text/javascript"></script>

</head>
<body>



<script src="js/jquery_cookie.js"></script>

<div id='ie6_notice' style="display:none"> </div><!-- 用以显示与ie6有关的提示信息-->
<div class="wrap" id="wrap">
	 <div class="top clear">
    <h1><a href="#">COMWAY云打印</a></h1>
    <span class="verInfo">测试版</span> </div>
  <div class="nav">
    <ul>
      <li class="current"><a href="index.php">首页</a></li>
    </ul>
    <span><a href="http://www.comway.com.cn/" target="_blank">COMWAY</a>　 </span> </div>
    
  <div class="left125">
    <div class="leftTop"></div>
    <ul class="leftList">
      <li class="">我的云打印</a></li>
	  <li class="current"><a href="index.php">信息打印</a></li>
    </ul>
    <div class="leftBottom"></div>
    
  </div>
 

<div class="righ825">
    <div class="righ825T righ825T2"></div>
    <div class="righ825C righ825C2">
	<div class="TopTit"><h3><strong>信息打印</strong></h3></div>
      <div class="sentLeft">
	  打印预览
      	<div class="sentLeftT"></div>
      	<div class="sentLeftC">
			<div id="display"></div>
		</div>
		<div class="sentLeftB"></div>
	  </div>
<div class="sentRight">

<form id="printForm" name="printForm" action="printapi.php" method="POST">
<input type="hidden" name="msgdetail" id="content" value="">
<table>
<tr><td>APP_ID：</td>
  <td>
  <input name="appid" type="text" class="textI210" id="member" value="">
</tr>
<tr><td>密 码：</td>
  <td>
  <input name="pass" type="password" class="textI210" id="security" value=">
</tr>
<tr><td>DTU_ID：</td>
  <td>
  <input name="dtuid" type="text" class="textI210" id="dtuid" value="">
</tr>
<tr>
    <td></td>
    <td>
  <tr>
    <td>打印内容：</td>
    <td><div class="sentInfo fl"><div class="sentInfoT"></div><textarea class="sentInfoC" id="inputArea"  onkeyup="changebyte()" onchange="changebyte()" ></textarea><div class="sentInfoB"></div></div><span class="formInfo fl" style="width:140px;">说明：每次打印内容最好控制在500字内超出500字的内容将进行GPRS分块传输，打印一次完成。
</span></td>
  </tr>
  <tr>
    <td></td>
    <td><div class="topBlue">
        <input type="button"  id="print_btn" href="javascript:void(0)" value="发送" />
      </div></td>
  </tr>
</table>
</form>
	</div>
    </div>
    <div class="righ825B righ825B2"></div>
  </div>

<div class="fram572Wrap" id="framepage" style="display:none">
  <div class="fram572Top"></div>
  <div class="fram572Con">
    <div class="framTop clear">
      <h3>页眉文字</h3>
      <a class="framClose" href="javascript:void(0)" id="closeFramePageNoSave"></a></div>
    <div class="framCon clear">
    <div class="sentInfo fl"><div class="sentInfoT"></div><textarea    maxlength="64" id="sentInfoC" class="sentInfoC"  ></textarea><div class="sentInfoB"></div></div>
      <i class="c999">最多输入两行，每行32个字符。</i></div>
     <div class="framBottom"><i class="butS1"><a href="javascript:void(0)" id="leaveFramePageNoSave">取消</a></i><i class="butS6"><a href="javascript:void(0)" id="leaveFramePageSave">确定</a></i></div>
  </div>
  <div class="fram572Bottom"></div>
</div>
<script language="JavaScript">
var printContent = "";
function changebyte(){
	var preview = "";
	var framepage = "";
	var content = "";
	content = document.getElementById("inputArea").value;
	printContent = framepage + content;
	preview = getPrintPreview(printContent, 32);

	document.getElementById("display").innerHTML = preview;
	return true;
}
function getPrintContent() {
	return printContent;
}
function addOrDelFramePage()
{
	changebyte();
}
var initInputArea = false;
function inputAreaMouseDown()
{
	if (!initInputArea) {
		initInputArea = true;
		document.getElementById("inputArea").value = "";
		changebyte();
	}
}
changebyte();
</script>
</div>

<script type="text/javascript">
$(function(){
	$("#print_btn").click( function (){
		var content = getPrintContent();
		if(content.length > 2500){
			alert("内容请控制在2500字内");
			return;
		}
		else if(content == ""){
			alert("请输入需要打印的内容");
			return;
		}
		document.getElementById("content").value = content;
		document.getElementById("print_btn").disabled = true;
		document.getElementById("print_btn").value='正在发送';
		$("#printForm").submit();
		return false;
	});
	$("#myenterFramePage").click(function(){
		enterFramePage();
	});
	$("#closeFramePageNoSave").click(function(){
		leaveFramePageNoSave();
	});
	$("#leaveFramePageSave").click(function(){
		leaveFramePageSave();
	});
	$("#leaveFramePageNoSave").click(function(){
		leaveFramePageNoSave();
	});
});
function   date2str(d){ 
var   ret=d.getFullYear()
ret+=( "00"+(d.getMonth()+1)).slice(-2)
ret+=( "00"+d.getDate()).slice(-2)
ret+=( "00"+d.getHours()).slice(-2)
ret+=( "00"+d.getMinutes()).slice(-2)
ret+=( "00"+d.getSeconds()).slice(-2)
return   ret
} 

function AddText(className) {
	var str1 = "<$bl:>";
	var str2 = "<$bl&>";
	var ubb=document.getElementById("content");
	var ubbLength=ubb.value.length;
	ubb.focus();
	if(typeof document.selection !="undefined") {
		var text = document.selection.createRange().text;
		document.selection.createRange().text=str1+text+str2; 
	} else {
		var text = ubb.value.substring(ubb.selectionStart,ubb.selectionEnd);
		ubb.value=ubb.value.substring(0,ubb.selectionStart)+str1+text+str2+ubb.value.substring(ubb.selectionEnd,ubbLength);
	}
}
var body = document.body;
var bodyWidth = parseInt((body.scrollWidth<body.clientWidth)?body.clientWidth:body.scrollWidth);
var bodyHeight = parseInt((body.scrollHeight<body.clientHeight)?body.clientHeight:body.scrollHeight);
var clientWidth=body.clientWidth;
var clientHeight=body.clientHeight;
var trans=50;
var width = 572;
var height = 194;
var ie6=!-[1,]&&!window.XMLHttpRequest;
with(document.getElementById('framepage').style) {
	zIndex = 10000;
	backgroundColor="#FFFFFF";
	display = "none";
}
var DivMid = document.createElement("div");
with(DivMid.style)
{
	display = "none";
	zIndex = 9999;
	position = "fixed";
	height = "100%";
	width = "100%";
	top = 0;
	left = 0;
	border = "0 none";
	//backgroundColor = "#BDBFBD";
	backgroundColor = "#202020";
}
DivMid.id = "Div2";
body.appendChild(DivMid);

function isIE() {
	return (document.all && window.ActiveXObject && !window.opera) ? true : false;
}
function center(win){
	var s = parseInt(body.scrollTop + clientHeight/2 - height/2);
	win.style.top = ((s<body.scrollHeight-height)?s:body.scrollHeight)+"px";
	var s = parseInt(body.scrollLeft + clientWidth/2 - width/2);
	win.style.left = ((s<body.scrollWidth-width)?s:body.scrollWidth)+"px";
}
function openFramePage(){
	with(document.getElementById('Div2').style){
		width = bodyWidth;
		height = bodyHeight;
		overflow = "hidden";
		display = "";
		if (isIE()){
			filter = " Alpha(Opacity="+trans+")";
			if(ie6){position="absolute";}
		}else{
			opacity = trans/100;
		}
	}
	with(document.getElementById('framepage').style){
		display = "";
	}
	center(document.getElementById('framepage'));
}

function closeFramePage(){
	with(document.getElementById('Div2').style) {
		display = "none";
	}
	with(document.getElementById('framepage').style) {
		display = "none"; 
	}
}

var oldFramePageContent = "";
function enterFramePage(){
	oldFramePageContent = document.getElementById("sentInfoC").value;
	openFramePage();
}
function leaveFramePageNoSave(){
	closeFramePage();
	document.getElementById("sentInfoC").value = oldFramePageContent;
}

function leaveFramePageSave(){
	var framePage = document.getElementById("sentInfoC").value;
	var result = $.feyin.ajax.setFramePage(framePage);  
	
	if (result < 0){
		showTips("保存页眉失败", 10);
		document.getElementById("sentInfoC").value = oldFramePageContent;
	} else {
		showTips("保存页眉成功", 10);
	}
	closeFramePage();
	changebyte();
}

</script>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-16534373-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>
