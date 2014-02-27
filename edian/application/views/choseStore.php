<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>选择店铺</title>
    </head>
<style type="text/css" media="all">
    ul{
        list-style:none;
    }
    body{
        width:500px;
        margin:0px auto;
    }
    li:hover{
        text-decoration:underline;
    }
<?php
 $siteUrl = site_url();
?>
</style>
    <body>
        <h2>请选择店铺</h2>
        <ul>
        <?php foreach ($store as $value):?>
            <li>
                <input type="radio" name="storeId" id="<?php echo $value['id']?>" value="<?php echo $value['id']?>" />
                <a href = "<?php echo $siteUrl . '/bg/home/index/' . $value['id']?>"><?php echo $value['name'] ?></label>
            </li>
        <?php endforeach?>
        </ul>
    </body>
</html>
