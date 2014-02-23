<?php
    $siteUrl = site_url();
    $baseUrl = base_url();

?>
<!Doctype  html>
<html lang = "en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <link rel="stylesheet" href="<?php echo $baseUrl .'css/bgset.css'?>" type="text/css" media="all" />
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
            echo $storeId;
            $check = '<form action=\'' . $siteUrl . '/bg/set/setAct\'  method=\'post\' id = \'switch\' accept-charset=\'utf-8\' enctype = \'multipart/form-data\'>';
            $check .= '<select name = \'storeId\'>';
            for ($i = 0,$len = count($store) ; $i < $len ;$i++){
                if($storeId == $store[$i]['id']){
                    $check .= '<option value = ' . $store[$i]["id"] . ' selected = selected>' . $store[$i]['name'] . '</option>';
                } else{
                    $check .= '<option value = ' . $store[$i]["id"] . '>' . $store[$i]['name'] . '</option>';
                }
            }
            $check .= '</select>';
            $check .= '<input type=submit name=sub  value=切换店铺 /></form>';
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
            <span class = "item">店铺logo:</span>
<!--
            <input type="file" name="logo" id="logo"/>
            <span class="button" id = "butLogo">上传图片</span>
-->
            <input type="hidden" name="logo" />
            <img  id = "afterUpload" src = "<?php echo @$logo ?>" />
            <input type="button" name="butLogo" id="butLogo" value="上传图片" />
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
            <span class = "item">最低起送价:</span>
            <input type="text" name="lestPrc" id="lestPrc"/>
        </li>
        <li>
            <span class="item">店铺简介</span>
            <textarea name="briefInfo" maxlength = "40" placeholder = "40字以内"><?php echo $briefInfo ?></textarea>
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
        <li class = "clearfix">
            <span class="item" style = "float:left">商品类别:</span>
            <div class = "cate">
                <table border="1">

                    <tr style = "background:#e9e9e9">
                        <th>类别名</th>
                        <th>商品数</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach($category as $val):?>
                    <tr>
                        <td><?php echo $val['name'] ?></td>
                        <td> <?php echo $val['count'] ?></td>
                        <td><a>修改</a> <a>删除</a></td>
                    </tr>
                    <?php endforeach?>
                </table>
                <p>
                    <input type="text" name="listName" maxlength = "4"/>
                    <span class="button" id = "listBut">添加类别</span>
                </p>
            </div>
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
