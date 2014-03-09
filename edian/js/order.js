/*************************************************************************
    > File Name :  ../../js/order.js
    > Author  :      unasm
    > Mail :         douunasm@gmail.com
    > Last_Modified: 2014-03-09 10:47:03
    //之前计算总和，是通过保存数组进行的，目前还是实验一下从dom加吧，这样更容易维护一点。
 ************************************************************************/
jQuery.alet = function (cont) {//给出各种提示的函数，和alert不同，这个过1s就消失
    var alet = document.createElement("div");
    var p = document.createElement("p");
    var css = {
        width:'200px'
    };
    $(alet).css(css);
    css = {
        position:'absolute',
        padding:'15px',
        background:'#000',
        top:$(window).scrollTop()+100+"px",
        left:$(document).width()/2-100+"px",
        margin:'0 auto',
        "border-radius":"5px",
        color:"white",
        "z-index":"20"
    }
    $(p).css(css);
    $(p).text(cont);
    $(alet).append(p);
    $("body").append(alet);
    setTimeout(function  () {
        $(alet).detach();
    },3999);
}
//var cal = Array(),price = Array();
//var calAl = $("#calAl");//这里是总价格的表示node
$(document).ready(function(){
    click();
    add();
    sub();//提交的时候的操作
    forbid();
    calAll();
})
/**
 * 禁止在备注中输入的字符
 * @todo 目前在我电脑，测试失效，在其他的电脑看一下吧
 */
function forbid() {
                //  !,//                , * ,/,                ?     [, ]       ^,_
    var forbiden = [33,34,35,36,37,38,39,42,47,58,59,60,61,62,63,64,91,93,94,95,96,123,124,125,126];
    //上面 应该只是允许输入（）-,
    $(document).delegate("textarea","keypress",function(event){
        var value = event.which;
        for (var i = 0, l = forbiden.length; i < l; i++) {
            if(value === forbiden[i]){
                event.preventDefault();
                break;
            }
        }
    })
}
/**
 * 跟收件人地址和通讯方式有关的都在这里
 * @param {node } adiv 地址选择的总dom区域
 * @param {node}  addr 将选择的地址保存到dom中，应该是一个input，值是一个数字
 * @param {node}  nad  new addrress 添加新的地址的时候，用到的
 */
function add(){
    var adiv = $("#adiv"),addr = $("#addr");
    adiv.delegate(".addr","click",function () {
        adiv.find(".addCse").removeClass("addCse");
        $(this).addClass("addCse");
        //如果这里不是需要新添加的值，而是旧的就可以
        if(!$(this).find("textarea")){
            debugger;
            val = $(this).attr("name");
            addr.val(val);
        }
    })
    var nad = $("#nad");
    nad.find("input[type = 'button']").click(function (event) {
        var geter = $.trim( nad.find("input[name = 'geter']").val() );
        var addr = $.trim( nad.find("textarea").val() );
        var phone = $.trim( nad.find("input[name = 'phone']").val() );
        if(geter && addr && (phone.length === 11 )){
            nad.find("input[name = 'geter']").val('');
            nad.find('textarea').val('');
            nad.find("input[name = 'phone']").val('');
            $.ajax({
                url:  site_url + '/order/addr/',
                type: 'POST',dataType: 'json',
                data: {"addr":addr,"geter":geter,"phone":phone},
                success: function (data, textStatus, jqXHR) {
                    if(data["flag"]){
                        var str = "<div class = 'fir'><span>"+geter+"</span>(收)<span>"+phone+"</span></div><div>"+addr+"</div><span class = 'aten'>收货地址</span>";
                        nad.empty().append(str);
                    }else{
                        $.alet(data["atten"]);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.alet("添加地址失败,请联系客服");
                }
            });
        } else {
            $.alet("请补全地址信息");
        }
    });
}
/*
function init(){
    var pri = $(document).find(".pri");
    var bNum = $(document).find(".buyNum");
    for (var i = 0, l = pri.length; i < l; i ++) {
        price[i] = parseFloat($(pri[i]).text());
        cal[i] = parseInt($(bNum[i]).val())*price[i];
    }
    calTot();
}
*/
/**
 * 对table各种click进行操作，删除，加减，数目要加上change事件
 */
function click() {
    var dir,node;
    $("body").delegate(".clk","click",function(event){
        dir = $(this).attr("name");
        //当选择某一个商品的时候
        if(dir == "orderId[]"){
            calAll();
        }else if(dir == "inc"){
            //增加购买数量
            node = this.parentNode;
            node = $(node).find(".buyNum");
            //var num =  parseInt($(node).val()) + 1;
            $(node).val( parseInt( $(node).val()) + 1);
            calAll();
        }else if(dir == "dec"){
            //减少购买数量
            node = this.parentNode;
            node = $(node).find(".buyNum");
            var num =  Math.max(parseInt($(node).val()) - 1,1);
            $(node).val(Math.max( parseInt( $(node).val() )-1,1 ));
            calAll();
        }else if(dir == "del"){
            //删除所选的物品
            var href = $(this).attr("href");
            var node = this.parentNode;
            $.ajax({
                url: href,
                type: 'get',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if(data){
                        $.alet("删除成功");
                        var cls = $(node).attr("name");//从name中读取店家的id,在父节点的tr中有
                        node = node.parentNode;//现在node是tr
                        $(node).detach();//删除tr
                        var cls = $("."+cls);//cls 作为class 是该table的class
                        console.log(cls);
                        var temp = cls.find("tr");//在table内查找店家的商品是否还有
                        if(temp.length == 0){
                            $.alet("删除");
                            cls.detach();
                            temp = $(cls).attr("name");//以name作为css，再次删除
                            $("."+temp).detach();
                        }
                        //删除相应的dom
                        calAll();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.alet("删除失败");
                }
            });
            event.preventDefault();
        }
    }).delegate("input[name = 'buyNum[]']","change",function(){
        $(this).val( Math.max(parseInt($(this).val()),1) );
        calAll();
    })
    $("#allChe").click(function(){
        //allchecked 全选，并计算价格
        var chose = $(document).find("input[name = 'chose']");
        var dir = $(this).attr("checked")?true:false;
        for (var i = 0, l = chose.length;  i< l;  i++) {
            $(chose[i]).attr("checked",dir);
        }
        calAll();
    })
}
/**
 * 寻找tr的父节点,貌似只有一处调用了呢
 */
function parFind(node) {
    node = node.parentNode;
    while((node)&&$(node).attr("tagName") != "TR"){
        node = node.parentNode;
    }
    return node;
}
/**
 * 对下单之后的事情进行处理,正式提交之前
 * 检查地址时候选择
 * @todo 当年好幼稚....
 */
function sub(){
    $("form").submit(function(event){
        if(parseInt($("input[name = 'addr']").val() , 10) === -1){
            $.alet("请选择或者输入地址及收货人信息");
            event.preventDefault();
        }
    })
}
/**
 *  calucate all 对所有的商品总和进行计算
 */
function calAll(){
    var lestPrc = $(".lestPrc");
    var slCal = $(".slCal");
    var ordlist = $(".ordlist");
    var total = 0;
    for(var i = ordlist.length - 1;i >= 0 ;i--){
        var chose = $(ordlist[i]).find("input[name = 'orderId[]']");
        var buyNums = $(ordlist[i]).find("input[name = 'buyNums[]']");
        var price = $(ordlist[i]).find(".pri");//需要转换成为float，目前是text
        var cal = 0;
        for(var j = chose.length - 1;j >= 0;j--){
            if($(chose[j]).prop('checked')){
                cal += parseFloat($(price[j]).text())*parseInt($(buyNums[j]).val());
            }
        }
        if((parseInt($(lestPrc[i]).text()) > cal) && cal){
            //将最低起送价对比总和，看是不是需要添加2元
            $(slCal[i]).text("2+" + cal + "=" + (2 + cal));
            total +=2+cal;
        }else{
            total +=cal;
            $(slCal[i]).text(cal);
        }
    }
    $("#calAl").text(total);
}
