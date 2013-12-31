<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="<?php echo $baseUrl.'css/pagesplit.css' ?>" type="text/css" media="all" />
    <title>商品管理</title>
</head>
<body>
<?php
    if(isset($storeList)){
        $form = "<form action='' method='post' accept-charset='utf-8'>" .
            "选择店铺:<select name = 'storeId'>" ;
        foreach ($storeList  as $store) {
            $form .= "<option value = " . $store['id'] .">" . $store['name']. "</option>";
        }
        $form .="</select><input type='submit' name='sub' value='提交' /></form>";
        echo $form;
    }
?>
    <table border = "1">
        <tr>
            <th>标题</th>
            <th>库存</th>
            <th>价格(元)</th>
            <th>状态</th>
            <th class = "oper">操作</th>
        </tr>
<?php
    if($item){
        $len  = count($item);
    }else {
        $len = 0;
    }
?>
        <?php for($i = 0;$i < $len;$i++):?>
<?php
$now = $item[$i];
?>
        <tr>
            <td>
       <a href = "<?php echo $siteUrl.'/item/index/'.$now['id'] ?>" target = "__blank"><?php echo $now["title"] ?></a></td>
            <td><?php echo $now['storeNum'] ?></td>
            <td>￥<?php echo $now["price"] ?></td>
            <td>
                <?php
                    /*
                    if($now["state"] == 0 )echo "<span class = 'onsale'>销售中..</span>";
                    else if($now["state"] == 1)echo "<span class = 'down'>下架中..</span>";
                    else if($now["state"] == 2)echo "<span class = 'prp'>预备中..</span>";
                    */
                    echo '<span>' . $stateMark[$now['state']]. ' </span>';
                ?>
            </td>
            <td class = "oper">
                <?php
                foreach ($stateMark  as $key => $val) {
                    echo "<a href = '$siteUrl/bg/item/set/$key' " . $now['id'] . ">$val</a>";
                }
                ?>
            </td>
        </tr>
        <?php endfor?>
    </table>
<?php
if(isset($pageNumFooter))
    echo $pageNumFooter;
?>
<style type="text/css" media="all">
    table{
        border-spacing:0px;
        width:100%;
    }
    .del{
        color:#000;
    }
    .oper{
        width:190px;
    }
    .oper a{
    margin:0 5px;
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
