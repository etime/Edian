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
    <link rel="stylesheet" href="<?php echo $baseUrl .'css/shoplist.css' ?>" type="text/css" media="all" />
</head>
<body>
    <div class = "header">
    <?php
        $this->load->view("homeHeader");
 $key = 'sear';
 $type = 1;
    ?>
    </div>
    <div id="context" class = "width context">
        <div class = "snav clearfix">
            <?php echo $pageNumFooter ?>
            <div>

            <a href = "<?php echo $siteUrl . '/search/searchAction?key=' . $key ?>">综合</a>
            <?php
             $snav = array(
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
        <?php
            if(!$shopList)$shopList = array();
             //var_dump($shopList);
        ?>
        <?php foreach($shopList as $store):?>
            <li class = "details">
                <div class = "img">
                <img src="<?php echo $store['logo'] ?>" alt="图片" class = "mainImg"/>
                </div>
                <div class = "deinfo">
                    <a href = "<?php echo $siteUrl . '/shop/index/' .$store['id'] ?>">
                        <h4><?php echo $store['name'] ?></h4>
                    </a>
                    <p>
                        <span class="left">
                            <span class = "item">店铺评分:</span>
                            <span class="cont"><?php echo $store['credit'] ?></span>
                        </span>
                        <span class="right">
                            <span class = "item">最低起送价:</span>
                            <span class="cont"><?php echo $store['sendPrice'] ?>元</span>
                        </span>
                    </p>
                    <p>
                        <span class="left">
                            <span class = "item">销量:</span>
                            <span class="cont">300</span>
                        </span>
                        <span class="right">
                            <span class = "item">送货速度:</span>
                            <span class="cont"><?php echo $store['duration'] ?>分钟</span>
                        </span>
                    </p>
                    <blockquote>
                        把那拉拉吧是的发斯蒂芬阿斯顿发斯蒂芬啊但是和阿斯顿发商店
                    </blockquote>
                </div>
            </li>
            <?php endforeach ?>
            <li class = "details">
                <div class = "img">
                    <img src="http://www.jsshengda.net/upload/Y1IMOQd2bV4jaWs5WDIaQVs6aFJSUggFBRgPQVQ!W08JRlY.jpg" alt="图片" class = "mainImg"/>
                </div>
                <div class = "deinfo">
                    <h4>江湖烤鱼</h4>
                    <p>
                        <span class="left">
                            <span class = "item">店铺评分:</span>
                            <span class="cont">4.7</span>
                        </span>
                        <span class="right">
                            <span class = "item">最低起送价:</span>
                            <span class="cont">19元</span>
                        </span>
                    </p>
                    <p>
                        <span class="left">
                            <span class = "item">销量:</span>
                            <span class="cont">500</span>
                        </span>
                        <span class="right">
                            <span class = "item">平均送货速度:</span>
                            <span class="cont">41分钟</span>
                        </span>
                    </p>
                    <blockquote>
                        把那拉拉吧是的发斯蒂芬阿斯顿发斯蒂芬啊但是和阿斯顿发商店
                    </blockquote>
                </div>
            </li>
            <li class = "details">
                <div class = "img">
                    <img src="http://gi2.md.alicdn.com/bao/uploaded/i2/14183030232589888/T1rdMZFiRaXXXXXXXX_!!0-item_pic.jpg_360x360q90.jpg" alt="图片" class = "mainImg"/>
                </div>
                <div class = "deinfo">
                    <h4>千娇白媚</h4>
                    <p>
                        <span class="left">
                            <span class = "item">店铺评分</span>
                            <span class="cont">4.7</span>
                        </span>
                        <span class="right">
                            <span class = "item">最低起送价</span>
                            <span class="cont">19元</span>
                        </span>
                    </p>
                    <p>
                        <span class="left">
                            <span class = "item">距离</span>
                            <span class="cont">500米</span>
                        </span>
                        <span class="right">
                            <span class = "item">送货速度</span>
                            <span class="cont">41分钟</span>
                        </span>
                    </p>
                    <blockquote>
                        把那拉拉吧是的发斯蒂芬阿斯顿发斯蒂芬啊但是和阿斯顿发商店
                    </blockquote>
                </div>
            </li>
        </ul>
    </div>
</body>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/jquery.min.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/login.js' ?>"></script>
<script type="text/javascript" charset="utf-8" src = "<?php echo $baseUrl . 'js/shoplist.js' ?>"></script>
</html>
