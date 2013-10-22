<?php
/*************************************************************************
    > @文件名:     ../../application/libraries/sms.php
    > @作者:       unasm
    > @邮件:       1264310280@qq.com
    > @创建时间:   2013-09-23 10:02:53
 ************************************************************************/
/**
 * 短信发送类，用到发送短信的时候，调用这里的函数，就可以发送短信了，
 *
 */
class CI_Sms{
    var $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    /**
     * 控制短信发送，处理逻辑
     *
     * 主要功能为检验手机号码，拼接发送的url，返回为-1的时候为手机号码不对，返回为1为发送成功，0和其他的情况则列入错误情况,向管理员反馈吧
     * @$cont string 需要发送的内容，字符串
     * @$phone int 手机号码，长11位
     */
    public function send($cont,$phone){
        $phone = trim($phone);
        if(preg_match("/^1[\d]{10}$/",$phone)){
            //正则验证是不是11位数字，不然就是浪费哦
            header("Cache-control:no-cache");
            /*
             * 2013-09-23 12:52:58 unasm
             * 根据网站样例，发送的url格式必须如下，手机短信才可以发送
             * http://utf8.sms.webchinese.cn/?Uid=本站用户名&  ey=接口安全密码&smsMob=手机号码&smsText=短信内容;
             */
            $url = "http://utf8.sms.webchinese.cn/?Uid=unasm&Key=a35b424a5a7a0107a078&smsMob=".$phone."&smsText=".$cont;
            return $this->sendSms($url);//返回的是发送的短信条数
        }else{
            return -1;
        }
    }
    /*
     * 负责具体如何发送短信，是别的网站提供的样例
     * @$url string url，需要发送到的网址
     */
    private function sendSms($url)
    {
        if(function_exists('file_get_contents')){
            $file_contents = file_get_contents($url);
        }else{
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            $file_contents = curl_exec($ch);
            $curl_close($ch);
        }
        return $file_contents;
    }
}
?>
