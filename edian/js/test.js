$(document).ready(function(){
    var options = {
        target: "#toImg",
        url:    siteUrl+"/test/abc",
        iframe:true,
        success:function (responseText) {
            console.log(responseText);
            $("#toImg").attr("src",responseText);
        }
    }
    $("#myImg").ajaxForm(options);
    $("#userfile").change(function(){
        console.log("testing");
        $("#myImg").ajaxSubmit();
        return false;
    })
    $("#myImg").submit(function () {
        console.log("ac");
        $(this).ajaxSubmit();
        return false;
    })
});
