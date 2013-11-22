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
    <form action="<?php echo $siteUrl.'/bg/home/set' ?>" method="post" accept-charset="utf-8" enctype = "multipart/form-data">
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
					展示图片：
					<a href="<?php echo base_url('upload/'.$show_picture[0]->img_name)?>">
						<img src="<?php echo base_url('thumb/'.$show_picture[0]->img_name)?>"/>
					</a>

					<input type = 'file' id = 'upload_show_picture' name = 'upload_show_picture' value = '上传图片' size = "11"/> <br />

				</p>

        <input type="submit" name="sub"  value="提交" />
    </form>

</body>
</html>
