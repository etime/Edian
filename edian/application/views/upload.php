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
<<<<<<< HEAD
    <form method = 'post' action = "<?php echo site_url('upload/upload_picture')?>" enctype='multipart/form-data'>
        <input type = 'file' id = 'file' name = 'userfile' value = '上传图片' size = "11"/> <br />

				<label for="category">类别:</label> <br />
        <input type = 'text' id = 'category' name = 'category'/> <br />

				<label for="key_word">关键字:</label> <br />
        <input type = 'text' id = 'key' name = 'key_word'/> <br />

=======
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
>>>>>>> 811d6f4677330418ef2e33ff6695e3fd91e3be19
        <input type = 'submit' name = 'sub' value = '上传'/>
    </form>

<div id="upload">

</div>

</body>
</html>
