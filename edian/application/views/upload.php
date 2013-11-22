<!DOCTYPE html>
<html lang = "en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="<?php echo base_url("css/upload.css")?>" type="text/css" media="screen" charset="utf-8"/>
    <title>上传</title>
    <script type="text/javascript" src = "<?php echo base_url("js/jquery.js")?>" ></script>
<script type="text/javascript" src = "<?php echo base_url("js/upload.js")?>"></script>
<script type="text/javascript" >
    var site_url = "<?php echo site_url('')?>";
</script>
</head>
<body>
    <form method = 'post' action = "<?php echo site_url('chome/uploadDel')?>" enctype='multipart/form-data'>
        <table border="0">
            <tr>
                <td>上传图片</td>
                <td>
                    <input type = 'file' id = 'file' name = 'userfile' value = '选择图片' size = "11"/>
                </td>
            </tr>
            <tr>
                <td><label for="classfication">类别:</label></td>
                <td>
                    <select name="classfication" id="classfication">
                        <option value="花椒">花椒</option>
                        <option value="胡椒">胡椒</option>
                        <option value="辣椒">辣椒</option>
                        <option value="红椒">红椒</option>
                        <option value="泡椒">泡椒</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="key_word">关键字:</label></td>
                <td>
                    <textarea name="key" id="key"></textarea>
                    <div id = "keys">
                    </div>
                    <input type = 'hidden' id = 'key' name = 'key_word'/>
                </td>
            </tr>
            <tr>
            </tr>
        </table>
        <input type = 'submit' name = 'sub' value = '上传'/>
    </form>
</body>
</html>
