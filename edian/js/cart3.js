/**
 * 约定：库存和价格的信息通过name保存在form节点上面，attr是父节点，attrvalue是子节点，一切信息都在form内部通过class和name获得，
 * 想要加入购物车的商品必须被id = itemList 包裹
 * form中库存class为storeNum ,价格.price
 * 这样做是为了之后的列表那里方便，或者说是可行
 * @name        ../js/cart3.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-14 20:14:22
*/
$(document).ready(function () {
    $("body").append("<link rel='stylesheet' href=" + baseUrl + "/css/cart.css type='text/css' media='all' />");
    getCart();
    sendOrder();
})
/**
 * 获取购物车的内容,并构成相应的dom节点
 */
function getCart() {
    //如果用户有地址，就可以下单，返回字符串，不然的话，就隐藏下单按钮
    function formBuyer(buyer) {
        if(buyer.length >= 1){
            buyer = buyer[0];
            return "<div class = 'cinfo clearfix'><p class = 'addr'>" + buyer[2]+ "</p><div class = 'buyer'><p>" +buyer[0]+ "</p><p>"+buyer[1]+"</p></div></div>";
        } else{
            return false;
        }
    }
    /**
     * 这里构成购物车的主体，订单列表和店家信息
     * @param {array} cart  订单信息
     * @param {array} lsp   和cart对应的起送价信息
     * @todo 这两个数组的照应关系需要对应，一旦出问题就报错了。。或许可以试着在后台融合
     */
    function formCart(cart , lsp) {
        console.log(cart);
        var cnt = 0;
        var re = '';
        for (var i = 0, len = cart ? cart.length : 0; i < len; i ++) {
            var seller = cart[i]['seller'];
            re += "<div class = 'shop'>";
            re += "<p title = '店铺小计/最低起送价' class = 'tp'>";
            re +=       "<span class = 'cnt'><span class = 'cntNum'></span>/<span class = 'listPrc'>" +lsp[cnt]['lestPrc']+ "</span></span>";
            re +=       "<input type = 'checkbox' name = 'chose' /><span>" + lsp[cnt]['user_name']+ "</span></p>";
            re += "<table class = 'clist' border = '1'>"
            while((i < len) && (seller === cart[i]['seller'])){
                var orderNode = cart[i];
                re += "<tr><td><input type = 'checkbox' name = 'orderId[]' value = '" + orderNode['id'] + "' /></td>";
                re += "<td><a href ='" + site_url + '/item/index/' + orderNode['item_id'] + "' ><img src = '" + orderNode['item']['mainThumbnail']+ "' </a></td>";
                re += "<td class = 'title'><p><a href = '" + site_url + '/item/index/'+ orderNode['item_id'] + "' >" + orderNode['item']['title']+ "</a></p><p>" + orderNode['info']['info'] + "</p></td>"
                re += "<td><p class = 'sp'>￥<span class = 'price'>" + orderNode['item']['price']+ "</span></p> <p>x <input type = 'text' name = 'buyNums[]' value = '" + orderNode['info']['orderNum']+ "'</p></td>";
                i++;
            }
            re += "</table></div>"
            cnt++;
        }
        return re;
    }
    /**
     * 构成底部的控制区域
     */
    function formCon() {
        return "<div class = 'con clearfix'><div><p>共计<span>￥<strong id = 'total'></strong></span></p><p><a href='" + site_url +'/order/index' + "'>查看详情</a></p></div><input type = 'submit' name = 'cart' value = '立即下单' /></div>";
    }
    if(userId){
        getData();
    }
    function getData() {
        $.ajax({
            url: site_url + '/order/index/1',
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if(data){
                    var str =  "<form action=" + site_url + '/order/setPrint' +" method='post' accept-charset='utf-8' id = 'dcart' class = 'dcart'><div class = 'tohide' id = 'tohide' style = 'display:none'>" + formBuyer(data['buyer']);
                    str += formCart(data['cart'] , data['lsp']) + '</div>';
                    str += formCon();
                    str += "</form>";
                    $('body').append(str);
                    var box = $("#dcart").find("input[type = 'checkbox']");
                    for (var i = 0, l = box.length; i < l; i ++) {
                        $(box[i]).attr('checked' , true);
                    }
                    calTot();
                    showCartList();
                } else if(textStatus === 'success'){
                    console.log("请登录 ");
                } else {
                    console.log('向后台报告');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("向后台报告");
            }
        });
    }

}
/**
 * 控制菜单的显示和隐藏
 */
function showCartList() {
    var tohide = $("#tohide");
    $(".con").click(function () {
        tohide.slideToggle();
    })
}
/**
 * 计算添加或者是减去后商品的总和，修改到总和#cap上
 * 将添加商品和计算总和分开
 */
function calTot() {
    var dcart = $("#dcart");
    function count() {
        var sel = dcart.find(".shop");
        var cap = "",totalPrc = 0;//flag表示购物车有没有找到和当前用户相同的
        for (var i = 0, lig = sel.length; i < lig; i ++) {
            var temp = sel[i];
            var captmp = 0;// 计算临时的价格,每家店的商品综合
            var chose = $(temp).find("input[name = 'orderId[]']");
            var price = $(temp).find(".price");
            var num = $(temp).find("input[name = 'buyNums[]']");
            for (var j = 0, l = chose.length; j < l; j ++) {
                if($(chose[j]).prop('checked')){
                    captmp += parseFloat($(price[j]).text()) *  parseInt($(num[j]).val());
                }
            }
            $(temp).find('.cntNum').text(captmp);
            totalPrc += captmp;
        }
        $("#total").text(totalPrc).attr("name",totalPrc);
    }
    count();
    //当点击复选框的时候
    dcart.delegate('.shop' , 'click' , function (event) {
        var target = event.target;
        if($(target).attr('type') === 'checkbox'){
            var name = $(target).attr('name');
            if(name === 'chose'){
                var list = $(this).find("input[name = 'orderId[]']");
                var state = $(target).prop("checked");
                for (var i = 0, l = list.length; i < l; i ++) {
                    $(list[i]).prop('checked' , state);
                }
            }
            count();
        }
    })
}
/**
 * 向购物车添加东西
 */
function sendOrder() {
    //寻找.attrvalue的上级节点.attr
    function findAttr(node){
        node = node.parentNode;
        while(node && $(node).prop('class').indexOf('attr') === -1){
            node = node.parentNode;
        }
        return node;
    }
    /**
     * 检查attr时候都已经选择了
     * @param {node} node 节点，通常是form节点，检查节点下面的attr时候都已经选择了
     */
    function checkAttr(attr) {
        var flag = 1;
        for (var i = 0, l = attr.length; i < l; i ++) {
            if(!$(attr[i]).find(".attrChose"))flag = 0;
        }
        return flag;
    }
    $("#itemList").delegate("form" , 'click' ,function (event) {
        var name = $(event.target).prop('class');
        event.preventDefault();

        //对应库存的修改, 价格。。也要加入进去
        if(name.indexOf('attrValue') !== -1){
            var node = findAttr(event.target);
            $(node).find(".attrChose").removeClass('attrChose');
            $(event.target).addClass('attrChose');
            var attr = $(this).find(".attr");
            if(checkAttr(attr)){
                var storePrc = eval( $(this).attr('name') );
                var name = [];
                for (var i = 0, l = attr.length; i < l; i ++) {
                    name[i] = $(attr[i]).find(".attrChose").attr('name');
                }
                if(name.length === 1){
                    $(this).find('.store').text( storePrc[name[0]]['store'] );
                    $(this).find('.price').text( storePrc[name[0]]['prc'] );
                } else if(name.length === 2){
                    //看到具体的格式再解析
                }
            }
        } else if(name.indexOf('toCart') !== -1){

            var attr = $(this).find(".attr");
            if(checkAttr(attr)){
                if(!userId){
                    alert("请首先登录，如果确认登录，请刷新页面");
                    login(send);
                    //$.alet("请登录");
                    return;
                }
                var info = '';
                if(attr.length === 2){
                    info = $(attr[0]).find(".attrChose").prop('alt') + '|' + $(attr[0]).find('.attrChose').prop('alt');
                } else if(attr.length === 1){
                    info = $(attr[0]).find(".attrChose").prop('alt');
                }
                send($(this).prop('action') , info , $(this).find("input[name = 'buyNum']").val());
            }
        }
    })

}
/**
 * 向后台发送数据
 * @todo  一定时间内拒绝操作，防止机器
 */
function send(href,info,buyNum) {
    $.ajax({
        url: href,
        type: 'POST',
        dataType: 'json',
        data: {'buyNum' : buyNum , 'info' : info },
        success: function (data, textStatus, jqXHR) {
            //要提供一个好的反馈，让用户明白自己下单成功
            //添加成功之后的处理。。。有点复杂呢

            console.log(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }
    });
}
