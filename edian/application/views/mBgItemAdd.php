<!DOCTYPE html>
<html lang = "en">
<head>
    <meta http-equiv = "content-type" content = "text/html;charset = utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.8 ,maximum-scale= 1.2 user-scalable=yes" />
    <title><?php echo $title?></title>
<?php
    $baseUrl = base_url();
    $siteUrl = site_url();
?>
    <link rel="stylesheet" href="<?php echo base_url('css/bgItemAdd.css')?>" type="text/css" charset="UTF-8">
    <link rel="icon" href="favicon.ico">
<script type="text/javascript" src = "<?php echo base_url('js/jquery.js')?>"> </script>
<script type="text/javascript" src = "<?php echo base_url('js/cookie.js')?>"> </script>
<script type="text/javascript" >
    var admin = "<?php echo $this->adminMail?>";
    var dir = <?php  echo json_encode($dir)?>;
</script>
<body class = "clearfix">
    <div id="content" class="contSpace">
        <form action="<?php echo $siteUrl.('/write/bgAdd')?>" method="post" enctype = "multipart/form-data" accept-charset = "utf-8">
            <p class = "col part" id = "part">
                    <span class = "item">类别<span class = "X">*</span>:</span>
<?php
    $count = 1;
?>
<!--js控制选择-->
            <?php foreach ($dir as $key => $value):?>
                <input type="radio" name="part" value="<?php echo $key ?>" <?php if($userType == 2){ if($key == "二手交易") echo "checked='ehecked'"; else echo "disabled";}else if($key == "食品") echo "checked='checked'"?>/><span><?php echo $key?></span>
            <?php endforeach?>
                <input type="radio" name="part" value="其他" <?php if($userType == 2) echo "disabled"?>/><span>其他</span>
            </p>
            <p class = "col">
                <span class = "item">商品价格<span>*</span>:(元)</span><input type="text" name="price" class = "price" id = "price" /><span id = "patten"></span>
                <span class = "item" style = "display:none">促销价格:(元)</span><input type="hidden" name="sale" id = "sale"  class = "price"/><span id = "patten"></span>
            </p>
<!--
            <p  class = "col">
                <span class = "item">商品主图<span>*</span>:</span><input type="file" name="userfile" size = "14"/>
                <span id = "imgAtten">请用800*800以下图片,超过标准会压缩</span>
            </p>
-->
            <p class = "col">
                <span class = "item">服务承诺</span>
                <input type="text" name="promise" id = "promise" class = "title" value = "送货"/>
            </p>
            <p class = "label col">
                <span class = "item">关键词<span>*</span></span>
                <input type="text" class = "title" name="key" id = "key" value="明天 美好，世界"/>
                <label for="key">查找更准确,请空格断开如:水果 苹果 青苹果 送货</span></label>
            </p>
            <p class = "col"><span class = "item">商品属性:</span><span>可以在下面灰色框添加至多两组属性,如颜色,重量,规格,口味等，右边添加黄色,绿色,或者是选用图片 </span></p>
            <table  id = "pro" class = "pro" border = "1">
                <tr  class="proBl clearfix">
                    <td class = "proK">
                        <input type = "text" name = "proKey" placeholder = "颜色尺寸等属性名称" >
                    </td>
                    <td class = "proVal">
                        <table >
                        <!--将来添加js禁止标点哦-->
                            <tr>
                                <td>
                                    <input type = "text" name = "proVal" class = "liVal" placeholder = "红色XL等属性值">
                                </td>
                                <td>
                                    <a class = "choseImg" href = "javascript:javascript">选择图片</a>
                                </td>
                                <td>
                                    <a class = "uploadImg" href = "javascript:javascript">上传图片</a>
                                </td>
                                <td>
                                    <img class = "chosedImg" src = ""/>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--下面两个div  是为了上传图片准备的，一个是选择，一个是上传-->
            <div id = "ifc" class = "ifc" style = "display:none">
                <div >
                    <a class = "close" href = "javascript:javascript">关闭</a>
                    <iframe border = "none" id = "uploadImg"  name = "img" src = " <?php echo site_url('chome/upload') ?>"></iframe>
                </div>
            </div>
            <div id="ichose"  class = "ichose" style = "display:none">
                <div>
                    <a class = "close" id = "iclose" href = "javascript:javascript">关闭</a>
                        <div>
                            <?php foreach ($img as $temp):?>
                            <img src = " <?php echo $baseUrl.'upload/'.$temp['img_name'] ?>">
                            <?php endforeach?>
                        </div>
                </div>
            </div>
            <p class = "col">
                <span class = "item">总库存量<span >*</span>:</span>
                <input type = "text" name = "storeNum" id = "storeNum" class = "price">
                <span id = "as"></span>
                <!--attten store-->
            </p>
            <!--final ans 最终所有的答案都需要到这里查找-->
            <div id = "store"  >
            </div>
            <div id = "oimg" class = "col">
                <p><span class = "item">商品图片<span>*</span></span><span class = "atten">请不要超过6张图片,第一张很重要,超过800*800会自动压缩</span></p>
                <div class = "moreImg">
                     <a class = "choseImg" href = "javascript:javascript">选择图片</a>
                     <a class = "uploadImg" href = "javascript:javascript">上传图片</a>
                </div>
            </div>
            <input type="hidden" name="Img" id="Img" />
            <!--通过js 修改value 所有图片的集合-->
            <input type="hidden" name="attr" id="attr" />
            <!---->
           <div id = "oimgUp" style = "display:none" class = "ifc">
            <!--oimg upload 上传更多的图片使用的-->
                <div >
                    <a class = "close" href = "javascript:javascript">关闭</a>
                    <iframe border = "none" id = "ouploadImg"  name = "img" src = " <?php echo site_url('chome/upload') ?>"></iframe>
                </div>
            </div>
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
            <p class = "clearfix label col">
                <span class = "item">标题<span>*</span></span>
                <input type="text" name="title" id = "title" class = "title"  value = "物美价廉"/>
                <label for = "title">请用简短的描述商品,尽量包含名称和特点，尽量50字以内哦</label>
<!----------------title太差劲了。,学习以下taobao了-------->
            </p>
            <p class = "col"><span class = "item">商品描述<span>*</span>:</span></p>
            <tr id = "tcont">
                <td><textarea name="cont" id = "cont" style = "width:100%"> <?php echo "测试信息" ?></textarea></td>
            </tr>
         <input type="submit" name = "sub" class = "button" value="发表" />
        </form>
    </div>
<script type="text/javascript" src = "<?php echo base_url('js/xheditor.min.js')?>"></script>
<script type="text/javascript" src = "<?php echo base_url('js/zh-cn.js')?>"></script>

<script type="text/javascript" >
var site_url = "<?php echo site_url()?>";
var user_name="<?php echo $this->session->userdata('user_name')?>";
var user_id="<?php echo $this->session->userdata('user_id')?>";
var PASSWD = "<?php echo $this->session->userdata("passwd")?>";
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
