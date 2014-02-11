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
            <th>全站类别</th>
            <th>本店类别</th>
            <th>商品名</th>
            <th>库存</th>

            <th>价格(元)</th>
            <?php
                if(isset($isAdmin) && $isAdmin){
                    echo '<th>积分</th>';
                }
            ?>
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
                <?php echo $now['category']['keyi'] . ' >> ' . $now['category']['keyj'] . ' >> ' . $now['category']['keyk'] ?>
            </td>
            <td>
                <?php
                    echo $now['category']['category'];
                ?>
            </td>
            <td>
       <a href = "<?php echo $siteUrl.'/item/index/'.$now['id'] ?>" target = "__blank"><?php echo $now["title"] ?></a></td>
            <td><?php echo $now['storeNum'] ?></td>
            <td>￥<?php echo $now["price"] ?></td>
            <?php
                if(isset($isAdmin) && $isAdmin){
                    echo '<td> <input type="text" name="rating" value=' . $now['rating']. ' /><td>';
                }
            ?>
            <td>
                <?php
                    echo '<span>' . $stateMark[$now['state']]. ' </span>';
                ?>
            </td>
            <td class = "oper">
                <?php
                if($stateMark){
                    foreach ($stateMark  as $key => $val) {
                        echo "<a href = '$siteUrl/bg/item/set/$key' " . $now['id'] . ">$val</a>";
                    }
                }
                    echo '<a href = ' . $siteUrl .'/bg/item/update/' . $now['id'] . '>修改</a>';
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
    tr:hover{
        background:rgb(145, 214, 145);
    }
</style>
</body>
</html>
