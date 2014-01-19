<?php
/**
 * @name        ../views/search.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-01-18 16:09:47
 */
 $baseUrl = base_url();
 $siteUrl = site_url();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>搜索页面</title>
    <link rel="stylesheet" href="<?php echo $baseUrl .'css/search.css' ?>" type="text/css" media="all" />
</head>
<body>
    <div class = "header">
    <?php
        $this->load->view("homeHeader");
    ?>
    </div>
    <div id="context" class = "width context">
        <div class = "snav clearfix">
            <?php echo $pageNumFooter ?>
            <div>
            <a href = "<?php echo $siteUrl . '/search/searchAction?key=' . $key ?>">综合</a>
            <?php
             $snav = array(
                2 => array('font' => '价格' , 'initState' => 2),
                3 => array('font' => '销量' , 'initState' => 1),
                4 => array('font' => '销量' , 'initState' => 1),
                6 => array('font' => '送货速度' , 'initState' => 2)
             );
             foreach($snav as $idx => $val){
                 if($idx == $type){
                    echo "<a href = '" . $siteUrl . "/search/searchAction/$idx/" . (3 - $val['initState']) .'?key=' . $key . "'>" . $val['font']. "</a>";
                 }else {
                    echo "<a href = '" . $siteUrl . "/search/searchAction/$idx/" . $val['initState'] .'?key=' . $key . "'>" . $val['font']. "</a>";
                 }
             }
            ?>
            </div>
        </div>
        <ul class = "good">
            <li class = "details">
                <div class = "img">
                    <img src="http://gi2.md.alicdn.com/bao/uploaded/i2/14183030232589888/T1rdMZFiRaXXXXXXXX_!!0-item_pic.jpg_360x360q90.jpg" alt="图片" class = "mainImg"/>
                </div>
                <div class = "deinfo">
                    <p>斯蒂芬阿斯顿发商店阿斯顿还是地方</p>
                    <p class = "sep">
                        <span>评分3.2</span>
                        <strong>￥90.00</strong>
                    </p>
                    <p class = "sep">
                        <span>已售32</span>
                        <span>奥蒂旗舰店</span>
                    </p>
                </div>
            </li>
            <li class = "details">
                <div class = "img">
                    <img src="http://www.pkusky.com/upfile/images/MEI%20NV.jpg" alt="图片" class = "mainImg"/>
                </div>
                <div class = "deinfo">
                    <p>斯蒂芬阿斯顿发商店阿斯顿还是地方</p>
                    <p class = "sep">
                        <span>评分3.2</span>
                        <strong>￥90.00</strong>
                    </p>
                    <p class = "sep">
                        <span>已售32</span>
                        <span>奥蒂旗舰店</span>
                    </p>
                </div>
            </li>
            <li class = "details">
                <div class = "img">
                    <img src="http://gi2.md.alicdn.com/bao/uploaded/i2/T1.412Fh0hXXXXXXXX_!!0-item_pic.jpg_360x360q90.jpg" alt="图片" class = "mainImg"/>
                </div>
                <div class = "deinfo">
                    <p>斯蒂芬阿斯顿发商店阿斯顿还是地方</p>
                    <p class = "sep">
                        <span>评分3.2</span>
                        <strong>￥90.00</strong>
                    </p>
                    <p class = "sep">
                        <span>已售32</span>
                        <span>奥蒂旗舰店</span>
                    </p>
                </div>
            </li>
            <li class = "details">
                <div class = "img">
                    <img src="http://gi3.md.alicdn.com/bao/uploaded/i3/17136026493258869/T1TRX.FjXfXXXXXXXX_!!0-item_pic.jpg_360x360q90.jpg" alt="图片" class = "mainImg"/>
                </div>
                <div class = "deinfo">
                    <p>斯蒂芬阿斯顿发商店阿斯顿还是地方</p>
                    <p class = "sep">
                        <span>评分3.2</span>
                        <strong>￥90.00</strong>
                    </p>
                    <p class = "sep">
                        <span>已售32</span>
                        <span>奥蒂旗舰店</span>
                    </p>
                </div>
            </li>
            <?php  foreach ($item as $val):?>
            <li class = "details">
                <div class = "img">
                        <a href = "<?php echo $siteUrl . '/item/index/' . $val['id']?>">
                            <img src="<?php echo $val['mainThumbnail'] ?>" alt="图片" class = "mainImg"/>
                        </a>
                </div>
                <div class = "deinfo">
                    <p>
                        <a href = "<?php echo $siteUrl . '/item/index/' . $val['id']?>">
                            <?php echo $val['title'] ?>
                        </a>
                    </p>
                    <p class = "sep">
                    <span>评分<?php echo $val['satisfyScore'] ?></span>
                    <strong>￥<?php echo $val['price']?></strong>
                    </p>
                    <p class = "sep">
                    <span>已售<?php echo $val['sellNum'] ?></span>
                        <span>奥蒂旗舰店</span>
                    </p>
                </div>
            </li>
            <?php endforeach ?>
        </ul>
    </div>
</body>
</html>
