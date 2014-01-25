<?php
    $baseUrl = base_url();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>游戏开发</title>
    </head>
    <body>
        <h1>豆家杰SB</h1>
        <canvas id = "canvas">
            your browser didn't support canvas;
        </canvas>
        <p>
            <input type="button" name="bton" id="bton" value="投掷" />
        </p>
    </body>
    <script type="text/javascript" charset="utf-8" src = "<?php  echo $baseUrl . 'js/game.js'?>"></script>
<style type="text/css" media="all">
    #canvas{
        width:400px;
        height:200px;
        background:#ddd;
    }
</style>
</html>
