<!-- 这里是作为网页的一部分出现的，是网站的头部,css和html在一起-->
<link rel="stylesheet" href="<?php  echo base_url('css/font/css/font-awesome.min.css')?>" type="text/css" media="all" />
<div id = "header" class="clearfix" >
    <div>
        <div class = "logo">
            <h1>e<span>點</span></h1>
        </div>
        <p style="float:right">
            <!-- replace 中的是登录之后替换的东西-->
            <span class = "replace">
                <a href = "#" id = "gotoLogin" class = "gotoLogin">登录</a>
                |
                <!--
                <a href = "<?php echo site_url('/register/userRegister/') ?>" class = "register">注册</a>
                -->
                <a href = "#" class = "register">注册</a>
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
        <span class = "shut"><i class = "fa fa-times"> </i></span>
        <div class = "regd" id = "regd">
            <span class = "focus" name = 'l' >登录</span>
            <span name = "r" >注册</span>
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
                <input type="submit" name="sub"  value="登录"  class = "btn button glow button-flat"/>
            <!--
                <span class = "reg">没有帐号?
                    <a href = "<?php echo site_url('register/userRegister') ?>"  style = "color:#31b2ee">马上注册</a>
                </span>
            -->
            </p>
        </form>
        <form action="<?php echo site_url('register/userRegister') ?>" method="post" accept-charset="utf-8" class = "r" style = "display:none" >
            <p>
                <input type="text" name="loginName" id = "userName" placeholder = "用户名/手机号" />
                <i class = "atten"></i>
                <label for="userName"><i class = "fa fa-user"></i></label>
            </p>
            <p>
                <input type="password" name="password" placeholder = "密码" />
                <span class = "atten"></span>
                <label for="password"><i class = "fa fa-unlock-alt"></i></label>
            </p>
            <p>
                <input type="password" name="confirm" placeholder = "密码" />
                <span class = "atten"></span>
                <label for="password"><i class = "fa fa-unlock-alt"></i></label>
            </p>
            <p>
                <input type="text" name="phoneNum" placeholder = "手机号" />
                <span class = "atten"></span>
                <label for="phoneNum"><i class = "fa fa-phone"></i></label>
            </p>
            <p>
                <input type="text" name="checkNum" />
                <span class = "atten"></span>
                <input type="button"  id="smschk" value="发送验证码"  class = "btn button glow button-flat"/>
            </p>
            <p>
                <input type="submit" name="sub"  value="注册"  class = "btn button glow button-flat"/>
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
    cursor:pointer;
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
    width:110px;
}
label[for = 'userName']{
    position:absolute;
    top:9px;
    right:6px;
    width:18px;
    height:19px;
    content:' ';
}
label[for = 'password']{
    position:absolute;
    top:9px;
    right:6px;
    width:17px;
    height:19px;
    content:' ';
}
label[for = 'phoneNum']{
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
.login input[type = 'text']:hover , .login input[type = 'password']:hover{
    border:1px solid #0099ff;
    outline:none;
}
.login input[type = 'text']:focus , .login input[type = 'password']:focus{
    border:1px solid #ffb464;
    outline:none;
}
.login .shut{
    position:absolute;
    top:15px;
    right:15px;
    cursor:pointer;
    color:#D6d6d6;
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
#header a , #htab a{
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
    position:absolute;
    content:' ';
    font-size:20px;
}
.login .failed{
    color:red;
}
.atten{
    color:green;
}
.button-flat:hover {
    background: #fbfbfb;
}
.button-flat:active {
  background: #eeeeee;
  color: #bbbbbb;
}
.button-flat {
  -webkit-transition-property: background, color;
  -moz-transition-property: background, color;
  -o-transition-property: background, color;
  transition-property: background, color;
  -webkit-transition-duration: 0.3s;
  -moz-transition-duration: 0.3s;
  -o-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
  background: #e9e9e9;
  border: none;
  text-shadow: none;
}
.button:active {
      -webkit-box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.3), 0px 1px 0px white;
      -moz-box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.3), 0px 1px 0px white;
      box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.3), 0px 1px 0px white;
      text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.4);
      background: #eeeeee;
      color: #bbbbbb;
}
.button:hover {
  background-color: #eeeeee;
  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #ffffff), color-stop(100%, #dcdcdc));
  background: -webkit-linear-gradient(top, #ffffff, #dcdcdc);
  background: -moz-linear-gradient(top, #ffffff, #dcdcdc);
  background: -o-linear-gradient(top, #ffffff, #dcdcdc);
  background: linear-gradient(top, #ffffff, #dcdcdc);
}
.button {
  -webkit-box-shadow: inset 0px 1px 0px rgba(255, 255, 255, 0.5), 0px 1px 2px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: inset 0px 1px 0px rgba(255, 255, 255, 0.5), 0px 1px 2px rgba(0, 0, 0, 0.2);
  box-shadow: inset 0px 1px 0px rgba(255, 255, 255, 0.5), 0px 1px 2px rgba(0, 0, 0, 0.2);
  background-color: #eeeeee;
  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #fbfbfb), color-stop(100%, #e1e1e1));
  background: -webkit-linear-gradient(top, #fbfbfb, #e1e1e1);
  background: -moz-linear-gradient(top, #fbfbfb, #e1e1e1);
  background: -o-linear-gradient(top, #fbfbfb, #e1e1e1);
  background: linear-gradient(top, #fbfbfb, #e1e1e1);
  display: -moz-inline-stack;
  display: inline-block;
  vertical-align: middle;
  *vertical-align: auto;
  zoom: 1;
  *display: inline;
  border: 1px solid #d4d4d4;
  height: 32px;
  line-height: 32px;
  padding: 0px 25.6px;
  font-weight: 300;
  font-size: 14px;
  font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
  color: #666666;
  text-shadow: 0 1px 1px white;
  margin: 0;
  text-decoration: none;
  text-align: center;
}
.button {
  -webkit-box-shadow: inset 0px 1px 0px rgba(255, 255, 255, 0.5), 0px 1px 2px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: inset 0px 1px 0px rgba(255, 255, 255, 0.5), 0px 1px 2px rgba(0, 0, 0, 0.2);
  box-shadow: inset 0px 1px 0px rgba(255, 255, 255, 0.5), 0px 1px 2px rgba(0, 0, 0, 0.2);
  background-color: #eeeeee;
  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #fbfbfb), color-stop(100%, #e1e1e1));
  background: -webkit-linear-gradient(top, #fbfbfb, #e1e1e1);
  background: -moz-linear-gradient(top, #fbfbfb, #e1e1e1);
  background: -o-linear-gradient(top, #fbfbfb, #e1e1e1);
  background: linear-gradient(top, #fbfbfb, #e1e1e1);
  display: -moz-inline-stack;
  display: inline-block;
  vertical-align: middle;
  *vertical-align: auto;
  zoom: 1;
  *display: inline;
  border: 1px solid #d4d4d4;
  height: 32px;
  line-height: 32px;
  padding: 0px 25.6px;
  font-weight: 300;
  font-size: 14px;
  font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
  color: #666666;
  text-shadow: 0 1px 1px white;
  margin: 0;
  text-decoration: none;
  text-align: center;
}
label i{
    color:#BBB;
}
label:focus{
    color:red;
}
.button.glow {
  -webkit-animation-duration: 3s;
  -moz-animation-duration: 3s;
  -ms-animation-duration: 3s;
  -o-animation-duration: 3s;
  animation-duration: 3s;
  -webkit-animation-iteration-count: infinite;
  -khtml-animation-iteration-count: infinite;
  -moz-animation-iteration-count: infinite;
  -ms-animation-iteration-count: infinite;
  -o-animation-iteration-count: infinite;
  animation-iteration-count: infinite;
  -webkit-animation-name: glowing;
  -khtml-animation-name: glowing;
  -moz-animation-name: glowing;
  -ms-animation-name: glowing;
  -o-animation-name: glowing;
  animation-name: glowing;
}
/* line 250, ../scss/button.scss */
.button.glow:active {
  -webkit-animation-name: none;
  -moz-animation-name: none;
  -ms-animation-name: none;
  -o-animation-name: none;
  animation-name: none;
  -webkit-box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.3), 0px 1px 0px white;
  -moz-box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.3), 0px 1px 0px white;
  box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.3), 0px 1px 0px white;
}

</style>
