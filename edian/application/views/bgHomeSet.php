<?php
/*************************************************************************
    > File Name :     ../views/bgHomeSet.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-16 13:13:58
 ************************************************************************/
?>
<!Doctype  html>
<html lang = "en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />

    <title>商城设置</title>
<?php
    $siteUrl = site_url();
?>
</head>
<body>
    <form action="<?php echo $siteUrl.'/bg/home/setAct' ?>" method="post" accept-charset="utf-8" enctype = "multipart/form-data">
<?php
    if(!isset($dtuNum))$dtuNum = "";
    if(!isset($dtuId))$dtuId = "";
    if(!isset($lestPrc))$lestPrc = "";
    if(!isset($dtuName))$dtuName = "";
    if(!isset($intro))$intro = "";
?>
        <h3>本页内容可选</h3>
        <p>
            DTU名称:
            <input type="text" name="dtuName" value = "<?php echo $dtuName ?>" />
        </p>
        <p>
            DTU编号:
            <?php
            if($type == 1){
                //1 是商家的类型
                echo "<input type='text' name='dtuNum' value = '".$dtuNum."' disabled />";
            }else if($type == 3){
                //3 目前是管理员，大概以后3以上就是各种管理员了吧
                echo "<input type='text' name='dtuNum' value = '".$dtuNum."'/>";
                echo "DTU 的ID<input type='text' name='dtuId' value = '".$dtuId."'/>";
                echo "<p>用户的编号<input type='text' name='user_id' /></p>";
            }else{
                //还有什么其他的情景吗？
            }
            ?>
        </p>
        <p>
            最低起送价:(外卖商家请输入最低起送价,没有则视为0)
            <input type="text" name="lestPrc" value = "<?php echo $lestPrc ?>"/>
        </p>
        <p>
             本店介绍(输入链接):
            <input type="text" name="intro"  value = "<?php echo $intro ?>" />
        </p>
        <p title = "在用户下单的时候，订购短信的卖家可以在没有其他的通知方式的时候，收到短信通知,每条短信5毛">
            是否订购"下单短信通"服务
    <?php
        if(isset($smsOrd) && ($smsOrd))
            echo "<input type = 'checkbox' name = 'smsOrd' checked = 'checked'>";
        else{
            echo "<input type='checkbox' name='smsOrd'/>";
        }
    ?>
        </p>
<!--
        <textarea name="procast"></textarea>
-->
        <input type="submit" name="sub"  value="提交" />
    </form>
</body>
</html>
