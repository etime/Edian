<!-- 这里是作为网页的一部分出现的，是网站的头部,css和html在一起-->
<div id = "header" class="clearfix" >
    <div>
        <div class = "logo">
            <h1>e<span>點</span></h1>
        </div>
        <p style="float:right">
            <!-- replace 中的是登录之后替换的东西-->
            <span class = "replace">
                <a href = "#" id = "gotoLogin" class = "gotoLogin">登录</a>  |
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
<div id = "login" class = "login"  style = "display:none">
    <div class = "wrap">
        <span class = "shut"> </span>
        <div class = "regd" id = "regd">
            <span class = "focus" name = 'l'>登录</span>
            <span name = "r">注册</span>
        </div>
        <form action="<?php echo site_url('login/loginCheck') ?>" method="post" accept-charset="utf-8" class = "l">
            <p>
                <input type="text" name="userName" id = "userName" placeholder = "用户名/手机号" />
                <label for="userName"></label>
            </p>
            <p>
                <input type="password" name="password" id = "password" placeholder = "密码" />
                <label for="password"></label>
            </p>
            <p style = "text-align:center">
                <input type="submit" name="sub"  value="登录"  class = "btn"/>
            <!--
                <span class = "reg">没有帐号?
                    <a href = "<?php echo site_url('register/userRegister') ?>"  style = "color:#31b2ee">马上注册</a>
                </span>
            -->
            </p>
        </form>
        <form action="" method="post" accept-charset="utf-8" class = "r" style = "display:none" >
            <p>
                <input type="text" name="loginName" id = "userName" placeholder = "用户名/手机号" />
                <span class = "atten"></span>
                <label for="userName"></label>
            </p>
            <p>
                <input type="password" name="password" placeholder = "密码" />
                <span class = "atten success"></span>
                <label for="password"></label>
            </p>
            <p>
                <input type="password" name="confirm" placeholder = "密码" />
                <span class = "atten"></span>
                <label for="password"></label>
            </p>
            <p>
                <input type="text" name="phoneNum" placeholder = "手机号" />
                <span class = "atten"></span>
                <label for="phoneNum"></label>
            </p>
            <p>
                <input type="text" name="checkNum" />
                <input type="button"  id="smschk" value="发送验证码"  class = "btn"/>
            </p>
            <p>
                <input type="submit" name="sub"  value="注册" />
                <span class = "reg">
                    <a href = "<?php echo site_url('/register/bossRegister') ?>">
                        店家入口
                    </a>
                </span>
            </p>
        </form>
    </div>
</div>
<script type="text/javascript" charset="utf-8">
    var userId = "<?php echo $this->session->userdata("userId") ?>";
    var site_url =  "<?php  echo site_url()?>";
</script>
<!-- 以后这里做能内部嵌入js代码的 -->
<script type="text/javascript" charset="utf-8" src = "<?php echo  base_url('js/login.js')?>"></script>
<style type="text/css" media="all">
.login{
    width:100%;
    height:100%;
    z-index:10;
    background:rgba(0,0,0,0.3);
    position:fixed;
    top:0;
}
#login input[name = 'checkNum']{
    width:80px;
}
.regd{
    font-size:1.5em;
    border-bottom:2px solid #e3e3e3;
    margin-bottom:26px;
}
.regd span{
    width:120px;
    text-align:center;
    display:inline-block;
    line-height:34px;
}
.regd .focus{
    background:#31b2ee;
    color:white
}
.btn{
    -webkit-box-shadow:inset 0px 1px 0px rgba(255, 255, 255, 0.5), 0px 1px 2px rgba(0, 0, 0, 0.2);
    -moz-box-shadow:inset 0px 1px 0px rgba(255, 255, 255, 0.5), 0px 1px 2px rgba(0, 0, 0, 0.2);
    box-shadow:inset 0px 1px 0px rgba(255, 255, 255, 0.5), 0px 1px 2px rgba(0, 0, 0, 0.2);
    background:-webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #fbfbfb), color-stop(100%, #e1e1e1));
    background:-webkit-linear-gradient(top, #fbfbfb, #e1e1e1);
    background:-moz-linear-gradient(top, #fbfbfb, #e1e1e1);
    line-height:24px;
    border:none;
    border-radius:2px;
}
.wrap{
    width:282px;
    top:100px;
    position:fixed;
    background:white;
    margin:0px auto;
    border-radius:5px;
    padding:30px 47px;
    position:relative;
    box-shadow:0 0 24px rgb(0, 0, 0);
}
.login p{
    position:relative;
    height:40px;
}
.login input[type = 'submit']{
    border:none;
    border-radius:2px;
    padding:7px 10px;
    color:#F5DFB5;
    box-shadow:3px 1px 2px #BBB7B7;
    width:110px;
}
label[for = 'userName']{
    background:url( "<?php echo base_url('bgimage/login.png') ?>") -2px -5px no-repeat;
    position:absolute;
    top:9px;
    right:6px;
    width:18px;
    height:19px;
    content:' ';
}
label[for = 'password']{
    background:url( "<?php echo base_url('bgimage/login.png') ?>") -20px -6px no-repeat;
    position:absolute;
    top:9px;
    right:6px;
    width:17px;
    height:19px;
    content:' ';
}
label[for = 'phoneNum']{
    background:url( "<?php echo base_url('bgimage/login.png') ?>") -105px -7px no-repeat;
    position:absolute;
    top:9px;
    right:6px;
    width:17px;
    height:19px;
    content:' ';
}
.login input[type = 'text'] , .login input[type = 'password']{
    padding:7px;
    border:1px solid rgb(221, 221, 221);
    border-radius:2px;
    width:265px;
}
.login input[type = 'text']:focus , .login input[type = 'password']:focus{
    border:1px solid #ffb464;
    outline:none;
}
.login .shut{
    position:absolute;
    top:15px;
    right:15px;
    background:url( "<?php echo base_url('bgimage/login.png') ?>") -36px -5px no-repeat;
    width:18px;
    height:18px;
    content:' ';
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
    width:100%;
    position:relative;
}
a{
    color:inherit;
}
.reg{
    position:absolute;
    bottom:7px;
    font-size:14px;
    right:0;
}
.reg a{
    color:#31b2ee;
}
.atten{
    font-size:12px;
    margin-left:9px;
}
.success{
    right:-33px;
    top:4px;
    width:25px;
    height:25px;
    background:url( "<?php echo base_url('bgimage/login.png') ?>") -55px -1px no-repeat;
    position:absolute;
    content:' ';
}
.login .failed{
    color:red;
}
.atten{
    color:green;
}
</style>
