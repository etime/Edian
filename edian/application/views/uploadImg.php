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
    <form method = 'post' action = "<?php echo $url?>" enctype='multipart/form-data'>
        <input type = 'file' id = 'file' name = 'userfile' value = '上传图片' size = "11"/>
        <br/>
        <input type = 'submit' name = 'sub' value = '上传'/>
        <p id = "showsize"></p>
    </form>
</body>
</html>
