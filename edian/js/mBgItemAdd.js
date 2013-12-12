var prokey = new  Array(),proans =  new Array(),objThumb, objImgSix , property;
/**
 * 处理禁止输入字符的问题
 */
function forbid() {
    $("#pro").delegate("input","keypress",function(event){
        //|{}` & '" = <>=;:  都是不允许输入的
        if(event.which == 96)return false;
        if((event.which < 40)&&(event.which > 33))return false;
        if(event.which < 63 && (event.which > 57))return false;
        if(event.which < 126 && event.which > 122)return false;
    })
    $("#content").delegate(".price","keypress",function(event){
            console.log("testing");
        if((event.which<46)||(event.which>57)){
            return false;
        }
        //之前有针对keypress unbind 其实不需要，因为只会针对price才会检测
    })
    var name;
    $("#store").delegate("input","keypress",function(event){
        name = $(this).attr("name");
        console.log(event.which);
        if(name == "store"){
            if(event.which < 48  || event.which > 57)return false;
        }else{
            if((event.which<46)||(event.which>57)){
                return false;
            }
        }
    })
}
$(document).ready(function  () {
    var value,NoImg = 1,doc = document;
    dir = eval(dir);
    forbid();//处理禁止输入的字符
    $("input[type = 'file']").change(function  () {
        value = $.trim($(this).val());
        console.log(value);
        reg = /.[gif|jpg|jpeg|png]$/i;//图片只允许gif,jpg,png三个格式
        if(!reg.exec(value)){
            $("#imgAtten").text("只有gif,png,jpg格式图片可以");
        }
        var size = $(this)[0].files[0].size / 1000;
        size = parseInt(size)/1000;
        if(size>2){
            $("#imgAtten").text(size+"超过2M了，上传失败的风险很大");
        }
    })
    $("form").submit(function  () {
        value = $.trim($("input[name = 'price']").val());
        if(value.length  == 0){
            $.alet("请输入价格");
            return false;
        }
        value = $.trim($("#key").val());
        if(value.length == 0){
            $.alet("为方便顾客查找，请输入关键字");
            return false;
        }
        value = $.trim($("#title").val());
        if(value.length == 0){
            $.alet("忘记添加标题");
            return false;
        }
        value = doc.getElementById("cont");
        value = $.trim(value.value);
        if(value.length == 0){
            $.alet("请添加内容");
            return false;
        }
       var reg = /\d+\.jpg/,attr;
        var pro2s = $("#store").find(".valTr"),item = Array();
       if(prokey.length == 1){
    /*
           attr的格式为color
                2,2,"颜色","重量",红色,绿色,1kg,3kg|//第一个属性，第二个属性，颜色的个数，重量的个数,方便数据处理
                    [红色,1kg]12,11;
                    [红色,3kg]12,11;
                    [绿色,1kg]12,11
                    [绿色,3kg]12,11
    绿色对应颜色的具体表示，1kg是重量的具体表示，12是存货量,11表示价格
    */
            console.log(pro2s);
            item = getTabData(pro2s);//0是库存，1是价格
            var length = item[0].length;
            attr = length+","+prokey[0];
            attrleft = "";
            for(var i = 0;i<length;i++){
                temp = reg.exec(proans[0][1][i]);//1是图片，0是文字
                if(temp)temp = temp[0];//提取图片的名字
                else temp = " ";
                attr+=","+proans[0][0][i]+":"+temp;//item的0是库存，1是价格
                attrleft+=item[0][i]+","+item[1][i]+";";
                if((!item[0][i]) ||(!item[1][i])){
                    $.alet("为方便游客购物,请补全填库存表");
                    return false;
                }
            }
            if(attrleft == ""){
                //有颜色等属性值，却没有库存，是因为没有填写库存表
                attr="";
            }
            else attr+="|"+attrleft;
       }else if(prokey.length == 2){
            attr = proans[1][0].length+","+proans[0][0].length+","+prokey[1]+","+prokey[0];
            //先从2开始，然后读取长度和内容
            var temp;
            for(var i = 0,len = proans[1][0].length;i<len;i++){
                temp = reg.exec(proans[1][1][i]);
                if(temp)temp = temp[0];
                else temp = " ";
                attr+=","+proans[1][0][i]+":"+temp;
            }
            for(var j = 0,lenj = proans[0][0].length;j<lenj;j++){
                temp = reg.exec(proans[0][1][j]);
                if(temp)temp = temp[0];
                else temp = " ";
                attr+=","+proans[0][0][j]+":"+temp;
            }
            attr+="|";
            for (var i = 0, l = pro2s.length; i < l; i ++) {
                temp = getTabData(pro2s[i]);
                for (var j = 0, l = temp[0].length; j < l; j ++) {
                    attr+=temp[0][j]+","+temp[1][j]+";";
                    if((!temp[0][j]) ||(!temp[1][j])){
                        $.alet("为方便游客购物,请补全填库存表");
                        return false;
                    }
                }
            }
            if(pro2s.length == 0)attr = "";//没有数据的话，清空
       }
       function getTabData(fnode){
           //检查完毕，无误
           var res = new  Array(
                new Array(),
                new Array()
           )//res 第0层对应的是键值，1对应的是存货量，2对应的是价格
           var store = $(fnode).find("input[name = 'store']");
           var sprice = $(fnode).find("input[name = 'sprice']");
           var len = store.length;
           for (var i = 0; i < len; i ++) {
                res[0][i] = $(store[i]).val();
                res[1][i] = $(sprice[i]).val();
            }
            return res;
       }
       if(attr &&(attr[attr.length - 1] == ";")){
           attr = attr.substring(0,attr.length - 1);
       }
       $("#attr").attr("value",attr);
       /*********下面是对图片的处理*********************/
       var oimg = $("#thumbnail").find("img");
       var img = "";
       for (var i = Math.min(oimg.length-1,5); i >= 0; i --) {
           temp = $(oimg[i]).attr("src");
            temp = getName(temp);
            img+=temp+"|";
       }
       if(img.length == 0){
           $.alet("请选择图片");
           return false;
       }
       if(img[img.length -1]=='|'){
           img = img.substring(0,img.length - 1);
       }
       $("#Img").attr("value",img);
       /*******图像的处理结束************************************/
       function getName(tag){
            temp = reg.exec(tag);
            if(temp)return temp[0];
            return tag;
       }
    })
    /************控制title中的字体显隐**************/
    $(".title").focus(function(){
        $(this).siblings("label").css("display","none");
    }).blur(function  () {
        value = $.trim($(this).val());
        if(value.length == 0){
            $(this).siblings("label").css("display","block");
        }
    });
    part(dir);
    property = new proAdd();
    store();
    objImgSix = new funoimgUp();
    mainThum();
    displayHandle();
    objThumb = new thumbnailUpload();
})
/**
 * 这里是控制分区，全站类别的显示
 * @param {arr} list 是全站的数组传递 进来的变量
 */
function part (list) {
    var part = $("#part"),temp,tempk = null,flag = 0;
    /**
     * 当用户点击的时候，根据动作，添加对应的信息
     */
    part.delegate("input","click",function () {
        getSon( $(this).val() );
    })
    /**
     * 在刚开始的时候，检验那些已经被选择了
     */
    $("#part input").each(function  () {
        if(this.checked){
            getSon( $(this).val() );
        }
    })
    /**
     * 得到list数组中当前节点的子元素get son ,添加到dom中
     */
    function getSon (text) {
        //清空之前添加的，防止错误
        if(tempk)$("#kk").detach();
        if (temp)$("#kj").detach();
        $.each(list,function  (key,value) {
            if(key == text){
                flag = 1;
                if (temp)  $("#kj").detach();
                temp = "<p id = 'kj'><span class = 'item'>"+text+"</span>";
                for(var keyj in value){
                    temp+="<input type = 'radio' name = 'keyj' value = "+keyj+"><span>"+keyj+"</span>";
                }
                temp+="<input type = 'radio' name = 'keyj' value = '其他'><span>其他</span>";
                temp+="</p>";
                part.after(temp);
                $("#kj").delegate("input","click",function  () {
                    text = $(this.nextSibling).text();
                    if(tempk)$("#kk").detach();
                    $.each(value,function  (keyj,vj) {
                        if(text == keyj){
                            vj = decodeURI(vj).split(",");
                            tempk="<p id = 'kk'><span class = 'item'>"+keyj+"</span>";
                            for (var k = 0,len = vj.length;k<len;k++) {
                                tempk+="<input type = 'radio' name = 'keyk' value = "+vj[k]+"><span>"+vj[k]+"</span>";
                            }
                            tempk+="<input type = 'radio' name = 'keyk' value ='其他' ><span>其他</span>";
                            tempk+="</p>";
                            $("#kj").after(tempk);
                            return;
                        }
                    })
                })
                return;
            };
        })
    }
}
/*
 *添加对应的属性,对应的对象为property
 */
function proAdd () {
    var pro = $("#pro"),ichose = $("#ichose"),vpar;
    //vpar 目前是指proVal的下一级别table
    var proBl = $(".proBl").clone();
    var tr = "<tr ><td><input type = 'text' name = 'proVal' class = 'liVal' placeholder = '红色XL等属性值'></td><td><a class = 'choseImg' href = '#'>选择图片</a></td><td><a class = 'uploadImg' href = 'javascript:javascript'>上传图片</a></td><td><img class = 'chosedImg' /></td></tr>"
    $(".proK").change(function(){
        //复制第二个属性框
        $(".proBl").after(proBl);
        proBl = null;
        $(this).unbind("change");
    });
    /**
     * 在input text focus的时候，添加input text
     * 只有在当前节点是最后一个的时候，空白节点只有一个的时候，添加
     */
    pro.delegate(".liVal","focus",function(event){
        vpar = this.parentNode.parentNode.parentNode;//vpar 是tr节点
        var sonli = $(vpar).find(".liVal");
        var cnt = 0;
        for (var i = 0, l = sonli.length; i < l; i ++) {
            if( ! $.trim( $(sonli[i]).val() ) ){
                cnt++;
            }
        }
        if(cnt < 2)  $(vpar).append(tr);
    }).delegate(".uploadImg","click",function(event){
        //添加图片
        var src = $(this).attr("class");
        vpar = this.parentNode.parentNode;
        vpar = $(vpar).find(".chosedImg");
        destoryImg( $(vpar).attr("src") );      //如果之前上传图片的话，销毁
        objThumb.self.fadeIn();                 //传入框显示
        objThumb.set( property.afterLoad );     //设置回调函数
        event.preventDefault();
    });
    this.afterLoad = function (ans) {
        $(vpar).attr("src",ans);
        objThumb.self.fadeOut();
    }
    /**
     * 选择图片，choose img
     * vpar li 就是img和span共同的父亲
     * @todo 是否允许选择图片，另说
     */
    ichose.delegate("img","click",function(event){
        //src = event.srcElement;
        src = $(this).attr("src");
        console.log(src);
        //src = $(src).attr("src");
        $(vpar).find(".chosedImg").attr("src",src);
        ichose.fadeOut();
    });

}
/**
 * 处理上传1：1的主图的商品
 */
function mainThum() {
    var main = $("#main");
    $("#mainInput").click(function () {
        main.fadeIn();
        $("#mainImg").load(function (event) {
            //这里需要读取上传完毕之后的值,通过iframe加载完毕之后，
            var ans =  getElementByIdInFrame(document.getElementById("mainImg"),"value");
            ans = $.trim($(ans).val());
            if(ans){
                var toImg = $("#toImgMain");
                destoryImg( toImg.attr("src") );        //如果之前有图片的话，发送请求删除，;
                toImg.attr("src" , ans);            //添加新的图片
                main.fadeOut();
            }
        })
    }) }
/**
 * 对用户输入的图片然后又决定抛弃的图片，进行删除
 * 无论是否成功，都不再报错返回
 */
function destoryImg(name) {
    if(name ){
        //将名字发送过去
        var url = site_url + "/upload/imgDelete/" + name.substr(name.lastIndexOf("/") + 1);
        $.get(url,function (data,textStatus) {
            console.log(data);
            console.log("yes");
        })
    }
}
/**
 * 对上传东西,选择图片，等需要全屏的操作关闭的控制
 */
function displayHandle() {
    $("body").delegate(".close","click",function (event) {
        //考虑到弹出窗口的结构特点，祖父是弹出的跟节点
        var node = this.parentNode.parentNode;
        $(node).fadeOut();
        event.preventDefault();
    })
}
/**
 * 取得iframe中的节点的元素
 */
function getElementByIdInFrame(objFrame,idInFrame) {
    var obj;
    if(objFrame.contentDocument)obj = objFrame.contentDocument.getElementById(idInFrame);
    else if(objFrame.contentWindow) obj = objFrame.contentDocument.getElementById(idInFrame);
    else obj = objFrame.document.getElementById(idInFrame);
    return obj;
}
/**
 * 添加商品对应的库存和价格
 */
function store() {
    var reg = /^http\:\/\//;//如果是url的形式，则是图片，否则是文字
    $("#storeNum").focus(function(){
        var flag = 0,table;
        var cntkey = 0;
        // proKey提高到全局变量的级别
        $(".proBl").each(function(){
            var ans =  new Array(
                new Array(),new  Array()
            );
            var temp = $.trim($(this).find("input[name = 'proKey']").val()),temp;
            if(temp){
                prokey[cntkey++] = temp;
                var proVal = $(this).find("input[name = 'proVal']");
                var proImg = $(this).find(".chosedImg");
                var tmpVal,tmpImg,cnt = 0;
                for (var i = 0, l = proVal.length; i < l; i ++) {
                    tmpVal = $.trim($(proVal[i]).val());
                    tmpImg = $.trim($(proImg[i]).attr("src"));
                    if(tmpVal){
                        ans[0][cnt] = tmpVal;
                        ans[1][cnt] = tmpImg;
                        cnt++;
                    }
                }
            }
            if((flag == 0)&&(ans[0].length)){
                proans[flag] = ans;//保存到全局变量，以便提交
                console.log(proans);
                table = getTab(ans);//还是需要做一个单独的header
                flag++;
            }else if((flag == 1)&&(ans[0].length)){
                proans[flag] = ans;//将ans保存到全局变量中
                flag++;
                var temp = "";
                for(var i = 0,len = ans[0].length;i < len;i++){
                    if(ans[1][i]){
                        td = "<td>"+ans[0][i]+"<img src = "+ans[1][i]+" />"+"</td>";
                    }else{
                        td = "<td>"+ans[0][i]+"</td>";
                    }
                    temp += "<tr>"+td+"<td>"+table+"</td>"+"</tr>";
                }
                table = temp;
            }
        });
        if(flag  == 2){
            var temp = "<table border = '1'><tr><td>"+prokey[1]+"</td><td><table><tr><th class = 'attrB'>"+prokey[0]+"</th><th class = 'intxt'>库存</th><th class = 'intxt'>价格</th></tr></table></td></tr>"+table+"</table>";
            table = temp;
        }else if(flag == 1){
            var temp = "<table ><tr><td><table><tr><th class = 'attrB'>"+prokey[0]+"</th><th class = 'intxt'>库存</th><th class = 'intxt'>价格</th></tr></table></td></tr></table>"+table;
            table = temp;
        }
        console.log(prokey);
        var store = $("#store");
        store.empty();
        store.append(table);
        store.slideDown();
    })
    function getTab(index) {
        //将table做好，如果有第二个属性的话，就将它包含在一个td内部
        var price = $.trim($("#sale").val());
        if(price.length == 0){
            price = $.trim($("#price").val());
        }
        var res = "<table class = 'valTr'>";
        var ps = "<td><input type = 'text' name = 'store'/></td><td><input type = 'text' name = 'sprice'  value = '"+price+"' /></td>";
        //如果之前输入了价格，则在这里输入价格
        for (var i = 0,len = index[0].length;i<len;i++) {
            if(index[1][i])
                res+="<tr class = 'trnd'><td class = 'attrB'>"+index[0][i]+"<img src = '"+index[1][i]+"' /></td>"+ps+"</tr>";
            else{
                res+="<tr class = 'trnd'><td class = 'attrB'>"+index[0][i]+"</td>"+ps+"</tr>";
            }
        }
        res+="</table>";
        return res;
    }
}
/**
 * 用来上传选择商品的1-6个缩略图
 */
function funoimgUp () {
    var six = 6,ochose = $("#ochose"),oimg = $("#thumbnail");//这些算是个优化了，不用第二次进行dom检索
    $("#thumbButton").click(function () {
        console.log("abc");
        objThumb.self.fadeIn();
        objThumb.set( objImgSix.count );//这里要不要使用子函数呢？
    })
    //尚未检测
    this.count = function (imgUrl) {
        oimg.append("<img src = '"+imgUrl+"' />");
        ( six > 1 ) ? (six -- ) : ochose.fadeOut() ;
    }
    /* 下面的函数应该是要被抛弃了 */
    ochose.delegate("img","click",function(){
        var src = $(this).attr("src");
        oimg.append("<img src = '"+src+"' />");
        six >= 1 ? ochose.fadeOut() : ( six-- );
        //if(six == 0) ochose.fadeOut();
    })
}
/**
 * 控制缩略图的上传
 * 供属性和缩略图两个地方调用
 */
function thumbnailUpload() {
    var $this = this;
    $this.self = $("#oimgUp");//上传的显示区域,方便在外部控制
    $this.callback = null;
    $this.set = function (callfunc) {
        //修改对应的回调函数
        $this.callback = callfunc;
    }
    var reg = /^http\:\/\//;//传回的值，必须是图片才可以
    $("#uploadImg").load(function(){
        var ans =  getElementByIdInFrame(document.getElementById("uploadImg"),"value");
        ans= $.trim($(ans).val());
        if(reg.exec(ans)){
            $this.callback(ans);
            /*
            oimg.append("<img src = '"+ans+"' />");
            six >= 1 ? ochose.fadeOut() : ( six-- );
            */
        }
    })
}
