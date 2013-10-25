<!DOCTYPE html>
 <html lang = "en">
     <head>
<?php
$baseUrl = base_url();
$siteUrl = site_url();
$base = $siteUrl."/userCenter/";
?>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>后台管理页面</title>
<link rel="stylesheet" type="text/css" href="<?php echo  $baseUrl.("css/userCenter.css")?>"/>
 </head>
 <body>
    <div class="top">
        <h2>这里做成头部,显示个logo或者是用户名之类的吧</h2>
    </div>
    <ul class="sidebar" id = "sidebar">
        <li>
            <a href="">我的关注</a>
        </li>
        <li>
            <a href="">求关注</a>
        </li>
    </ul>
</body>

 </html>
