<!DOCTYPE html>
<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
<html lang = "en">
<head>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title><?php echo $title?></title>
    <link rel="stylesheet" href="<?php echo $baseUrl.'css/test.css' ?>" type="text/css" media="all" />

    <base href="<?php echo base_url()?>" >
<body>
    <input type="button" name="btn" id="btn" value="点击一下吧" />
        <form id = "myImg" method="post" enctype = "multipart/form-data" accept-charset="utf-8" >
            <input type = "file" name = "userfile"  id = "userfile"/>
            <input type = "submit" name = "sub" value = "提交"/>
        </form>
    <img src = "" id = "toImg" />
</body>
    <script type="text/javascript" charset="utf-8">
    var siteUrl = "<?php echo site_url()?>"
    </script>
<script type="text/javascript" charset="utf-8" src = "js/jquery.js"></script>
<script type="text/javascript" charset="utf-8" src = "js/jquery.form.js"></script>
<script type="text/javascript" charset="utf-8" src = "js/test.js"></script>
</html>
