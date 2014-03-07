<div>
    <?php
        $this->load->view("head");
    ?>
    <div id = "htab">
        <ul class="clearfix htab">
            <li id = "tonav">导航分类</li>
            <a href = "<?php echo site_url() ?>"><li>首页</li></a>
            <a href = "<?php echo site_url('shop/queue') ?>"><li>店铺</li></a>
            <li>活动</li>
        </ul>
        <ul  class = "nav" id = "nav"  style = "display:none">
        <?php
            $siteUrl = site_url();
        ?>
        <?php  foreach($dir as $idx1 => $key1):?>
            <ul class = "one clearfix">
                <h4> <a href = "<?php  echo $siteUrl . '/item/select/1?key=' . $idx1 ?>"><?php echo $idx1 ?></a></h4>
                <?php foreach($key1 as $idx2 => $key2): ?>
                <li>
                    <ul class = "two clearfix">
                        <li class = "bold"><a href = "<?php  echo $siteUrl . '/item/select/2?key=' . $idx2?>"><?php echo $idx2?></a></li>
                        <?php foreach($key2 as $key3):?>
                        <li>
                            <a href = "<?php echo $siteUrl .'/item/select/3?key=' . $key3 ?>">
                                <?php echo $key3 ?>
                            </a>
                        </li>
                        <?php  endforeach?>
                    </ul>
                </li>
                <?php endforeach ?>
            </ul>
        <?php endforeach ?>
        </ul>
    </div>
</div>
<style type="text/css" media="all">
body{
    margin:0;
}
.htab{
    margin-left:200px;
    width:50%;
}
.htab li{
    float:left;
    width:20%;
    text-align:center;
    padding:4px 0;
    height:100%;
    font-size:1.2em;
}

.htab li:hover{
    background:rgb(125,3,3);
}
#htab ,  #htab> a{
    background:#990000 url("<?php  echo base_url('bgimage/topbar.jpg') ?>") repeat-x;
    color:white;
}
.nav{
    position:absolute;
    background:white;
    left:200px;
    z-index:1;
    box-shadow:0px 0px 20px #000;
    width:440px;
    padding:8px;
    border-radius:2px;
    border:1px solid #FF6600;
}
.nav li{
    float:left;
}
.two > * {
    padding:5px 10px;
}
.two{
    font-size:12px;
    color:#666666;
}
.two .bold{
    color:black;
    font-size:1.2em;
}
.one > h4{
    color:white;
    padding:5px;
    margin:0 0 5px;
    background:url("<?php  echo base_url('bgimage/navBar.png') ?>") no-repeat;
}
.one > li{
    float:left;
}
.bold{
    font-weight:bold;
    margin-left:25px;
}
</style>
