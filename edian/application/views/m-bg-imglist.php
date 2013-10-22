<!doctype html>
<?php
    $siteUrl = site_url();
?>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('common_content')?>" />
        <style type="text/css">
        table{
            table-layout: fixed;
            white-space: nowrap;
            width: 100%;
            border-top: 1px solid #ccc;
            font-size: 16px;
            text-align:center;
        }
        .mail-box th{
            font-size: 20px;
            color: #4bbdfd;
            border-bottom: 1px solid #ccc;
        }
        .mail-box td{
            border-bottom: 1px solid #ccc;
        }
        .mail-box .user{
            width: 100px;
            overflow:hidden;
        }
        .mail-box .date{
            width: 150px;
        }
        .mail-box .tm{
            overflow: hidden;
            text-overflow:ellipsis;
        }
        .mail-box .action{
            width:70px;
        }
        .img_name img{
            max-height:60px;
        }
        </style>
    </head>
        <!--  S - body -->
    <body>
        <table cellspacing="0" class="mail-box">
            <tr>
                <th class="img_name">图片名称</th>
                <th class="time">上传时间</th>
                <th class="action">操作</th>
            </tr>
        <?php foreach($imgall as $temp):?>
            <tr>
                <td class="img_name">
                    <a href="<?php echo base_url('upload/'.$temp->img_name)?>">
                        <img src="<?php echo base_url('thumb/'.$temp->img_name)?>"/>
                    </a>
                </td>
                <td class="time"><?php echo $temp->upload_time ?></td>
                <td><a href = "<?php echo $siteUrl.('/bg/imglist/imgdel/').$temp->img_id."/".$temp->img_name ?>">删除</a></td>
<!--
                <td class="time"><a href="<?php echo site_url('bg/imglist/imgdel/'.$temp->img_name)?>">删除</a></td>
-->
            </tr>
        <?php endforeach?>
        </table>
    </body>
        <!--  E - body -->
</html>
