
<body>
<?php
    $this->load->view("head");
?>
    <div class="tab">
        <ul class="clearfix">
            <li>导航分类</li>
            <li>首页</li>
            <li>商城</li>
            <li>店面</li>
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
.tab{
    background:#990002;
    color:white;
}
</style>
</html>
