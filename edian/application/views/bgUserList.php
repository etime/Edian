<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>用户的列表</title>
</head>
<style type="text/css" media="all">
    table{
        border-spacing:0;
        width:100%;
    }
    td{
        padding:5px;
        text-align:center;
    }
</style>
<?php
    $siteUrl = site_url();
?>
<body>
    <table border="1">
        <tr>
            <th>id</th>
            <th>身份</th>
            <th>昵称</th>
            <th>登录名</th>
            <th>注册时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <tbody>
        <?php
            $str = "";
            if($userList){
                $len = count($state);
                foreach ($userList  as $user) {
                    $str .= '<tr>' .
                            '<td> ' . $user['id']. '<td>' .
                            '<td>' . $user['nickname'] . '</td>' .
                            '<td>' . $user['loginName'] . '</td>' .
                            '<td>' . $user['registerTime'] . '</td>' .
                            '<td>' . $state[$user['state']] . '</td>' ;
                        $operstr = '<td>';
                        for($i = 1 ; $i < $len ; $i++){
                            $operstr .= "<a href = '" . $siteUrl . '/bg/userlist/userUpdate/' . $user['id'] . '/' . $i . "'>$state[$i]</a>";
                        }
                        $str .= "$operstr </td></tr>" ;
                }
                echo $str;
            }
        ?>
            <tr>
            </tr>
        </tbody>
    </table>
</body>
</html>
