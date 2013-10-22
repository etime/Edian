<?php

/**
* 生成验证码
* $_SESSION['securimage_code_value']=$checkcode->get_code();
*/
class Checkcode  extends MY_Controller{
   //验证码的宽度
   public $width=130;
   //验证码的高
   public $height=40;
   //设置字体的地址
   private $font;
   //设置字体色
   public $font_color;
   //设置随机生成因子
   public $charset = 'abcdefghkmnprstuvwyzABCDEFGHKLMNPRSTUVWYZ123456789';
   //设置背景色
   public $background = '#EDF7FF';
   //生成验证码字符数
   public $code_len = 4;
   //字体大小
   public $font_size = 20;
   //验证码
   private $code;

   //图片内存
   private $img;
   //文字X轴开始的地方
   private $x_start;
   function __construct() {
		parent::__construct();
       header("Cache-Control: no-cache\r\n");
		$this->font = array(
			"a.ttf",
			"b.ttf",
			"c.ttf",
			"d.ttf",
			"e.ttf",
			"f.ttf",
			"g.ttf",
			"h.ttf",
			"i.ttf",
			"j.ttf",
			"k.ttf",
			"l.ttf",
			"m.ttf",
			"n.ttf"
		);
   }

   function creat_code() {
    //* 生成随机验证码。
       $code = '';
       $charset_len = strlen($this->charset)-1;
       for ($i=0; $i<$this->code_len; $i++) {
           $code .= $this->charset[rand(1, $charset_len)];
       }
       $this->code = $code;
	   //$_SESSION["imgCheckCode"] = $code;
       //$this->session->user_data("imgCheckCode") = $code;
       $this->session->set_userdata("imgCheckCode",strtolower($code));
   }
   public function index() {
    //* 生成图片
       $this->creat_code();
       $this->img = imagecreatetruecolor($this->width, $this->height);
       if (!$this->font_color) {
           $this->font_color = imagecolorallocate($this->img, rand(0,156), rand(0,156), rand(0,156));
       } else {
           $this->font_color = imagecolorallocate($this->img, hexdec(substr($this->font_color, 1,2)), hexdec(substr($this->font_color, 3,2)), hexdec(substr($this->font_color, 5,2)));
       }
       //设置背景色
       $background = imagecolorallocate($this->img,hexdec(substr($this->background, 1,2)),hexdec(substr($this->background, 3,2)),hexdec(substr($this->background, 5,2)));
       //画一个柜形，设置背景颜色。
       imagefilledrectangle($this->img,0, $this->height, $this->width, 0, $background);
       $this->creat_font();
       $this->creat_line();
       $this->output();
   }
   /**
    */
   private function creat_font() {
    //生成文字
       $x = ($this->width-10)/$this->code_len;
		$font = "font/".$this->font[rand(0,count($this->font)-1)];//随机字体
       for ($i=0; $i<$this->code_len; $i++) {
		   if(rand(0,29) % 2)
			$this->font_color = imagecolorallocate($this->img, rand(0,156), rand(0,156), rand(0,156));
           imagettftext($this->img, $this->font_size, rand(-30,30), $x*$i+rand(5,10), $this->height/1.5+rand(0,10), $this->font_color, $font, $this->code[$i]);
           //if($i==0)$this->x_start=$x*$i+5;
       }
   }
   /**
    * 画线
		*/
   private function creat_line() {
       imagesetthickness($this->img, 3);
		$from = 0;
		for($i = 0; $i < 4;$i++){
			$width  = $this->width / 2.66 + rand(3, 60);
			$height = $this->font_size * 2.14+rand(3,60);
		   if ( rand(0,45) % 2 == 0 ) {
				$start = rand(0,40);
				$this->font_color = imagecolorallocate($this->img, rand(0,356), rand(0,356), rand(0,356));
		        $ypos  = $this->height / 2 - rand(10, 30);
	       } else {
		     $start = rand(200, 250);
			 $ypos  = $this->height / 2 + rand(10, 30);
		   }
			$end = $start + rand(75, 100);
	       imagearc($this->img, $from, $ypos, $width, $height, $start, $end, $this->font_color);
			$from=(($this->width/4)*$i)+rand(10,30);
	   }
   }
   private function output() {
    //* 输出图片
       header("content-type: image/png\r\n");
       header("Cache-Control: no-cache\r\n");
       imagepng($this->img);
       imagedestroy($this->img);
   }
	public function check($code)
	{//ajax检验验证码
	   if(strtolower(trim($code))== $this->session->userdata("imgCheckCode")){
			echo 1;
	   }else echo 0;
	}
   public function sms($imgCode,$phone)
   {
       //在这里发送短信验证码
       //通过图片验证码和sms双重检验，不仅减少sms发送数量，也减少
       // -1 代表没有图片验证码，-2，代表没有手机号码
       if($imgCode == -1){
             echo json_encode("请输入图片验证码");
             return;
       }
       if($phone == -1){
           echo json_encode("请输入手机号码");
           return;
       }
       if(strtolower(trim($imgCode))== $this->session->userdata("imgCheckCode")){
            if($this->smsed($phone) == 1){
                echo json_encode("发送成功");
            }else{
                //向管理员报错，之后添加这个功能
                echo "发送成功";
            }
       }else{
           echo json_encode("请输入正确的图片验证码");
           return;
       }
   }
   public function smsGet()
   {
       //这个的作用感觉不是很明显，将来再说吧，至少发送验证码是没有必要进行接受的，如果将来发送其他类型的消息，就是需要的
       //留着以后研究吧
       /*
        $xml = "<?xml version='1.0' encoding='UTF-8' ?>".
                "<delivers>".
                    "<deliver><subNo>0001</subNo><mob>13810000001</mob><content>收到短信内容</content><time>2010-07-02 00:00:00</time></deliver>".
                    "<deliver><subNo>0002</subNo><mob>13810000002</mob><content>收到短信内容</content><time>2010-07-03 00:00:00</time></deliver>".
                    "<deliver><subNo>0003</subNo><mob>13810000002</mob><content>收到短信内容</content><time>2010-07-03 00:00:00</time></deliver>".
                    "<deliver><subNo>0004</subNo><mob>13810000002</mob><content>收到短信内容</content><time>2010-07-03 00:00:00</time></deliver>".
                "</delivers>";
        */
        $xml = file_get_contents("php://input","r");
        preg_match_all('/<subNo>([\d]*?)<\/subNo>/i',$xml,$no,PREG_PATTERN_ORDER);
            //这里寻找的是所有的序列号码
        preg_match_all('/<mob>([\d]*?)<\/mob>/i',$xml,$phNum,PREG_PATTERN_ORDER);
        //查找电话号码
        preg_match_all('/<time>(.*?)<\/time>/i',$xml,$time,PREG_PATTERN_ORDER);
        //查找发送的时间
        $this->showArr($no[1]);
        $this->showArr($phNum[1]);
        $this->showArr($time[1]);
   }
    public function showArr($arr)
    {
        foreach ($arr as $key => $val) {
            var_dump($key);
            echo " => ";
            var_dump($val);
            echo "<br/>";
        }
        echo "<br>";
    }
    private function smsed($phone){
        $rdCode = "";//rand code，生成的随机号码
        for($i = 0;$i < 6 ;$i++){
            $rdCode .= rand(0,9);
        }
        $cont = "验证码".$rdCode."请将接收时间（精确到秒）发送到13648044299豆处，可以获得大礼包一份";
        $this->session->set_userdata("smscode",$rdCode);
        //http://utf8.sms.webchinese.cn/?Uid=本站用户名&  ey=接口安全密码&smsMob=手机号码&smsText=短信内容
        $url = "http://utf8.sms.webchinese.cn/?Uid=unasm&Key=a35b424a5a7a0107a078&smsMob=".$phone."&smsText=".$cont;
        return $this->sendSms($url);
    }
    private function sendSms($url)
    {
        //这个代码是官方提供的例子，没有修改；
        if(function_exists('file_get_contents')){
            $file_contents = file_get_contents($url);
        }else{
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
            //这里或许是错误的，去掉了curl_close 的$符号
        }
        return $file_contents;
    }
}
//注意：第50行  $this->font = "font/arial.ttf";    需要 指定一个 字体

