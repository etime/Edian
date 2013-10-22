<?php
/*************************************************************************
    > File Name :     ../views/fun.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-09-19 16:12:44
 ************************************************************************/
//玩乐的文件
$baseUrl = base_url();
$siteUrl = site_url();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>中秋快乐</title>
<style type="text/css" media="all">
body{
background:#000;
margin:0px;
height:100%;
/*
    background:#000 url("../upload/fun.jpg") no-repeat;
*/
}
/*
img{
    width:10px;
    height:10px;
    border-radius:6px;
    background:#fff;
}
*/
.bgimg{
    width:100%;
    min-width:600px;
}
.snow{
    border-radius:10px;
    background:#fff;
    position:absolute;
}
#tit{
    position:absolute;
    color:#FDFFD5;
    left:50px;
}
.cover{
    width:100%;
    height:100%;
    background:#000;
    position:absolute;
    top:0px;
    left:0px;
    color:#fff;
    z-index:10;
}
.cover h1{
    text-align:center;
}
</style>
    </head>
    <body>
        <h1 id = "tit">中秋快乐</h1>
        <img  class = 'snow'/>
        <img class = 'bgimg' src = "<?php echo $baseUrl.'upload/fun.jpg' ?>"  style = "z-index:-1;"/>
        <div class = "cover">
            <h1>你期待发生什么？？</h1>
            <h1 id = "atten">9</h1>
        </div>
    </body>
<script type="text/javascript" charset="utf-8" src = " <?php echo $baseUrl.('js/jquery.min.js') ?>"></script>
<script type="text/javascript" charset="utf-8" src = " <?php echo $baseUrl.('js/fun.js') ?>"></script>
</html>
