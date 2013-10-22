<!DOCTYPE html>
<html lang = "en">
<head>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.6 ,maximum-scale= 1.5 user-scalable=yes" />
    <title><?php echo $title?></title>
    <?php
        $baseUrl = base_url();
        $siteUrl = site_url();
    ?>
    <link rel="stylesheet" href="<?php echo $baseUrl.'css/art.css'?>" type="text/css" charset="UTF-8">
    <link rel="stylesheet" href="<?php echo $baseUrl.'css/dir.css'?>" type="text/css" charset="UTF-8">
    <link rel="icon" href="<?php echo $baseUrl.('favicon.ico')?>" >
    <script type="text/javascript" >
    var site_url = "<?php echo site_url()?>",base_url = "<?php echo base_url()?>",user_name="<?php echo $this->session->userdata('user_name')?>",user_id = "<?php echo $this->session->userdata('user_id')?>",now_type = "<?php echo $part_id?>",layer=1;
    var user = <?php  echo isset($user)?json_encode($user):"0";?>;
</script>
</head>
<body  class = "clearfix" >
    <div id="content" class = "content clearfix">
        <ul id="ulCont"  class = "clearfix">
            <h2 id = "title"><?php echo $title ?></h2>
            <p id = "info"><span class = "tt">评价:<?php echo $comment_num?>/浏览:<?php echo $visitor_num?><span><?php echo $time?></span></span></p>
            <li class = "mast alire">
                <div class = "clearfix">
                    <img class = "block" src = "<?php echo $baseUrl.('thumb/'.$img)?>"/>
            <!--同时添加一个隐藏的upload，双击放大-->
                    <p class = "mprice">￥:<?php echo $price?>元
                    <?php
                        if($author_id == $this->session->userdata("user_id"))
                        echo "<a id = 'change' href = ".site_url("write/change/".$artId).">修改</a>"
                    ?>
                    </p>
                    <p><a href = "<?php echo site_url('space/index/'.$author_id)?>"><b>卖家</b>：<em><?php echo $user_name?></em></a>  --> <a id = "msg" name = "<?php echo $user_name?>" href = "<?php echo site_url('message/write/'.$author_id)?>"><span id = "msgatten">站内信</span>联系</a></p>
                    <div id = "msgA" class = "block" style = "display:none">
                        <!------发送站内心的框------>
                        <form action="<?php echo site_url('message/add')?>" method="post" accept-charset="utf-8">
                            <input type="text" name="title" id = "msgt" />
                            <input type="button" name="cc" id = "cc" value="取消"/>
                            <input type="text" name="geter" value="<?php echo $user_name."(".$author_id.")"?>"/>
                            <input type="submit" name="sub" value="发送"/>
                            <textarea id = "cont" name="cont"></textarea>
                        </form>
                    </div>
                    <p><em><b>联系方式</b></em>：<?php echo $contract1?></p>
                    <?php if($contract2 != "") echo "<p><em><b>QQ:</b></em>：".$contract2."</p>";?>
                    <?php if($email != "") echo "<p><em><b>邮箱</b></em>：".$email."</p>";?>
                    <?php if($addr != "") echo "<p><b><em>地址</em></b>：".$addr."</p>";?>
                </div>
                <blockquote class = "info"><?php echo $content?></blockquote>
            </li>
        </ul>
        <div id="judge" class = "clearfix sli">
            <form style = "display:none" id = "denglu" class = "clearfix block" action = "<?php echo site_url('reg/dc');?>" method = 'post' accept-charset = "utf-8">
                <span>用户名/手机号:<input type = "text" name = "userName" class = "valTog" /></span>
                <span>密码:<input type = "password" class = "valTog" name = "passwd" /></span>
                <input  class = "et butCol" type = "submit" name = "enter"  value = "登录"/>
            </form>
            <form class = "block clearfix" id = "comform" action="<?php echo site_url('showart/addCom/'.$artId)?>" method="post"  accept-charset="utf-8">
                <div class = "but">
                    <input class = "butCol ji" id ="subcom" type="submit" value="发送"/>
                    <input  class = "butCol ji" id ="giveup" type="button" value="取消"/>
                    <button style = "display:none" title="控制目录显隐" id = "hiA" class = "hiA ji butCol">隐藏</button>
                </div>
                <div id = "dcom">
                    <textarea id = "comcon" name="com" placeholder = "评论.."></textarea>
                </div>
            <div id="face" class = "clearfix" style = "display:none">
<!---------------所有的图片都必须是\d+.gif的格式------------------------------------------>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/15.gif" title="不要嘛，人家会害羞的"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/41.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/42.gif" title="嘿嘿嘿....先拿钱来"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/45.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/46.gif" title="让人家得瑟一会嘛"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/5.gif" title="这个....呵呵.....汗....."/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/47.gif" title="嘿嘿嘿嘿......"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/48.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/50.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/51.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/40.gif" title="饱饱的，很贴心"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/52.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/30.gif" title="汗....."/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/55.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/56.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/10.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/11.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/16.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/15.gif" />
                <img src="http://bbs.stuhome.net/images/post/smile/yang/17.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/18.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/19.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/30.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/61.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/34.gif"/
                ><img src="http://bbs.stuhome.net/images/post/smile/too/24.gif" title="耶..........."/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/35.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/8.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/19.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/1.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/2.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/3.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/6.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/27.gif"/>
                <img src = "http://bbs.stuhome.net/images/post/smile/yang/33.gif"/>
                <img src = "http://bbs.stuhome.net/images/post/smile/too/21.gif"/>
                <img src = "http://bbs.stuhome.net/images/post/smile/too/10.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/9.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/13.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/17.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/1.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/28.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/43.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/31.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/too/32.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/38.gif"/>
                <img src="http://bbs.stuhome.net/images/post/smile/yang/59.gif"/>   </div>
        </form>
        </div>
    </div>

<script type="text/javascript" src = "<?php echo $baseUrl.('js/jquery.js')?>"> </script>
<script type="text/javascript" src = "<?php echo $baseUrl.('js/art.js')?>"> </script>
<script type="text/javascript" >
//  document.onload = com;
</script>
</body>
</html>
