<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title><?php echo $title?></title>
</head>
<body>
<table>
    <tr>
        <th>评论号</th>
        <th>评论者编号</th>
        <th>评论商品编号</th>
        <th>评论商品标题</th>
        <th>商品得分</th>
        <th>评论内容</th>
        <th>评论时间</th>
        <th>操作</th>
    </tr>
    <?php
    for ($i = 0, $len = (int)count($com); $i < $len; $i ++) {
        echo('<tr>');

            echo('<th>' . $com[$i]['id'] . '</th>');
            echo('<th>' . $com[$i]['user_id'] . '</th>');
            echo('<th>' . $com[$i]['item_id'] . '</th>');
            echo('<th>' . $com[$i]['title'] . '</th>');
            echo('<th>' . $com[$i]['score'] . '</th>');
            echo('<th>' . $com[$i]['context'][0][3] . '</th>');
            echo('<th>' . $com[$i]['context'][0][2] . '</th>');
            echo('<th>');
            $url = '#';
            echo("<span><a href='" . $url . "'>回复</span>");
            if (! $isAdmin) {
                $url = '#';
                echo("<span><a href='" . $url . "'>删除</span>");

                $url = '#';
                echo("<span><a href='" . $url . "'>修改</span>");
            }
            echo('</th>');

        echo('<tr>');
    }
    ?>
</table>
</body>
</html>