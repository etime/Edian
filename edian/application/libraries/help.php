<?php
/**
 * 一些工具类的函数，没有具体的用处，用完即删的
 * @name        libraries/help.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2013-12-06 22:31:13
 * @package     libraries
 */
/**
 *
 */
class CI_Help
{

     function __construct()
    {
        //连个构造都没有，成和体统
    }
     /**
      * 以一种更优雅的方式显示数组
      */
     public function showArr($arr , $tab = "")
     {
         $cnt = 0;
         if(is_array($arr)){
             foreach ($arr as $key => $value) {
                 echo $tab;
                 if(is_array($value)){
                     echo $key." => (<br/>" ;
                     $this->showArr($value , '&nbsp&nbsp&nbsp&nbsp' . $tab);
                     echo $tab . ")<br/>";
                 }else{
                    echo $key . "=> " .$value ."<br/>";
                 }
             }
         } else {
             var_dump($arr);
         }
     }
     /**
      * 通过sock的方式发起post请求，测试的时候使用
      * 其实不推荐这种方式，因为需要修改对应的php.ini文件，所以没有完成就放弃了，下面是实现的思路
      * @return string
      * @author unasm<1264310280@qq.com>
      */
     public function sock($host)
     {
        $login = "登录名字";
        $password = "密码";
        $argv = array('cookie' => array('login' => $login,'password' => $password));
        foreach ($argv['cookie'] as $key => $value) {
            $param[] = $key . '=' . $value;
        }
        $host = site_url('test/get');
        //$host = "www.edian.cn/index.php/test/get";
        $port = 80;
        $param = implode('&',$param);
        $header = "POST /bbpress/bb-login.php HTTP/1.1\r\n";
        $header .= "Host:$host\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($param) . "\r\n";
        $header .= "Connection: Close\r\n\r\n";
        $header .= $param;
        $fp = fsockopen($host);
        fputs($fp,$header);
        while(!feof($fp)){
            $str = fgets($fp);
            var_dump($str);
        }
     }
    /**
     * 将一个post数组转化成为string发送出去
     * post数组在网络传输中的格式有一点不同
     * @param array $post   想要转化成为字符串的数组
     * @return string       转化成为的字符串
     */
     protected function enCodeStr($post)
     {
       $postString = "";
        foreach ($post as $key => $val) {
            $postString  .= $key .'=' .$val.'&';
        }
        rtrim($postString,'&');
        return $postString;
     }
     /**
      * 通过curl的方式发起post请求
      * 确切说是通过curl的方式发起向某一个url发起post请求,当然，get也一样,只是get没有必要专门写一个函数
      * @param array   $post    想要向另一个页面发起的post数据
      * @param string  $url     数据的接收地址
      * @return string
      * @author unasm<1264310280@qq.com>
      */
     public function curl($data = false , $url = false)
     {
        //设置默认值
        if($data === false){
            $data = array('userName' => '名字','passwd' => '密码');
            echo "没有设置post数组";
        }
        if($url === false){
            $url = site_url('test/get');
            echo "没有设置url";
        }

        $string = $this->enCodeStr($data);
        $header = 'Content-type: text/html';
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_HEADER,$header);
        curl_setopt($curl,CURLOPT_POST,count($data));
        curl_setopt($curl,CURLOPT_POSTFIELDS, $string);
        $res = curl_exec($curl);
        if(curl_errno($curl))
            print curl_error($curl);
        curl_close($curl);
        echo $res;
     }
     /**
      * 玩的，别用
      *
      * @return void
      */
     public function hack($data,$url)
     {
        $string = $this->enCodeStr($data);
        $tempIp =   '201.202.123,40';
        $header['CLIENT-IP'] =  $tempIp;
        $header['X-FORWARDED-FOR'] = $tempIp;
        $headerArr = array();
        foreach ($header as $key => $val) {
            $headerArr[] = $key . ':' . $val;
        }
        //ob_start();
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_HEADER,$headerArr);
        curl_setopt($curl,CURLOPT_POST,count($data));
        curl_setopt($curl,CURLOPT_POSTFIELDS, $string);
        curl_setopt($curl,CURLOPT_REFERER,"http://www.163.com/");
        $res = curl_exec($curl);
        if(curl_errno($curl))
            print curl_error($curl);
        curl_close($curl);
        echo $res;
        /*
        $sec = ob_get_contents();
        echo $sec;
        ob_clean();
         */
     }
    function test($data,$url)
     {
         $headers['CLIENT-IP'] = '202.103.229.40';
         $headers['X-FORWARDED-FOR'] = '202.103.229.40';
         $headerArr = array();
         foreach( $headers as $n => $v ) {
             $headerArr[] = $n .':' . $v;
         }
         ob_start();
         $ch = curl_init();
         curl_setopt ($ch, CURLOPT_URL, $url);
         curl_setopt ($ch, CURLOPT_HTTPHEADER , $headerArr );  //构造IP
         curl_setopt ($ch, CURLOPT_REFERER, "http://www.163.com/ ");   //构造来路
         curl_setopt( $ch, CURLOPT_HEADER, 1);
         curl_exec($ch);
         curl_close ($ch);
         $out = ob_get_contents();
         ob_clean();
         echo $out;
     }
}
?>
