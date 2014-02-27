<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>这里可以为我们目前的设计投票</title>
    </head>
    <body>
    <ul>
    <h2>这里是设计作品的列表</h2>
    <form action="<?php  echo site_url('test/voteAct')?>" method="post" accept-charset="utf-8">
    <?php
        /**
         * @name        index.php
         * @author      unasm < 1264310280@qq.com >
         * @since       2013-12-22 17:56:18
         */
        $dir = "image";
        $base_url = "http://" . @$_SERVER['SERVER_NAME'] . "/image/";
        if(is_dir($dir)){
            if($dh = opendir($dir)){
                while( ($file = readdir($dh)) !== false){
                    if($file != '..' && $file != '.' && !is_dir($dir .'/' . $file)){
                        echo '<li>';
                        echo  "<input type = 'radio' value = '$file' name = 'fileName'/>";
                        echo '<a href = '. $base_url . '/' . $file .' target = __blank>' . $file. '</a><br/>';
                        echo '</li>';
                    }
                }
            }
            closedir($dh);
        }
    ?>
    </ul>
    <ul>
            <li>姓名:<input type="text" name="name"/></li>
            <fieldset>
                <legend>这里输入评价内容</legend>
                    <textarea name="content" ></textarea>
            </fieldset>
            <input type="submit" name="sub"  value="提交" />
    </ul>
    </form>
    <ul>
        <?php foreach ($com as $val):?>
        <li>
            <h4>
                <?php
                    echo $val['name']. "对:<a href = ". $base_url . $val['filename'] . " target = __blank'> ".$val['filename']."</a>评论";
                ?>
            </h4>
            <blockquote> <?php echo $val['content'] ?></blockquote>
        </li>
        <?php endforeach ?>
    </ul>
    </body>
<style type="text/css" media="all">
    textarea{
        width:100%;
        height:100%;
        resize:none;
        border:1px solid rgb(199,199,199);
        border-radius:2px;
        outline:none;
    }
    textarea:focus{
        box-shadow:0 1px 0 rgba(248, 248, 248, 0.8), 0px 1px 4px rgba(180, 179, 179, 0.7) inset;
        border:1px solid rgb(194, 194, 194);

    }
</style>
</html>
