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
</style>
    <body>
        <ul>
<?php
if(!isset($store)){
    echo "die";
    die;
}
?>
        <?php foreach ($store as $value):?>
            <li>
                <input type="radio" name="storeId" id="<?php echo $value['id']?>" value="<?php echo $value['id']?>" />
                <label for = "<?php echo $value['id']?>">第一分店</label>
            </li>
        <?php endforeach?>
        </ul>
    </body>
</html>
