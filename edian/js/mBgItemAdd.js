var prokey = new  Array(),proans =  new Array();
function forbid() {
    //处理禁止输入字符的问题
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
    $(".part input").last().click(function  () {
        alert("抱歉，让您选择\"其他\"是我们分类的不够细致，请联系管理员"+admin+"帮忙");
    })
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
       var oimg = $("#oimg").find("img");
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
    proAdd();
    store();
    funoimgUp();
})
function part (list) {
    var part = $("#part"),temp,tempk = null,flag = 0;
    part.delegate("input","click",function () {
        var texts = $(this.nextSibling).text();
        getSon(texts);
    })
    $("#part input").each(function  () {
        if(this.checked){
            getSon($(this.nextSibling).text());
        }
    })
    function getSon (text) {
        if(tempk)$("#kk").detach();
        if (temp)$("#kj").detach();//清空之前添加的，防止错误
        $.each(list,function  (key,value) {
            if(key == text){
                flag = 1;
                if (temp) {
                    $("#kj").detach();
                }
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
function proAdd () {
    //要禁止输入标点符号
    var pro = $("#pro"),ichose = $("#ichose"),vpar;
    //vpar 目前是指proVal的下一级别table
    var proBl = $(".proBl").clone();
    var tr = "<tr ><td><input type = 'text' name = 'proVal' class = 'liVal' placeholder = '红色XL等属性值'></td><td><a class = 'choseImg' href = 'javascript:javascript'>选择图片</a></td><td><a class = 'uploadImg' href = 'javascript:javascript'>上传图片</a></td><td><img class = 'chosedImg' /></td></tr>"
    $(".proK").change(function(){
        //复制第二个属性框
        console.log("changeing");
        //如果可以的话，这些after希望都通过clone的方法,这个将来直接加入到dom中算了,不用再
        $(".proBl").after(proBl);
        $(this).unbind("change");
    });
    var reg = /^http\:\/\//,flag = 0;//如果是url的形式，则是图片，否则是文字
    pro.delegate(".liVal","focus",function(event){
        //在input text focus的时候，添加input text
        vpar = this.parentNode.parentNode;
        $(vpar).after(tr);
    }).delegate("a","click",function(event){
        //添加图片
        //var ele = event.srcElement;//被点击的元素
        var src = $(this).attr("class");
        vpar = this.parentNode.parentNode;
        if(src === "choseImg"){
            ichose.fadeIn();
        }else if(src == "uploadImg"){
            $("#ifc").fadeIn();
            if(flag == 0){
                flag = 1;
                //flag好像定义了，但是没有使用
                $("#uploadImg").load(function (event) {
                    //            这里需要读取上传完毕之后的值,通过iframe加载完毕之后，读取路径,怎么判断，明天上网搜
                    var ans =  getElementByIdInFrame(document.getElementById("uploadImg"),"value");
                    ans = $.trim($(ans).val());
                    if(reg.exec(ans)){
                        $(vpar).find(".chosedImg").attr("src",ans);
                        $("#ifc").fadeOut();
                    }
                })
            }
        }
    });
    ichose.delegate("img","click",function(event){
        //vpar li 就是img和span共同的父亲
        //src = event.srcElement;
        src = $(this).attr("src");
        console.log(src);
        //src = $(src).attr("src");
        $(vpar).find(".chosedImg").attr("src",src);
        ichose.fadeOut();
    });
    /*
     * 好像是没有什么用处
    $("#storeNum").focus(function(){
        var val = $(this).val();
        console.log(val);
    })
    */
    $(".close").click(function(){
        //考虑到弹出窗口的结构特点，祖父是弹出的跟节点
        var node = this.parentNode.parentNode;
        $(node).fadeOut();
    })
}
function getBroByClass  (node,cla) {
    //取得兄弟节点,修改同一组的img src
    var bro = node.nextSibling;
    console.log(bro);
}
function getElementByIdInFrame(objFrame,idInFrame) {
    //获得iframe中的元素
    var obj;
    if(objFrame.contentDocument)obj = objFrame.contentDocument.getElementById(idInFrame);
    else if(objFrame.contentWindow) obj = objFrame.contentDocument.getElementById(idInFrame);
    else obj = objFrame.document.getElementById(idInFrame);
    return obj;
}
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
function funoimgUp () {
    var reg = /^http\:\/\//;//如果是url的形式，则是图片，否则是文字
    var six = 6,ochose = $("#ochose"),oimg = $("#oimg"),oimgUp = $("#oimgUp");//这些算是个优化了，不用第二次进行dom检索
    //这个是用来上传多余的6张图片的
    oimg.delegate("a","click",function(){
        var dir = $(this).attr("class");
        if(six<=0)return false;
        if(dir == "choseImg"){
            ochose.fadeIn();//ochose会在其他的地方更多的使用
        }else{
            oimgUp.fadeIn();
        }
        if(six == 6){
            //只有在最初的一次添加监听load事件
            ouploadImg.load(function(){
                var ans =  getElementByIdInFrame(document.getElementById("ouploadImg"),"value");
                ans= $.trim($(ans).val());
                if(reg.exec(ans)){
                    oimg.append("<img src = '"+ans+"' />");
                    six--;
                    if(six == 0){
                        oimgUp.fadeOut();
                    }
                }
            })
        }
    });
    var ouploadImg = $("#ouploadImg");
    ochose.delegate("img","click",function(){
        var src = $(this).attr("src");
        oimg.append("<img src = '"+src+"' />");
        six--;
        if(six == 0)
            ochose.fadeOut();
    })
}
