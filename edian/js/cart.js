/*************************************************************************
  > File Name :  ../js/cart.js
  > Author  :      unasm
  > Mail :         douunasm@gmail.com
  > Last_Modified: 2013-09-18 20:53:02
 ************************************************************************/
/**
 * 尽量减少和外界的瓜葛,这里的耦合太多了,目前将这个做成一个插件
 */
var totalPrc = 0;
function alogin(){
    var cart = $("#cart");
    var atten = $("#atten");
    atten.text("购物车");
    atten.click(function(){
        cart.slideToggle();
    });
    getCart();
    $("#order").delegate(".del","click",function(event){
        var href = $(this).attr("href");
        ajOper(href,delCart,this);
        event.preventDefault();
    }).delegate("input","change",function(){
        //console.log(this);//在变化的时候，修改总和
        calTot();
    });
    $(".afli").css("display","none");
}
/**
 * 删除购物车的内容
 */
function delCart(node){
    while(node && ($(node).attr("tagName") != "LI")){
        node = node.parentNode;
    }
    if(node){
        $(node).detach();
        $.alet("删除成功");
    }
    calTot();
}
//对于通过ajax的get操作，而没有什么特殊的返回值的操作通用
function ajOper(href,callback,node){
    $.ajax({
        url: href,
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            if(data){
                callback(node);
                //$.alet(quote);
            }else{
                $.alet("失败了");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $.alet("失败了");
        }
    });
}
/**
 * 通过ajax传递过来的购物车内容
 * info 是数组，第一个是订货量，第二个选择的属性，有0-2个,格式为X：1232.jpg，前面是汉字，后面是图片名称
 * item 是商品本身的一些东西，包括买家，图片，库存，标题
 * item_id 商品编号，
 * id 订单号码
 * seller 但是目前不太想用
 */
function getCart(){
    //获取购物车的内容,只有在登录的情况下可以哦
    var href = ;
    $.ajax({
        url: site_url+"/order/index/1" ,
        type: 'POST', dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            var cart = data["cart"];
            console.log(data);
            var reg = /\d+\.jpg/;
            var buyer = data["buyer"],info,buyNum,item,now,strtal = "";
            var cap = "";
            var cal  = 0;
            lsp = data["lsp"];
            for(var i = 0,l = cart.length;i < l;){
                var lastSeller =  cart[i]["seller"];
                var captmp = 0;
                var slIdx = i;
                var str = "";
                while((i < l) && (lastSeller == cart[i]["seller"])){
                    now = cart[i];
                    info = now["info"];
                    item = now["item"];
                    buyNum = info["orderNum"];
                    img = item["img"].split("|");
                    img = img[0];
                    var price = info["price"];
                    //价格有两种，一种是全部的总价，一种是分类的价格，尽量使用item，子类的价格，不行的话，使用总的价格
                    if(!price){
                        price = item["price"];
                    }
                    captmp+= parseInt(price) * parseFloat(buyNum) ;
                    img = base_url+"thumb/"+img;
                    str += "<li ><a href = '"+site_url+"/item/index/"+now["item_id"]+"' class = 'igar'><img src = '"+img+"' / ></a><div class = 'botOpr'><span name = '"+price+"' class = 'btp'>￥"+price+"</span>x<input type = 'text' name = 'ordNum' value = "+buyNum+" class = '"+now["id"]+"' /><p><a class = 'del' href = '"+site_url+"/order/del/"+now["id"]+"' >删</a></p></div><div class = 'botAtr'>"+info["info"]+"</div></li>";
                    i++;
                }
                lsp[cal]["lestPrc"] = parseInt(lsp[cal]["lestPrc"]);
                if(lsp[cal]["lestPrc"] && (captmp < lsp[cal]["lestPrc"])){
                    totalPrc += (2+captmp);//totalprc 必须是数字;
                    captmp = "(2+"+captmp+")";
                }else{
                    totalPrc +=captmp;
                }
                if(!cap){
                    cap += "￥"+captmp;
                }else{
                    cap += "+￥"+captmp;
                }
                if(lsp[cal]["lestPrc"] != "0"){
                    spanPrc = "<span class = 'rt'>起送价:"+lsp[cal]["lestPrc"]+"</span>";
                }else{
                    spanPrc = "<span class = 'rt'>无起送价</span>";
                }
                strtal += "<div class = 'sel clearfix' name = '"+lsp[cal]["user_id"]+"'><p><a href = "+site_url+"/space/index/"+lsp[cal]["user_id"]+">店家:"+lsp[cal]["user_name"]+"</a>"+spanPrc+"</p>"+str+"</div>";
                cal++;
            }
            $("#cap").text(cap).attr("name",totalPrc);
            //在cap中保存总价格表信息，和显示的格式信息,totalprc表示总价，cap表示显示出来的格式
            $("#order").append(strtal);
            /*****************开始添加用户的个人信息*********************/
            var len = buyer.length;
            if(len){
                for (var i = 0; i < len; i ++) {
                    temp = buyer[i];
                    if(($.trim(temp["phone"]))&&($.trim(temp["name"]))&&($.trim(temp["addr"]))){
                        str = "<div class = 'buton bcl'><a href = '"+site_url+"/order/index"+"'>去购物车</a></div>";
                        str += "<div><p class = 'addr' title = '"+temp["addr"]+"'>收货地址:"+temp["addr"]+"</p><p>手机:"+temp["phone"]+"</p></div>";
                        str +="<div class = 'buton ba'><a href = '"+site_url+"/order/set"+"' id = 'setDown' >e点下单</a></div>";
                        var addr = "<input type = 'hidden' name = 'addr' id = 'inaddr' value = '"+i+"' />";
                        $("#ordor").append(str).append(addr);
                        break;
                    }
                }
            }else{
                str = "<div class = 'buton'><a href = '"+site_url+"/order/index"+"'>去购物车</a></div>";
                $("#ordor").append(str);
            }
            order();//订单,在append之后，开始处理下单
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $.alet("拉取购物车失败");
        }
    });
}
/**
 * 点击下单的页面
 * e点下单的设定,既然可以点，就证明地址是全的，提交的时候，确定地址购买量和订单号就好，属性是之前设定好的，而且，加入购物车之后，不可以修改了，后台添加一个备注，e点下单就没有了,在具体购物车页面可以添加，这里就算了
 */
function order() {
    $("#setDown").click(function(event){
        var addr = $("#inaddr").val();
        var url = $(this).attr("href")+"/1";//添加ajax的标记
        //input buynum 的class者定成为订单号码，buynum为重新购买数目
        var inpNum = $("input[name = 'ordNum']");
        var buyNum,orderId;
        for (var i = 0, l = inpNum.length; i < l; i ++) {
            var temp = inpNum[i];
            if(i == 0){
                orderId = $(temp).attr("class");
                buyNum = $.trim($(temp).val());
            }else{
                buyNum += "&"+$.trim($(temp).val());
                orderId += "&"+$(temp).attr("class");
            }
        }
        if(!orderId){
            $.alet("无单可下哦");
            return false;
        }
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {"buyNums":buyNum,"orderId":orderId,"addr":addr},
            success: function (data, textStatus, jqXHR) {
                $.alet("下单成功");
                $("#cart").empty();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                debugger;
                $.alet("下单失败了");
            }
        })
        url = site_url+"/order/setPrint";
        $.ajax({
            //设置打印，不反馈
            url: url,
            type: 'POST',
            data: {"buyNums":buyNum,"orderId":orderId,"addr":addr},
            success: function (data, textStatus, jqXHR) {
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                console.log(jqXHR);
            }
        });
        url = site_url+"/order/setPrint"
        event.preventDefault();
    })
}
function calTot() {
    //计算添加或者是减去后商品的总和，修改到总和#cap上
    //将添加商品和计算总和分开
    var sel = $("#order").find(".sel");
    var cap = "",totalPrc = 0;//flag表示购物车有没有找到和当前用户相同的
    for (var i = 0, lig = sel.length; i < lig; i ++) {
        var temp = sel[i];
        var captmp = 0;// 计算临时的价格,每家店的商品综合
        var btpr = $(temp).find(".btp");
        var num = $(temp).find("input[name = 'ordNum']");
        for (var j = 0, l = btpr.length; j < l; j ++){
            captmp += parseFloat($(btpr[j]).attr("name"))*parseInt($(num[j]).val());
            //必须转化成为数字或者是浮点数
        }
        if(captmp == 0)continue;//为0的情况下则不在添加显示
        if(lsp[i]["lestPrc"] && (captmp < parseInt(lsp[i]["lestPrc"])) ){
            totalPrc += (2+captmp);//totalprc 必须是数字;
            captmp = "(2+"+captmp+")";
        }else{
            totalPrc += captmp;
        }
        if(!cap){
            cap += "￥"+captmp;
        }else{
            cap += "+￥"+captmp;
        }
    }
    $("#cap").text(cap).attr("name",totalPrc);
}

//向购物车中添加新的商品,添加的备注，图片，价格，还有返回的信息，添加的商品号码
function appNewItem(data,img,info,price,itemIdApp,buyNum) {
    info = info?info:"";
    if(buyNum == undefined )buyNum = 1;//没有添加的情况下默认为1
    var sel = $("#order").find(".sel"),name,flag = 1;
    //var img = $("#mImg").attr("src");//缩略图的图片
    var str = "<li class = 'clearfix'><a href = '"+site_url+"/item/index/"+itemIdApp+"' class = 'igar'><img src = '"+img+"' /></a><div class = 'botOpr'><span class = 'btp' name = '"+price+"'>￥"+price+"</span>x<input type = 'text' name = 'ordNum' value = "+buyNum+"  class = '"+data["flag"]+"'/><p><a class = 'del' href = '"+site_url+"/order/del/"+data['flag']+"' >删</a></p></div><div class = 'botAtr'>"+info+"</div></li>";
    for (var i = 0, l = sel.length; i < l; i ++) {
        name = $(sel[i]).attr("name");
        if(name == masterId){
            //如果找到相同的店家，则添加进入
            $(sel[i]).append(str);
            flag = 0;//表示找到了店家
            break;
        }
    }
    if(flag){
        //为1，表示没有找到,现在去添加
        var prc = "";
        if(lestPrc != "0"){
            prc = "<span class = 'rt'>起送价:"+lestPrc+"</span>";
        }else{
            prc = "<span class = 'rt'>无起送价</span>";
        }
        $("#order").append("<div class = 'sel clearfix' name = '"+masterId+"'><p><a href = '"+site_url+"/space/index/"+masterId+"' >店家:"+masterName+"</a>"+prc+"</p>"+str+"</div>");
        //添加数组，为之后的继续添加准备，虽然一般情况下是不需要的
        var temp = Object();
        temp["lestPrc"] = lestPrc;
        temp["user_name"] = masterName;
        temp["user_id"] = masterId;
        lsp[lsp.length] = temp;
    }
}
/**
 * 对info进行编码
 * 目前只是在sendord中调用了
 */
function deinfo(str) {
    if(str){
        var temp = str.split("|");
        var res = "",now;
        for (var i = 0, l = temp.length; i < l; i ++) {
            now = temp[i].split(":");
            if(i == 0){
                res+=now[0];
            }else{
                res+="|"+now[0];
            }
        }
        return res;
    }
    return false;
}
/**
 * 发送订单,加入购物车,det中 fmIf调用
 * @param {node} buyNum 向dom input 中读取购买数量
 * @param {node} attr   将属性信息保存到dom 中？
 */
function sendOrd(){
    var info = $("#info").val();
    info  =  deinfo(info);
    var buyNum = $("#buyNum").val();
    //var reg = /http\:\/\/[\/\.\da-zA-Z]*\.jpg/;
    var  cartHref = site_url+"/order/add/"+itemId;
    $.ajax({
        url: cartHref,
        type: 'POST',
        data: {"info":info,"buyNum":buyNum},
        dataType:'json',
        success: function (data, textStatus, jqXHR) {
            console.log(data);//目前就算了吧，不做删除的功能,返回的id是为删除准备的
            if(data["flag"]){
                $.alet("成功加入购物车");
                //添加到表单之中
                appNewItem(data,$("#mImg").attr("src"),info,price,itemId,buyNum);
                //计算总和
                calTot();
            }else{
                $.alet(data["atten"]);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $.alet("加入购物车失败");
        }
    });
}

/**
 * 对attr中的库存价格，显示控制
 */
function attrControl() {
    attr = eval(attr);//对全局变量进行解析
    var faAttr = $(".attr");
    var posx  = -1,valuex,posy = -1,valuey;
    faAttr.delegate(".attrValue" , 'click' , function (event) {
        var parNode = this.parentNode;
        //进行选择框的切换
        $(parNode).find('.atvC').removeClass('atvC');
        $(this).addClass("atvC");
        var pos = $(parNode).attr("alt");
        if(parseInt(pos,10) === 0 ){
            posx = $(this).attr("alt");
            valuex = $(this).attr("title");
        } else {
            posy = $(this).attr("alt");
            valuey = $(this).attr('title');
        }
        if ( ( posx !== -1 ) && ( posy !== -1 ) && faAttr.length === 2){
            setAttrData();
        } else if( (faAttr.length === 1 ) && ( posx !== -1 ) ){
            setAttrData();
        }
    })
    //将晚上属性的添加，将对应的价格和库存修改
    function setAttrData(){
        if(faAttr.length === 1){
            console.log(attr[posx]);
            var sp = attr[posx];
            $("#info").val(valuex);
        }else if(faAttr.length === 2){
            $("#info").val(valuex + '|' + valuey);
            var sp = attr[posx][posy];
        }
        $("#price").text(sp.prc);
        $("#tS").text(sp.store);
    }
}


