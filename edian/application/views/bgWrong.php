<?php
/*************************************************************************
    > File Name :     ../views/bgWrong.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-18 10:49:23
 ************************************************************************/
//这里处理的是后台的错误
?>
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
                <th>操作</th>
            </tr>
<?php
    if($wrong)$len = count($wrong);
    else $len = 0;
?>
            <?php for($i = 0;$i < $len;$i++): ?>
            <tr>
<?php
    $temp = $wrong[$i];
    if($flag == 1){
        $str = "打印出错：".$temp["content"]->pntState."<br/>";
        $str .="商家:".$temp["content"]->seller["user_name"]." 联系方式".$temp["content"]->seller["contract1"]."<br/>";
        $str .="买家:".$temp["content"]->buyer["user_name"]." 联系方式".$temp["content"]->buyer["contract1"];
        echo "<td>".$str."</td>";
    }else echo "<td>其他原因</td>";
?>
                <td>
<?php
    if($flag == 1){
        echo "打印";
    }
?>
                    删除
                </td>
            </tr>
            <?php endfor ?>
        </table>
    </body>
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
</style>
</html>
