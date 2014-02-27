
<body>
    <?php
        $this->load->view("head");
    ?>
    <div id = "tab">
        <ul class="clearfix tab">
            <li id = "tonav">导航分类</li>
            <a href = "<?php echo site_url() ?>"><li>首页</li></a>
            <a href = "<?php echo site_url('shop/queue') ?>"><li>店铺</li></a>
            <li>活动</li>
        </ul>
        <ul  class = "nav" id = "nav"  style = "display:none">
            <ul class = "one clearfix">
                <h4>零食饮料</h4>
                <li>
                    <ul class = "two clearfix">
                        <li class = "bold">素材</li>
                        <li> dfa </li>
                        <li> dfa </li>
                        <li> dfa </li>
                    </ul>
                </li>
                <li>
                    <ul class = "two clearfix">
                        <li class = "bold">素材</li>
                        <li> dfa </li>
                        <li> dfa </li>
                        <li> dfa </li>
                    </ul>
                </li>
                <li>
                    <ul class = "two clearfix">
                        <li class = "bold">素材</li>
                        <li> dfa </li>
                        <li> dfa </li>
                        <li> dfa </li>
                    </ul>
                </li>
            </ul>
            <ul class = "one clearfix">
                <h4>零食饮料</h4>
                <li>
                    <ul class = "two clearfix">
                        <li class = "bold">素材</li>
                        <li> dfa </li>
                        <li> dfa </li>
                        <li> dfa </li>
                    </ul>
                </li>
                <li>
                    <ul class = "two clearfix">
                        <li class = "bold">素材</li>
                        <li> dfa </li>
                        <li> dfa </li>
                        <li> dfa </li>
                    </ul>
                </li>
            </ul>
        </ul>
    </div>

<style type="text/css" media="all">
body{
    margin:0;
}
.tab{
    margin-left:200px;
    width:50%;
}
.tab li{
    float:left;
    width:20%;
    text-align:center;
    padding:4px 0;
    height:100%;
    font-size:1.2em;
}

.tab li:hover{
    background:rgb(125,3,3);
}
#tab ,  #tab a{
    background:#990002;
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
</html>
