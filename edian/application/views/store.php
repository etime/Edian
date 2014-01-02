<?php
    $baseUrl = base_url();
?>
<!DOCTYPE html>
<html lang = "zh">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>何时专辑店</title>
    <link rel="stylesheet" href="<?php echo $baseUrl.'/css/store.css' ?>" type="text/css" media="all" />
</head>
<body>
    <div id="header">
        <div class="dtop width">
            <h1>eDian</h1>
            <input type="text" name="sea" id="sea" placeholder = "搜索" />
        </div>
    </div>
    <div id = "nav">
        <div class="cnav width clearfix">
            <h4>商品类别</h4>
            <ul id = "list" class = 'list' style = "display:none">
                <li>蛋糕</li>
                <li>曲奇</li>
                <li>甜甜饼</li>
                <li>甜甜饼</li>
                <li>甜甜饼</li>
                <li>甜甜饼</li>
                <li>甜甜饼</li>
            </ul>
            <h4>首页</h4>
            <h4>二手</h4>
            <h4>活动</h4>
            <div class = 'search'>
                <div>
                    <input type="text" name="sea" id="sea"  placeholder = "搜索" autofocus = 'on'/>
                </div>
                <input type="submit" name="but"  value="店内搜" />
            </div>
        </div>
    </div>
    <div id = 'body' class = "width clearfix">
        <div class = "store">
            <h5>店铺信息</h5>
        </div>
        <div class = "item">
        </div>
    </div>
</body>
</html>
