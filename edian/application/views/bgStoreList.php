<!doctype html>
<html>
<?php
    $siteUrl = site_url();
?>
    <head>
        <meta charset="utf-8">
        <title></title>
        <style type="text/css">
        table{
            table-layout: fixed;
            width: 100%;
            border-top: 1px solid #ccc;
            text-align:center;
        }
        a{
            text-decoration:none;
        }
        a:hover{
            text-decoration:underline;
        }
        p{
            line-height:0.4em;
        }
        .mail-box th{
            font-size: 20px;
            color: #4bbdfd;
            border-bottom: 1px solid #ccc;
        }

        .mail-box td{
            border-bottom: 1px solid #ccc;
        }
        .user,.who{
            width: 55px;
        }
        .action{
                width:75px;
        }
        .userName{
            width:120px;
        }
        .state{
            width:60px;
        }
        </style>

    </head>
        <!--  S - body -->
    <body>
    <table cellspacing="0" class="mail-box">
        <tr>
            <th class="user">id</th>
            <th class = "userName">用户名</th>
            <th class = "state">状态</th>
            <th class = "action">操作</th>
        </tr>
        <?php foreach($storeAll as $store):?>
        <tr>
            <td class="user">    <?php echo $store['id'] ?>  </td>
            <td>
                <a href = "<?php echo $siteUrl . '/bg/set/setAct/' . $store['id'] ?>">
                    <?php echo $store['name']?>
                </a>
            </td>
            <td class = "state"><?php echo $state[$store['state']]?></td>
            <td class="action">
                <?php foreach ($state as $key => $val):?>
                    <a href="<?php echo $siteUrl.('/bg/userlist/mange/' . $store['id'] . '/' . $key)?>"><?php echo $val ?></a>
                <?php endforeach?>
            </td>
        </tr>
    <?php endforeach?>
    </table>
    </body>
        <!--  E - body -->
</html>
