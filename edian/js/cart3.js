/**
 * @name        ../js/cart3.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-14 20:14:22
*/
$(document).ready(function () {
    $("body").append("<link rel='stylesheet' href=" + baseUrl + "/css/cart.css type='text/css' media='all' />");
    getCart();
})
/**
 * 获取购物车的内容,并构成相应的dom节点
 */
function getCart() {
    //如果用户有地址，就可以下单，返回字符串，不然的话，就隐藏下单按钮
    function formBuyer(buyer) {
        if(buyer.length >= 1){
            buyer = buyer[0];
            return "<div class = 'info'><p class = 'addr'>" + buyer['address']+ "</p><div class = 'buyer'><p>" +buyer['name']+ "</p><p>"+buyer['phone']+"</p></div></div>";
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
        for (var i = 0, len = cart.length; i < len; i ++) {
            var seller = cart[i]['seller'];
            re += "<div class = 'shop'>";
            re += "<p title = '店铺小计/最低起送价' class = 'tp'>";
            re +=       "<span class = 'cnt'><span class = 'cntNum'></span>/<span>" +lsp[cnt]['lestPrc']+ "</span></span>";
            re +=       "<input type = 'checkbox' name = 'chose' /><span>" + lsp[cnt]['user_name']+ "</span></p>";
            re += "<table class = 'clist' border = '1'>"
            while((i < len) && (seller === cart[i]['seller'])){
                var orderNode = cart[i];
                re += "<tr><td><input type = 'checkbox' name = 'tobuy[]' checked = 'checked' value = " + orderNode['id'] + '/></td>';
                re += "<td><img src = '" + orderNode['item']['mainThumbnail']+ "' </td>";
                re += "<td class = 'title'><p>" + orderNode['item']['title']+ "</p><p>" + orderNode['info']['info'] + "</p></td>"
                re += "<td><p class = 'sp'>￥<span class = 'price'>" + orderNode['item']['price']+ "</span></p> <p>x <input type = 'text' name = 'ordNum' value = '" + orderNode['info']['orderNum']+ "'</p></td>";
                i++;
            }
            re += "</table>"
            cnt++;
        }
        return re;
    }
    /**
     * 构成底部的控制区域
     */
    function formCon() {
        return "<div class = 'con'><div><p>共计<span>￥<strong id = 'total'></strong></span></p><p>查看详情</p></div><input type = 'submit' name = 'cart' value = '立即下单' /></div>";
    }
    $.ajax({
        url: site_url + '/order/index/1',
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            if(data){
                var str =  "<form action=" + site_url + '/order/setPrint' +" method='post' accept-charset='utf-8' id = 'dcart' class = 'dcart'>" + formBuyer(data['buyer']);
                str += formCart(data['cart'] , data['lsp']);
                str += formCon();
                str += "</form>";
                $('body').append(str);
                calTot();
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
/**
 * 计算添加或者是减去后商品的总和，修改到总和#cap上
 * 将添加商品和计算总和分开
 */
function calTot() {
    var sel = $("#dcart").find(".shop");
    var cap = "",totalPrc = 0;//flag表示购物车有没有找到和当前用户相同的
    for (var i = 0, lig = sel.length; i < lig; i ++) {
        var temp = sel[i];
        var captmp = 0;// 计算临时的价格,每家店的商品综合
        var chose = $(temp).find("input[name = 'tobuy[]']");
        var price = $(temp).find(".price");
        var num = $(temp).find("input[name = 'ordNum']");
        for (var j = 0, l = chose.length; j < l; j ++) {
            if($(chose[j]).attr('checked')){
                captmp += parseFloat($(price[j]).text()) *  parseInt($(num[j]).val());
            }
        }
        console.log(captmp);
        $(temp).find('.cntNum').text(captmp);
    }
    $("#cap").text(cap).attr("name",totalPrc);
}
