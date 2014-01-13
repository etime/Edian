<!-- 这里是作为网页的一部分出现的，是网站的头部,css和html在一起-->
<div id = "header" class="clearfix" >
    <div>
        <div class = "logo">
            <h1>e<span>點</span></h1>
        </div>
        <p style="float:right">
            <a>登录</a>  |
            <a>注册</a>  |
            <a>帮助</a>
        </p>
        <div class = "search">
            <div>
                <input type="text" name="key" id="sea" placeholder = "搜索" />
            </div>
            <input type="submit" name="sub" value="搜索" />
        </div>
    </div>
</div>
<style type="text/css" media="all">
#header{
    background:#cc0001;
}
#header > div{
    margin:0 auto;
    width:1200px;
    width:1200px;
}
#header .logo{
    height:120px;
    overflow:hidden;
    width:200px;
    text-align:center;
    float:left;
}
#header .logo h1{
    font-size:2.5em;
}
#header .logo h1 span{
    background-color:white;
    color:#cc0001;
    padding:2px;
}
#header .search{
    float:left;
    margin:15px 0 0 387px;
    width:500px;
}
#header .search div{
    height:27px;
    float:left;
    width:425px;
}
#header input[name = 'key']{
    box-shadow:1px 1px 4px rgb(182, 182, 182) inset;
    width:100%;
    padding:2px 6px;
    height:100%;
    border-radius:4px 0px 0px 4px;
    border-right:0;
    outline:none;
}
#header input[name = 'key']:focus{
    box-shadow:1px 1px 6px rgb(150,150,150) inset;
}
#header input[name = 'sub']{
    height:35px;
    margin-left:-6px;
    border:none;
    border-radius:0 3px 3px 0;
    width:80px;
    outline:none;
}
#header input[name = 'sub']:active{
    background:rgb(120,120,120);
}
#header{
    background-color:#cc0001;
    overflow:hidden;
}
</style>
