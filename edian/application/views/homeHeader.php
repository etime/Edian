
<body>
<?php
    $this->load->view("head");
?>
    <div class="tab">
        <ul class="clearfix">
            <li>导航分类</li>
            <a href = "<?php echo site_url() ?>"><li>首页</li></a>
            <a href = "<?php echo site_url('shop/queue') ?>"><li>店铺</li></a>
            <li>活动</li>
        </ul>
    </div>
<style type="text/css" media="all">
body{
margin:0;
}
.tab ul{
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
.tab ,  .tab a{
    background:#990002;
    color:white;
}
</style>
</html>
