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
        var str = "<a href = '" + site_url + '/destory/zhuxiao'+ "'>注销</a>";
        console.log(login.find(".replace"));
        $('.replace').replaceWith(str);
    }
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
    $("#login .close").click(function () {
        login.fadeOut();
    })
    $("#gotoLogin").click(function (event) {
        login.fadeToggle();
        event.preventDefault();
    })
}

