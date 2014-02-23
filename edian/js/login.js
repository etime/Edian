/**
 * 登录的管理和控制
 * 作为这个的使用约束，就是在一个id为login的form下，函数名必须是login
 * @name        ../../js/login.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-02-18 21:22:07
*/

/**
 * 做成一个自闭的登录管理函数
 * 只需要外界调用login，就可以完成登录的内容
 * @param {string} callBack  回调函数，在成功的时候触发，这个是为了适应不同的情况和情景
 */

function login(callBack){
    var login = $("#login");
    /**
     * 目前就简单的替换成为注销，以后添加用户中心之类的
     */
    function replaceDom() {
        var str = "<a href = '" + site_url + '/destory/zhuxiao'+ "' class = 'zhuxiao'>注销</a>";
        $('.replace').html(str);
    }
    //监测 注销和登录两种事情
    $(".replace").delegate('a' , 'click' , function (event) {
        var name = $(this).prop('class');
        if(name === 'zhuxiao'){
            event.preventDefault();
            $.ajax({
                url: $(this).prop('href'),
                success: function (data, textStatus, jqXHR) {
                    alet('注销成功');
                    var str = "<a href = '#' id = 'gotoLogin' class = 'gotoLogin'>登录</a>  | <a href = '" + site_url + '/register/userRegister/' + "'>注册</a>";
                    $('.replace').html(str);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("出错了");
                }
            });
        } else if(name === 'gotoLogin'){
            login.fadeToggle();
            event.preventDefault();
        }

    })
    //如果已经登录，就替换dom
    if(userId)replaceDom()
    $("#login form").submit(function (event) {
        var name = login.find("input[name = 'userName']").val();
        var pass = login.find("input[name = 'password']").val();
        if(name && pass){
            $.ajax({
                url: site_url + '/login/loginCheck',type: 'POST',dataType: 'json',
                data:{'userName' :name , 'password' : pass},
                success: function (data, textStatus, jqXHR) {
                    if(data === 'true'){
                        login.find(".atten").text('登录成功');
                        login.fadeOut();
                        if(callBack){
                            callBack();
                        }
                        userId = true;
                        replaceDom();
                    } else {
                        login.find(".atten").html(data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    login.find(".atten").text('登录失败' + textStatus);
                }
            });
        } else if(!name){
            login.find(".atten").text('请输入用户名或者手机号码');
            login.find("input[name = 'userName']").focus();
        } else {
            login.find(".atten").text('请输入密码');
            login.find("input[name = 'password']").focus();
        }
        event.preventDefault();
    });
    $("#login .shut").click(function () {
        login.fadeOut();
    })
}
/**
 * 弹出框，一定时间后自动小时
 * @param {string} cont 通过弹出框想要说的内容
 */
function alet(cont) {//给出各种提示的函数，和alert不同，这个过1s就消失
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

