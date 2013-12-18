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
    var baseUrl = "<?php echo $baseUrl ?>";
    var site_url = "<?php echo $siteUrl ?>";
    var busTime = " <?php echo @$deliveryTime ?>";//对busTime的处理在fBusTime中进行
</script>
</head>
<body>
    <?php
        //type为2是管理员，为1添加是店家，为0，代表添加新增店铺
        if($type == 2){
            $check = '<form action=\'' . $siteUrl . '/bg/set/setAct\'  method=\'post\' id = \'switch\' accept-charset=\'utf-8\' enctype = \'multipart/form-data\'>';
            $check .= '<select name = \'storeId\'>';
            for ($i = 0,$len = count($store) ; $i < $len ;$i++){
                $check .= '<option value = ' .$store[$i]["id"] . '>' . $store[$i]['name'] . '</option>';
            }
            $check .= '</select>';
            $check .= '<input type=submit name=sub  value=switch /></form>';
            echo $check;
        }
    ?>
    <form action="<?php echo $siteUrl.'/bg/set/setAct' ?>" method="post" id = "change" accept-charset="utf-8" enctype = "multipart/form-data">
    <ul>
        <li>
            <span class = "item">商店名字:</span>
            <span><input type = "text" name = "storeName" maxlength = "10" value = " <?php echo $name ?>"></span>
        </li>
        <li>
            <span>店铺logo：</span>
            <input type="file" name="logo" id="logo"/>
        </li>
        <li>
            <span class = "item">客服电话:</span>
            <input type="text" name="servicePhone" maxlength = "11" value = " <?php echo $servicePhone ?>"/>
        </li>
        <li>
            <span class="item">客服QQ:</span>
            <input type="text" name="serviceQQ" maxlength = "11" value = " <?php echo $serviceQQ ?>"/>
        </li>
        <li>
            最低起送价：
            <input type="text" name="lestPrc" id="lestPrc"/>
        </li>
        <li>
            <span class = "item">营业时间:</span>
            <span id="addTime" class = "button">添加时间段</span>
            <input type="hidden" name="businessTime" id="time" />
            <div id = "tarea">
<!--
                <p class = "dtime">
                    从
                    <select name="time">
                        <?php
                            for($i = 0;$i < 24 ; $i++){
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
                                echo "<option value = " . $i . ">" . $i . "</option>";
                            }
                        ?>
                    </select>
                    时
                    <select name="time">
                        <?php for($i = 0;$i < 60 ; $i++) echo "<option value = " . $i . ">" . $i . "</option>"; ?>
                    </select>
                    分
                </p>
-->
            </div>
        </li>
        <li>
            <span class="item">商品类别:</span>
            <ul class = "list clearfix" id = "list" title = "点击删除">
                <?php foreach($category as $val):?>
                <li> <?php echo $val?></li>
                <?php endforeach?>
            </ul>
            <p>
                <input type="text" name="listName" />
                <span class="button" id = "listBut">添加类别</span>
            </p>
        </li>
        <li>
            <span class="item">dtu名字:</span>
            <input type="text" name="dtuName"  maxlength = "15" value = "<?php echo @$more['dtuName'] ?>"/>
        </li>
<?php
if($type == 2){
    $pass = @$more['dtuPassword'];
    $id   = @$more['dtuId'];
echo <<<eod
    <li>
        <span class=item>dtu密码</span>
        <input type=text name=dtuPassword value = ' $pass '/>
        </li>
    <li>
        <span class="item">dtuId:</span>
        <input type="text" name="dtuId"  value=' $id '/>
    </li>
eod;
    }
?>
<!--
        <li>
            <span class="item">简介图片:</span>
        </li>
        <li>
            <span class="item">地址:</span>
            <input type="text" name="address" maxlength = "250"/>
        </li>
-->
        <li>
        <p>店铺位置和送货范围 <input type="text" name="distance" id="distance" value=" <?php echo $deliveryArea ? $deliveryArea :1500 ?>" />米 <input type="button" name="but" id="but" value="确定" />:</p>
            <input type="hidden" name="latitude" value = " <?php echo $latitude ?>"/>
            <input type="hidden" name="longitude" value = "<?php echo $longitude?>"/>
            <div id="allmap"></div>
        </li>
    </ul>
    <input type="submit" name="sub" id="sub" value="提交" />
    </form>
</body>
<style type="text/css" media="all">
    #distance{
        width:50px;
    }
    .item{
        width:100px;
        display:inline-block;
    }
    li{
        list-style:none;
        line-height:1.5em;
        border-bottom:1px solid rgb(0, 181, 226);
    }
    #allmap{
        width:900px;
        height:400px;
    }
    /*
 *   body, html,#allmap {width: 500px;height: 500px;overflow: hidden;margin:0;}
 */
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
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=672fb383152ac1625e0b49690797918d"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/debug.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl.'js/bgSet.js' ?>"></script>
<!--
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=f0uIeSS1Zgh8O3CBdVUM5xRN"></script>
-->
</html>
