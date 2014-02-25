<!DOCTYPE html>
<html lang = "en">
<head>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title><?php echo $title?></title>
<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
    if(! (isset($update) && $update ) )$update = 0;
    if(! (isset($itemId) && $itemId ) )$itemId = 0;
?>
    <link rel="stylesheet" href="<?php echo base_url('css/bgItemAdd.css')?>" type="text/css" charset="UTF-8">
    <link rel="icon" href="favicon.ico">
<script type="text/javascript" src = "<?php echo base_url('js/jquery.js')?>"> </script>
<script type="text/javascript" src = "<?php echo base_url('js/cookie.js')?>"> </script>
<script type="text/javascript" >
    var admin = "<?php echo $this->adminMail?>";
    var dir = <?php  echo @json_encode($dir)?>;
</script>
<body class = "clearfix">
    <div id="content" class="contSpace">
        <form action="<?php echo $siteUrl.('/write/bgAdd/' . $update . '/' . $itemId)?>" method="post" enctype = "multipart/form-data" accept-charset = "utf-8">
            <div class = "part" id = "part">
                <p>
                        <span class = "item">全站类别<span class = "X">*</span>:</span>
                    <!--js控制选择-->
<?php
    if(isset($update) && $update){
        $str = '';
        foreach ($dir as $key => $value){
            if($key === $category['keyi']){
                $str  .=  "<input type='radio' name='keyi' value= $key checked = checked/><span>$key</span>";
                $arrkey = $value;
                $keyIdx = $key;
            } else {
                $str .= "<input type='radio' name='keyi' value= $key /><span>$key</span>";
            }
        }
        $dir = $arrkey;
        $str .= "</p><p id = 'kj'><span class = 'item'>$keyIdx<span class = 'X'>*</span>:</span>";
        foreach ($dir as $key => $value){
            if($key === $category['keyj']){
                $str  .=  "<input type='radio' name='keyj' value= $key checked = checked/><span>$key</span>";
                $arrkey = $value;
                $keyIdx = $key;
            } else {
                $str .= "<input type='radio' name='keyj' value= $key /><span>$key</span>";
            }
        }
        $str .= '</p>';
        $dir = $arrkey;
        $str .= "</p><p id = 'kk'><span class = 'item'>$keyIdx<span class = 'X'>*</span>:</span>";
        foreach ($dir as $value){
            if($value === $category['keyk']){
                $str  .=  "<input type='radio' name='keyk' value= $value checked = checked/><span>$value</span>";
            } else {
                $str .= "<input type='radio' name='keyk' value= $value /><span>$value</span>";
            }
        }
        $str .= '</p>';
        echo $str;
    } else {
        foreach ($dir as $key => $value){
            echo "<input type='radio' name='keyi' value= $key /><span>$key</span>";
        }
        echo "</p><p id = 'kj'></p><p id = 'kk'></p>";
    }
?>
            </div>
            <li class = "col clearfix">
                <span class = "item" style = "float:left">本店分类<span class = "X">*</span>:</span>
                <div id = "category">
                <?php foreach ($category as $value):?>
                    <?php
                        if(isset($update) && $update && $value === $category['category']){
                            echo "<input type = 'radio' name = 'category' value = $value  checked = checked>";
                        } else {
                            echo "<input type = 'radio' name = 'category' value = $value >";
                        }
                    ?>
                    <span>
                        <?php echo $value;?>
                    </span>
                <?php endforeach?>
                <input type="text" name="listName" /><span class = "button" id = "listBut">添加分类</span>
                </div>
            </li>
            <li class = "clearfix label col">
                <span class = "item">名称<span>*</span>:</span>
                <input type="text" name="title" id = "title" class = "title"  placeholder = "请用简短的描述商品,尽量包含名称和特点，尽量50字以内哦" value="<?php echo @$title ?>"/>
                <!----------------title太差劲了。,学习以下taobao了-------->
            </li>
            <li class = "col">
                <span class = "item">价格
                    <span>*</span>:
                </span>
                <input type="text" name="price" class = "float" id = "price" value="<?php echo @$price?>"/>
                <span>(元)</span>
                <span class = "item" style = "display:none">促销价格:(元)</span><input type="hidden" name="sale" id = "sale"  class = "price"/><span id = "patten"></span>
            </li>
            <li  class = "col clearfix">
                <span class = "item" style = "float:left">主图<span>*</span>:</span>
                <div class = "dmg">
                    <p>
                        <input type = "button" name = "mainInput" value = "上传图片"  id = "mainInput"/>
                        <span class = "atten">请用1:1的图片</span>
                        <input type="hidden" name="mainThumbnail" value="<?php echo @$mainThumbnail ?>" />
                    </p>
                    <img src = "<?php echo @$mainThumbnail ?>" id = "toImgMain"/>
                    <!-- <input type="file" name="userfile" size = "14"/> -->

                </div>
            </li>
            <div id = "thumbnail" class = "col clearfix" title = "双击图片删除">
                <span class = "item" style = "float:left">副图<span>*</span></span>
                <div class = "dmg">
                    <p>
                        <input type = "button" name = "thumbButton" id = "thumbButton" value = "上传图片" />
                        <span class="atten">请将宽度限制在1：2和2：1之内之内</span>
                    </p>
                    <?php
                        if(isset($thumbnail) && $thumbnail){
                            foreach ($thumbnail as $img) {
                                echo "<img src = '" .$img ."' />";
                            }
                        }

                    ?>
                </div>
            </div>
            <li class = "col clearfix">
                <span class = "item" style = "float:left">商品属性:</span>
                <div class = "dmg">
                    <span class = "atten">可以在下面灰色框添加至多两组属性,如颜色,重量,规格,口味等，右边添加黄色,绿色,或者是选用图片 </span>
                    <table  id = "pro" class = "pro" border = "1">
                        <?php
                            if(!(isset($attr['idx']) && $attr['idx']))$attr['idx'] = array('' => array(''));
                            //var_dump($attr['idx']);
                            foreach($attr['idx'] as $key => $value):
                        ?>
                        <tr  class="proBl clearfix">
                        <td class = 'proK'><input type = 'text' name = 'proKey' placeholder = '颜色尺寸等属性名称' value = "<?php echo @$key ?>" ></td>
                            <td class = "proVal">
                                <table >
                                <!--将来添加js禁止标点哦-->
                                <?php foreach($value as $liAtr):?>
                                    <tr>
                                    <td><input type = "text" name = "proVal" class = "liVal" placeholder = "红色XL等属性值" value="<?php  echo @$liAtr['font']?>"></td>
            <!--
                                        <td><a class = "choseImg" href = "#">选择图片</a></td>
            -->
                                        <td><a class = "uploadImg" href = "#">上传图片</a></td>
                                        <td><a class = "uploadImg" href = "#">删除</a></td>
                                        <td><img class = "chosedImg" src = "<?php echo @$liAtr['img'] ?>"/></td>
                                    </tr>
                                <?php endforeach ?>
                                </table>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </table>
                </div>
            <!--下面两个div  是为了上传图片准备的，一个是选择，一个是上传-->


            <li class = "col">
                <span class = "item">总库存量<span >*</span>:</span>
                <input type = "text" name = "storeNum" id = "storeNum" class = "float" value="<?php echo @$storeNum ?>">
                <span id = "as"></span>
                <!--attten store-->
            </li>
            <!--final ans 最终所有的答案都需要到这里查找-->
            <div id = "store"  >
            <table  border = "1">
            </table>
            </div>

            <input type="hidden" name="thumbnail" id="Img" />
            <!--通过js 修改value 所有图片的集合-->
            <input type="hidden" name="attr" id="attr" />

            <div id="ochose" class = "ichose" style = "display:none">
                <div>
                    <a class = "close" id = "iclose" href = "javascript:javascript">关闭</a>
                        <div>
                            <?php foreach ($img as $temp):?>
                            <img src = " <?php echo $baseUrl.'upload/'.$temp['img_name'] ?>">
                            <?php endforeach?>
                        </div>
                </div>
            </div>

            <li class = "col"><span class = "item">商品描述<span>*</span>:</span></li>
            <tr id = "tcont" >
                <td><textarea name="detail" id = "cont" style = "width:100%"> <?php echo @$detail ?></textarea></td>
            </tr>
            <p>
                <input type="submit" name = "sub" class = "button" value="发表" />
            </p>
        </form>
    </div>
    <!--对属性描述和thumb的两处图片的上传-->
    <div id = "oimgUp" class = "popf" style = "display:none">
        <div >
            <a class = "close" href = "#">关闭</a>
            <iframe border = "none" id = "uploadImg"  name = "img" src = " <?php echo site_url('upload/index') ?>"></iframe>
        </div>
    </div>
    <!-- 对商品主图片的上传-->
    <div id = "main" class = "popf" style = "display:none">
        <div >
            <a class = "close" href = "#">关闭</a>
            <iframe border = "none" id = "mainImg"  name = "img" src = " <?php echo site_url('upload/index/1') ?>"></iframe>
        </div>
    </div>
    <!-- 选择图片，添加到对应的地方-->
<!--
    <div id="ichose"  class = "ichose" style = "display:none">
        <div>
            <a class = "close" id = "iclose" href = "#">关闭</a>
                <div>
                    <?php foreach ($img as $temp):?>
                    <img src = " <?php echo $baseUrl.'upload/'.$temp['img_name'] ?>">
                    <?php endforeach?>
                </div>
        </div>
    </div>
-->
<script type="text/javascript" src = "<?php echo base_url('js/xheditor.min.js')?>"></script>
<script type="text/javascript" src = "<?php echo base_url('js/zh-cn.js')?>"></script>
<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
$(pageInit);
function pageInit()
{
    $.extend(XHEDITOR.settings,{shortcuts:{'ctrl+enter':submitForm}});
    $('#cont').xheditor({upImgUrl:site_url+"/write/imgAns?immediate=1",upImgExt:"jpg,jpeg,gif,png"});
}
function insertUpload(arrMsg)
{
    var i,msg;
    for(i=0;i<arrMsg.length;i++)
    {
        msg=arrMsg[i];
        $("#uploadList").append('<option value="'+msg.id+'">'+msg.localname+'</option>');
    }
}
function submitForm(){$('#frmDemo').submit();}
</script>
<script type="text/javascript" src = "<?php echo base_url('js/mBgItemAdd.js')?>"> </script>
</body>
</html>
