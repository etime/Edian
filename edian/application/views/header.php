<?php
/*************************************************************************
    > File Name :     ../views/header.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-15 00:29:53
 ************************************************************************/

?>
<!DOCTYPE html>
<html lang = "en">
<head>
<?php
$siteUrl = site_url();
$baseUrl = base_url();
?>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <link rel="stylesheet" href=" <?php echo $baseUrl."css/header.css" ?>" type="text/css" media="all" />
</script>
</head>
<body>
    <div class = "header body clearfix">
        <div class = "clearfix">
            <div class = "dl">
                <img src = "http://images.wunme.com/a01/chyeajender1/chyea/fimages/3722/sevdswbyp.jpg"  class = "logo"/>
                <span>点</span>
            </div>
            <p class = "hinf">
                <a href = "about:blank" class = "lok afli">登录</a>
                <a href = "about:blank" class = "afli">注册</a>
            <!-- after login 登录之后就消失-->
                <a href = "about:blank">帮助</a>
                <a href = "about:blank">客服</a>
            </p>
            <form class = "sea" method = "get" accept-charset = "utf-8">
                <div id = "inpt">
                    <input type="text" name="sea" id="sea"  autofocus = "autofocus"/>
                </div>
                <input type="submit" name="sub" id="sub" value = "搜索" />
            </form>
        </div>
        <p class = "htl"></p>
    </div>
</body>
</html>

