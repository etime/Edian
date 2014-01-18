/**
 * 决定下单的函数
 * 因为下单是在不同的函数进行的，所以需要做一个耦合很弱的文件做处理，提高复用性
 * 因为dom不是本文件生成的，所以必须对dom做一些约定
 * 1:属性，属性的文字必须是在class = attrValue中的alt中存储 , 其父元素，区分每种属性的dom的class的名字必须是attr，而且只能是attr，不能多， 选中的attr class必须是attrChose
 * 2:提交，提交的按钮无论是button 也好，input也好，name必须是toCart
 * 3:价格，价格的class必须是price
 * 一些使用的约定，
 * @name        ../js/cart2.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-01-17 14:32:39
*/
var objOrder = (function () {
    var $this = this;
    $this.details = false;
    //监听属性的选择
    $("body").delegate('.details' , 'click' , function (event) {
        $this.details = this;
        var target = event.target;
        var type = $(target).attr("class");
        if(type && type.indexOf('attrValue') !== -1){
            findAttrParent(target);
            $(target).addClass("attrChose");
        }
        type = $(target).attr("name");
        if(type && type === 'toCart'){
            event.preventDefault();
            sendOrd();
        }
    })
    //点击attr的时候，去除之前高亮框
    function findAttrParent(node) {
        var cls = '';
        while(node){
            cls = $(node).attr("class");
            if(cls == 'attr'){
                $(node).find(".attrChose").removeClass("attrChose");
                return node;
            }else {
                node = node.parentNode;
            }
        }
        return node;
    }
    /**
     * 添加商品到购物车
     * 想后台发送数据，并调用返回函数
     */
    function sendOrd() {
        var attrs = $($this.details).find(".attr");
        var atrstr = '';
        for (var i = 0, l = attrs.length; i < l; i ++) {
            var temp = $(attrs[i]).find(".attrChose").attr("alt");
            if(temp && temp != undefined){
                if(atrstr){
                    atrstr += '|'+ temp ;
                } else {
                    atrstr = temp;
                }
            } else {
                //$.alet("请选择具体类别");
                return false;
            }
        }
        console.log(atrstr);
        var buyNum = $($this.details).find("input[name = 'buyNum']").val();
        $.ajax({
            url: site_url + '/order/add/' + itemId,type: 'POST',
            data: {"info":atrstr,"buyNum":buyNum}, dataType:'json',
            success: function (data, textStatus, jqXHR) {
                console.log(data);//目前就算了吧，不做删除的功能,返回的id是为删除准备的
                if(data["flag"]){
                    //$.alet("成功加入购物车");
                    //添加到表单之中
                    appNewItem(data , '' , atrstr ,$( $this.details.find(".price").text() ), itemId, buyNum);
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
    getCart();
})();
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

/**
 * 发送订单,加入购物车,det中 fmIf调用
 * @param {node} buyNum 向dom input 中读取购买数量
 * @param {node} attr   将属性信息保存到dom 中？
 */
function sendOrd(attr , buyNum , img  , price){
    /*
    var info = $("#info").val();
    info  =  deinfo(info);
    var buyNum = $("#buyNum").val();
    */
    //var reg = /http\:\/\/[\/\.\da-zA-Z]*\.jpg/;
    var  cartHref = site_url+"/order/add/"+itemId;
    $.ajax({
        url: cartHref,
        type: 'POST',
        data: {"info":attr,"buyNum":buyNum},
        dataType:'json',
        success: function (data, textStatus, jqXHR) {
            console.log(data);//目前就算了吧，不做删除的功能,返回的id是为删除准备的
            if(data["flag"]){
                $.alet("成功加入购物车");
                //添加到表单之中
                appNewItem(data , img , attr ,price, itemId, buyNum);
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
