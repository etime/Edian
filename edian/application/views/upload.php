<!DOCTYPE html>
<html lang = "en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="<?php echo base_url("css/upload.css")?>" type="text/css" media="screen" charset="utf-8"/>
    <title>上传</title>
    <script type="text/javascript" src = "<?php echo base_url("js/jquery.js")?>" ></script>
<script type="text/javascript" src = "<?php echo base_url("js/upload.js")?>"></script>
<script type="text/javascript" >
    var site_url = "<?php echo site_url('')?>";
</script>
</head>
<body>
    <form method = 'post' action = "<?php echo site_url('chome/uploadDel')?>" enctype='multipart/form-data'>
        <input type = 'file' id = 'file' name = 'userfile' value = '选择图片' size = "11"/>
        <input type = 'submit' name = 'sub' value = '上传'/>
<!--
        <span id = 'showsize'>ESC键取消上传页面</span>
        <textarea id = 'textintro' name = 'intro'></textarea>
        <p id = 'spanintro'>简要介绍下图片吧</p>
-->
    </form>
</body>
</html>
