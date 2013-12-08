<?php
    $siteUrl = site_url();
    $baseUrl = base_url();
?>
<!Doctype  html>
<html lang = "en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title>商城设置</title>
<script type="text/javascript" charset="utf-8">
    var base_url = "<?php echo $baseUrl ?>";
    var site_url = "<?php echo $siteUrl ?>";
</script>
</head>
<body>
    <form action="<?php echo $siteUrl.'/bg/set/setAct' ?>" method="post" accept-charset="utf-8" enctype = "multipart/form-data">
    <ul>
        <li>
            <span class = "item">商店名字:</span>
            <span><input type = "text" name = "storeName"></span>
        </li>
        <li>
            <span>店铺logo：</span>
            <input type="file" name="logo" id="logo"/>
        </li>
        <li>
            <span class = "item">营业时间:</span>
            <span id="addTime" class = "button">添加时间段</span>
            <input type="hidden" name="businessTime" id="time" />
            <div id = "dtime">
                从
                <select name="time">
                    <?php
                        for($i = 0;$i < 24 ; $i++){
                            if($i == 9)
                                echo "<option value = " . $i . " selected>" . $i . "</option>";
                            else
                                echo "<option value = " . $i . ">" . $i . "</option>";
                        }
                    ?>
                </select>
                时
                <select name="time">
                    <?php for($i = 0;$i < 60 ; $i++) echo "<option value = " . $i . ">" . $i . "</option>"; ?>
                </select>
                分到
                 <select name="time">
                    <?php
                        for($i = 0;$i < 24 ; $i++){
                            if($i == 19)
                                echo "<option value = " . $i . " selected>" . $i . "</option>";
                            else
                                echo "<option value = " . $i . ">" . $i . "</option>";
                        }
                    ?>
                </select>
                时
                <select name="time">
                    <?php for($i = 0;$i < 60 ; $i++) echo "<option value = " . $i . ">" . $i . "</option>"; ?>
                </select>
                分
            </div>
        </li>
        <li>
            <span class = "item">客服电话:</span>
            <input type="text" name="servicePhone" />
        </li>
        <li>
            <span class="item">客服QQ:</span>
            <input type="text" name="serviceQQ"/>
        </li>
        <li>
            <span class="item">商品类别:</span>
            <ul class = "list clearfix" id = "list" title = "click to delete">
                <li>炒菜</li>
                <li>凉菜</li>
                <li>啤酒</li>
            </ul>
            <p>
                <input type="text" name="listName" />
                <span class="button" id = "listBut">添加</span>
            </p>
        </li>
        <li>
            <span class="item">dtu名字:</span>
            <input type="text" name="dtuName" />
        </li>
        <li>
            <!--dtuid 和dtupassword都不是店家能设置的，而是他们选择的-->
            <span class="item">dtu密码</span>
            <input type="hidden" name="dtuPassword" />
        </li>
        <li>
            <span class="item">dtuId:</span>
            <input type="hidden" name="dtuId" />
        </li>
        <li>
            <span class="item">简介图片:</span>
        </li>
        <li>
            <span class="item">地址:</span>
            <input type="text" name="address" />
        </li>
        <li>
            <p>店铺位置和送货范围:</p>
            <div id="allmap"></div>
        </li>
    </ul>
    <input type="submit" name="sub" id="sub" value="提交" />
    </form>
</body>
<style type="text/css" media="all">
    .item{
        width:100px;
        display:inline-block;
    }
    li{
        list-style:none;
    }
    #baiduMap{
        width:900px;
        height:400px;
    }
    .button{
        background:#ececec;
        border-radius:2px;
        border:1px solid rgb(148, 148, 153);
        padding:2px 4px;
        font-size:0.8em;
    }
    .button:hover{
        background:#888888;
    }
    .list li{
        float:left;
        margin:0 5px;
    }
    .list{
        clear:both;
    }
    .clearfix:after {
        DISPLAY: block;
        HEIGHT: 0px;
        VISIBILITY: hidden;
        CLEAR: both;
        overflow:hidden;
        content:"";
    }
</style>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/jquery.js' ?>"></script>
<!--
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=672fb383152ac1625e0b49690797918d"></script>
-->
<!--
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=672fb383152ac1625e0b49690797918d"></script>
-->
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/debug.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/bgSet.js' ?>"></script>
</html>
