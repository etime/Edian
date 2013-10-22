<?php
/*************************************************************************
    > File Name :     ../../views/bgItemMan.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-17 01:29:38
 ************************************************************************/
$baseUrl = base_url();
$siteUrl = site_url();
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>商品管理</title>
</head>
<body>
    <table border = "1">
        <tr>
            <th>标题</th>
            <th>库存</th>
            <th>价格(元)</th>
            <th>状态</th>
            <th class = "oper">操作</th>
        </tr>
        <?php for($i = 0,$len  = count($item);$i < $len;$i++):?>
<?php
$now = $item[$i];
?>
        <tr>
            <td>
       <a href = "<?php echo $siteUrl.'/item/index/'.$now['id'] ?>" target = "__blank"><?php echo $now["title"] ?></a></td>
            <td><?php echo $now["store_num"] ?></td>
            <td>￥<?php echo $now["price"] ?></td>
            <td>
                <?php
                    if($now["state"] == 0 )echo "<span class = 'onsale'>销售中..</span>";
                    else if($now["state"] == 1)echo "<span class = 'down'>下架中..</span>";
                    else if($now["state"] == 2)echo "<span class = 'prp'>预备中..</span>";
                ?>
            </td>
            <td class = "oper">
                <a class = "prp" href = "<?php echo $siteUrl.'/bg/item/set/2/'.$now['id'] ?>">预备</a>/
                <a class = "del" href = "<?php echo $siteUrl.'/bg/item/set/2/'.$now['id'] ?>">删除</a>/
                <a class = "onsale" href = " <?php echo $siteUrl.'/bg/item/set/0/'.$now['id'] ?>">销售</a>/
                <a class = "down" href = " <?php echo $siteUrl.'/bg/item/set/1/'.$now['id'] ?>">下架</a>
            </td>
        </tr>
        <?php endfor?>
    </table>
<style type="text/css" media="all">
    table{
        border-spacing:0px;
        width:100%;
    }
    .del{
        color:#000;
    }
    .oper{
        width:170px;
    }
    td{
        text-align:center;
    }
    a{
        text-decoration:none;
    }
    a:hover{
        text-decoration:underline;
    }
    .prp{
        color:blue;
    }
    .onsale{
        color:red;
    }
    .down{
        color:green;
    }
</style>
</body>
</html>
