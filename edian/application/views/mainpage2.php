<!DOCTYPE html>
<html lang = "en">
<head>
<?php
$siteUrl = site_url();
$baseUrl = base_url();
?>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title>E点</title>
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/mainpage2.css')?>" type="text/css" charset="UTF-8">
    <link rel="stylesheet" href="<?php echo $baseUrl.('css/flexslider.css')?>" type="text/css" charset="UTF-8">
    <link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var base_url = "<?php echo base_url()?>";
var user_name="<?php echo trim($this->session->userdata('user_name'))?>";
var user_id="<?php echo trim($this->session->userdata('user_id'))?>";
var userPhoto = "<?php echo isset($user_photo)?$user_photo:null?>";
var mail = "<?php echo isset($mailNum)?$mailNum:null?>";
var com = "<?php echo isset($comNum)?$comNum:null?>";
var now_type ;
</script>
</head>
<body>
<?php
//这里显示的敌人的内容，独立成为一个新的文件了
echo $this->load->view("dir");
?>
<!--[if lte IE 6]>

<div id="ie7-warning">
您正在使用 Internet Explorer 6 或更低版本的IE浏览器，他们已经是10年前的浏览器了，为了您更好的浏览，体验更新更炫的效果，建议您将使用 <a href="http://windows.microsoft.com/zh-cn/internet-explorer/help/ie-9/9-reasons-to-get-internet-explorer-9" target="_blank">IE9</a> 或下列浏览器：<a href="https://www.google.com/intl/zh-CN/chrome/browser">Chrome(谷歌浏览器)</a>/<a href="http://www.firefox.com.cn/download/">Firefox(火狐)</a>/ <a href="http://www.apple.com.cn/safari/">Safari(苹果)</a> / <a href="http://www.Opera.com/">Opera(欧朋)</a>
</div>
 <![endif]-->
        <a name = "0"></a>
        <ul id="ulCont" class = "clearfix content" >
            <div class = "flexslider" id = "flexslider" >
                <ul class="slides">
                    <li data-thumb = "<?php  echo $baseUrl.('upload/slider.jpg')?>"><img src = "<?php  echo $baseUrl.('upload/slider.jpg')?>"></li>
                    <li data-thumb = "<?php  echo $baseUrl.('upload/slider.jpg')?>"><img src = "<?php  echo $baseUrl.('upload/slider.jpg')?>"></li>
                    <li data-thumb = "<?php  echo $baseUrl.('upload/slider.jpg')?>"><img src = "<?php  echo $baseUrl.('upload/slider.jpg')?>"></li>
                    <li data-thumb = "<?php  echo $baseUrl.('upload/slider.jpg')?>"><img src = "<?php  echo $baseUrl.('upload/slider.jpg')?>"></li>
                </ul>
            </div>
            <!----这里是我放置主要内容的地方，通过js加载---->
            <div id = "cont">
            </div>
            <!--cont 结束-->
            <p class = "clearfix pageDir np" id = "end">
                <button  id = "np" class = "butCol et" >下一页</button>
            </p>
        </ul>
<!-----------谁能看出来content才是主要内容显示的-------------->
<!---------罪恶的跳跃栏-------->
    <div id="bottomDir" class = "clearfix">
        <ul >
            <button id = "hiA" class = "block et hiA butCol" style = "display:none">隐藏</button>
            <a href = "#0"><li class = "block botDirli">1</li></a>
        </ul>
    </div>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/jquery.js')?>" > </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/cookie.js')?>" > </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/mainpage2.js')?>" > </script>
  <script defer src="<?php echo $baseUrl.('js/flexslider-min.js') ?>"></script><script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "fade",
        controlNav: "thumbnails",
        animationSpeed:"1000",
        slideshowSpeed:"5000",
        easing:"swing",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
  <script>window.jQuery || document.write('<script src="http://api.map.baidu.com/api?v=1.5&ak=672fb383152ac1625e0b49690797918d">\x3C/script>')</script>
</body>
</html>

