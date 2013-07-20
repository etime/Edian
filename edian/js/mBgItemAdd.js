$(document).ready(function  () {
    var value,NoImg = 1,doc = document;
    dir = eval(dir);
    $(".part input").last().click(function  () {
        alert("抱歉，让您选择\"其他\"是我们分类的不够细致，请联系管理员"+admin+"帮忙");
    })
    //$(".price").blur(function  () {
        //$(this).unbind("keypress");
    //}).focus(function  (event) {
        //$(this).keypress(function  (event) {
            //if((event.which<46)||(event.which>57)){
                //return false;
            //}
        //})
    //})
    $("#content").delegate(".price","focus",function(){
        $(this).keypress(function  (event) {
            if((event.which<46)||(event.which>57)){
                return false;
            }
        })
    }).delegate(".price","blur",function(){
        $("#content").unbind("keypress");
    })
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
        /*
        value = $.trim($("input[type = 'file']").val());
        if((value.length==0)&&(NoImg == 1)){
            NoImg = 0;//第一次见到之后，就去掉这个提示
            alert("忘记添加图片，如果确实不需要图片，再次点击发表即可");//这里或许给出一些改进
            return false;
        }
        */

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
    var pro = $("#pro"),ichose = $("#ichose"),vpar;
    var proBl = $(".proBl").clone();
    var liImg = "<li class = 'liImg'><span class = 'choseImg' href = 'javascript:javascript'>选择图片</span><span class = 'uploadImg' href = 'javascript:javascript'>上传图片</span><img class = 'chosedImg' /></li>"
    var liVal = "<li class = 'liVal'><input type = 'text' name = 'proVal'></li>"
    $(".proK").change(function(){
        console.log("changeing");
        //如果可以的话，这些after希望都通过clone的方法,这个将来直接加入到dom中算了,不用再
        $(".proBl").after(proBl);
        $(this).unbind("change");
    });
    var reg = /^http\:\/\//,flag = 0;//如果是url的形式，则是图片，否则是文字
    pro.delegate(".liVal","focus",function(event){
        $(this).after(liVal);
        vpar = this.parentNode.parentNode.parentNode;
        console.log(vpar);
        $(vpar).find(".ulPi").fadeOut();
    }).delegate(".ulPi li","click",function(event){
        var ele = event.srcElement;//被点击的元素
        var src = $(ele).attr("class");
        vpar = ele.parentNode;//li 元素
        $(vpar).after(liImg);
        var temp = vpar.parentNode.parentNode;
        $(temp).siblings(".proVal").fadeOut();
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
                    console.log(ans);
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
        src = event.srcElement;
        src = $(src).attr("src");
        $(vpar).find(".chosedImg").attr("src",src);
        ichose.fadeOut();
    });

    $("#storeNum").focus(function(){
        var val = $(this).val();
        console.log(val);
    })
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
    $("#store").delegate("li","click",function () {
        var last = $(this).siblings(".prochd");
        $(last).removeClass("prochd");
        var name = $(last).attr("name");
        var tab = document.getElementById("proTab"+name);
        $(tab).css("display","none");
        $(this).addClass("prochd");
        name = $(this).attr("name");
        tab = document.getElementById("proTab"+name);
        $(tab).css("display","table");//得到的必然是table元素
    })
    var reg = /^http\:\/\//;//如果是url的形式，则是图片，否则是文字
    $("#storeNum").focus(function(){
        var flag = 0;
        $(".proBl").each(function(){
        var ans = Array();
            var proK = $.trim($(this).find("input[name = 'proKey']").val()),temp;
            if(proK){
                var proVal = $(this).find("input[name = 'proVal']");
                proVal.each(function(){
                    temp = $.trim($(this).val());
                    if(temp){
                        ans[ans.length] = temp;//这里可以优化吗
                    }
                })
                if(ans.length == 0){
                    var proImg = $(this).find(".chosedImg");
                    proImg.each(function(){
                        var temp = $.trim($(this).attr("src"));
                        if(reg.exec(temp)){
                            //ans[ans.length] = temp;
                            ans[ans.length] = "<img src = '"+temp+"' />";
                        }
                    })
                }
            }
            if((flag == 0)&&(ans.length)){
                table = getTab(proK,ans);
                flag++;
            }else if((flag == 1)&&(ans.length)){
                temp = getUl(proK,ans);
                for (var i = ans.length - 1; i >= 0; i --) {
                    temp+=table;
                }
                table = temp;
            }
        });
        if(flag){
            var store = $("#store");
            store.empty();
            store.append(table);
            var pro2s = store.find(".pro2");
            for (var i = pro2s.length - 1; i >= 0; i --) {
                var temp = pro2s[i];
                console.log(temp);
                $(temp).attr("id","proTab"+i);
                if(i!=0){
                    $(temp).css("display","none");
                }
            }
            store.slideDown();
        }
    })
    function getUl(key,index) {
        var res = "<ul class = 'pro1'>";
        for (var i = index.length - 1; i >= 0; i --) {
            if(i!=0)
                res+="<li name = '"+i+"'>"+index[i]+"</li>";
            else res+="<li name = '"+i+"' class = 'prochd'>"+index[i]+"</li>";
        }
        res+="</ul>";
        return res;
    }
    function getTab(key,index) {
        var res = "<table class = 'pro2' name = '0'><td>"+key+"</td><td>库存量</td><td>价格</td>";
        var price = $.trim($("#sale").val());
        if(price.length == 0){
            price = $.trim($("#price").val());
        }
        var ps = "<td><input type = 'text' name = 'store'/></td><td><input type = 'text' name = 'sprice' class = 'price' value = '"+price+"' /></td>";
        //如果之前输入了价格，则在这里输入价格
        var reg = /^http\:\/\//,flag = 1;//如果是url的形式，则是图片，否则是文字
        if(reg.exec(index[0])){
            flag = 0;
        }
        for (var i = 0,len = index.length;i<len;i++) {
            if(flag == 0){
                res+="<tr><td><img src = '"+index[i]+"' /></td>"+ps+"</tr>";
            }else{
                res+="<tr><td>"+index[i]+"</td>"+ps+"</tr>";
            }
        }
        res+="<table>";
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