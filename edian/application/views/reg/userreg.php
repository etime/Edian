<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8">
    <title>用户注册</title>
    <link rel="stylesheet" href="<?php echo base_url('css/reg.css')?>" type="text/css" charset="UTF-8">
<?php $baseUrl = base_url();?>
    <link rel="icon" href="<?php echo $baseUrl.'favicon.ico' ?>">
<script type="text/javascript">
    var site_url = "<?php echo site_url()?>";
    var base_url = "<?php echo base_url()?>";
</script>
</head>
<body>
    <table id="content"  class = "clearfix">
        <form action="<?php echo site_url("register/userRegisterCheck")?>" method="post" enctype = "multipart/form-data" accept-charset="utf-8">
            <tr>
                <td>用户名:</td>
                <td>
                    <input type="text" name="loginName" />
                    <!--中英文字幕字符-->
                    <span></span>
                </td>
            </tr>
            <tr>
                <td>密码:
                    <span class = "xx">*</span>：
                </td>
                <td>
                    <input type="password" name="password" />
                    <span id = "pass"></span>
                </td>
            </tr>
            <tr>
                <td>确认密码<span class = "xx">*</span>：</td>
                <td>
                    <input type="password" name="confirm" />
                    <span></span>
                </td>
            </tr>
            <tr>
                <td>联系方式(手机)
                    <span class = "xx">*</span>：
                </td>
                <td>
                    <input type="text" name="phoneNum" /><span id = "contra"></span>
                </td>
            </tr>
            <tr>
                <td>
                    短信验证码
                    <span class = "xx">*</span>：
                </td>
                <td>
                    <input type = "text" name = "checkNum"/>
                    <a id = "smschk" href = "javascript:javascript">发送验证码</a>
                    <span></span>
                </td>
            </tr>
            <tr class = "tip">
                <td>标有<span class = "xx">*</span>为必填内容，其他可选
                </td>
            </tr>
            <tr><td>同意用户协议</td></tr>
            <tr class = "center">
                <td><input type="submit" name="sub" value="提交"/></td>
            </tr>
        </form>
    </table>
<!--
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=672fb383152ac1625e0b49690797918d"></script>
-->
</body>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/jquery.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/userreg.js')?>"></script>
</html>
