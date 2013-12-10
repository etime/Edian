<!DOCTYPE html>
<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
<html lang = "en">
<head>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title>祝你开心</title>
<style type="text/css" media="all">
body, html,#allmap {width: 500px;height: 300px;overflow: hidden;margin:0;}
</style>
<body>
    <p>
        送货半径:<input type="text" name="distance" id="distance" value="1000" />米
<input type="button" name="but" id="but" value="set" />
    </p>
    <div id = "allmap"></div>
</body>
<script type="text/javascript" charset="utf-8">
    var siteUrl = "<?php echo site_url()?>";
    var baseUrl = "<?php echo base_url()?>";
</script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/jquery.js'?>"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=f0uIeSS1Zgh8O3CBdVUM5xRN"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/test.js'?>"></script>
</html>
