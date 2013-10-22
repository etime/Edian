<?php
/*************************************************************************
    > File Name :     ../../views/bgart.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-22 14:51:20
 ************************************************************************/
$siteUrl = site_url();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>二手处理</title>
    </head>
    <body>
        <table border="1">
            <tr>
                <th>标题</th>
                <th>价格</th>
                <th>楼主</th>
                <th>时间</th>
                <th>浏览/评论</th>
                <th>操作</th>
            </tr>
        <tbody>
        <?php
            if($art)$len = count($art);
            else $len = 0;
        ?>
        <?php for($i = 0;$i < $len;$i++):?>
            <?php
                $temp = $art[$i];
            ?>
            <tr>
                <td>
                    <a href = "<?php echo $siteUrl.'/showart/index/'.$temp['art_id'] ?>" target = "_blank"><?php echo $temp["title"] ?></a>
                </td>
                <td><?php echo $temp["price"] ?></td>
                <td>
                    <a href = "<?php echo $siteUrl.'/user/index/'.$temp['author_id'] ?>">
                    <?php echo $temp["author_id"] ?>
                    </a>
                </td>
                <td><?php echo $temp["time"] ?></td>
                <td><?php echo $temp["visitor_num"]."/".$temp["comment_num"] ?></td>
                <td>删除/编辑</td>
            </tr>
        <?php endfor ?>
        </tbody>
        </table>
    <style type="text/css" media="all">
        td{
            text-align:center;
        }
        table{
            width:100%;
            border-spacing:0px;
        }
    </style>
    </body>
</html>
