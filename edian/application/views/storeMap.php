<!DOCTYPE html>
<html>
<?php
    $baseUrl = base_url();
?>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>地图</title>
</head>
<body>
    <input type="hidden" name="longitude"  value="<?php echo $longitude ?>" />
    <input type="hidden" name="latitude"  value="<?php echo $latitude ?>" />
    <input type="hidden" name="name" id="22" value="<?php echo $name?>" />
    <input type="hidden" name="dist"  value=" <?php echo $deliveryArea ?>" />
    <h2><?php echo $name ?></h2>
    <div id = "allmap"></div>
</body>
<style type="text/css" media="all">
    #allmap{
        width:100%;
        height:400px;
    }
    h2{
        position:absolute;
        z-index:10;
        color:red;
    }
    body{
        margin:0;
    }
</style>
<script type="text/javascript" charset="utf-8">
    var baseUrl = "<?php echo $baseUrl ?>";
</script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/jquery.js' ?>"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=672fb383152ac1625e0b49690797918d"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/storeMap.js' ?>"></script>
</html>
