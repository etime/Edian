<!-- 这里是作为网页的一部分出现的，是网站的头部,css和html在一起-->
<div id = "header" class="clearfix" >
    <div>
        <div class = "logo">
            <h1>e<span>點</span></h1>
        </div>
        <p style="float:right">
            <!-- replace 中的是登录之后替换的东西-->
            <span class = "replace">
                <a href = "#" id = "gotoLogin">登录</a>  |
                <a href = "<?php echo site_url('/register/userRegister/') ?>">注册</a>
            </span> |
            <a>帮助</a>
        </p>
        <form action="<?php echo site_url('/search/searchAction') ?>" method="get" accept-charset="utf-8" class = "search">
            <div>
                <input type="text" name="key" id="sea" placeholder = "搜索" />
            </div>
            <input type="submit" name="sub" value="搜索" />
        </form>
    </div>
</div>
<div id = "login" class = "login" style = "display:none">
    <form action="<?php echo site_url('login/loginCheck') ?>" method="post" accept-charset="utf-8">
        <span class = "close">关闭</span>
        <p>
            <input type="text" name="userName" placeholder = "用户名/手机号" />
        </p>
        <p>
            <input type="password" name="password" placeholder = "密码" />
        </p>
        <p class = "atten"></p>
        <input type="submit" name="sub"  value="登录" />
    </form>
</div>
<script type="text/javascript" charset="utf-8">
    var userId = "<?php echo $this->session->userdata("userId") ?>";
    var site_url =  "<?php  echo site_url()?>";
</script>
<!-- 以后这里做能内部嵌入js代码的 -->
<script type="text/javascript" charset="utf-8" src = "<?php echo  base_url('js/login.js')?>"></script>
<style type="text/css" media="all">
.login{
    position:fixed;
    top:100px;
    width:100%;
    z-index:10;
}
.login form{
    width:250px;
    background:rgb(241, 241, 241);
    margin:0px auto;
    text-align:center;
    border-radius:5px;
    padding:5px;
    position:relative;
}
.login p{
    margin:5px ;
}
.login input[type = 'submit']{
    background:#046F00;
    border:none;
    border-radius:5px;
    padding:7px 10px;
    color:#F5DFB5;
    box-shadow:3px 1px 2px #BBB7B7;
    width:120px;
}
.login input[type = 'text'] , .login input[type = 'password']{
    padding:7px;
    border:1px solid rgb(221, 221, 221);
    box-shadow:2px 2px 3px rgb(196, 196, 196) inset;
    border-radius:5px;
    width:90%;
}
.login input[type = 'text']:focus , .login input[type = 'password']:focus{
    border:1px solid gray;
    box-shadow:1px 1px 4px rgb(150, 150, 150) inset;
}
.login .close{
    position:absolute;
    top:0;
    right:0;
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
    width:500px;
    position:absolute;
    right:100px;
    bottom:20px;
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
    position:relative;
}
a{
    color:inherit;
}
</style>
