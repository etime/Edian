<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>错误处理</title>
    </head>
    <body>
        <table border="1">
            <tr>
                <th>错误详情</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
            <?php foreach ($wrong as $value) :?>
            <tr>
                <td><?php echo $value['content'] ?></td>
                <td><?php echo $value['time'] ?></td>
                <td>
                    <a href = "<?php echo $siteUrl."/wrong/deleteLog/".$value["id"] ?>">
                        删除
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
    </body>
<style type="text/css" media="all">
    tr:hover{
        background:yellow;
    }
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
</style>
</html>
