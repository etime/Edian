<?php
//require_once 'print.php';
//require_once 'dsprint.class.php';
//require_once 'dsconfig.class.php';
class Test extends MY_Controller{
    var  $user_id="",$partmap;
    static $time;
    function __construct(){
        parent::__construct();
    }
    public function mem()
    {
        $ab = "斯蒂芬";
        echo $ab;
        echo $ab[0];
        echo "<br/>sdf";
    }
    public function sec()
    {
        $mk=mkdir('dtulog');
        var_dump($mk);
        //或者绝对路径文件名，例如COMWAY云打印的PHP空间路径：/home/vhosts/comway.freetzi.com/dtulog/123
        $filenum = @fopen("dtulog/123", 'w');
        var_dump($filenum);
        @fputs($filenum,"123123\n");
        fclose($filenum);
    }
    protected function  value(&$tt)
    {
        echo "testing";
    }
    public function map()
    {
        //phpinfo();
        $this->load->library('help');
        $this->help->showArr($_POST);
        $this->load->view("test");
    }
    public function abc()
    {
        $this->load->library("help");
        $val = array(
            "32323.jpg",
            "52_2013-12-16_13-49-20.jpg",
            "52_2013-12-16_13-49-20.png",
            "52_2013-12-16_13-49-20.gif");
        foreach ($val  as $key) {
            $data["logo"] = "52_2013-12-16_13-49-20.jpg";
            $data['logo'] = $key;
            $this->help->curl($data , site_url("bg/set/setGet"));
            echo "<br/>";
        }
    }
    protected function enCodeStr($post)
    {

    }
    public function voteAct()
    {
        if($this->input->post("sub")){
            $filename = trim($this->input->post("fileName"));
            $name     = trim($this->input->post("name"));
            $content  = trim($this->input->post('content'));
            if($filename && $name && $content){
                $filename = mysql_real_escape_string($filename);
                $name     = mysql_real_escape_string($name);
                $content  = mysql_real_escape_string($content);
                $this->db->query("insert into vote(filename,name,content) values('$filename' , '$name' , '$content')");
            }
        }
        header("Location:" . site_url("test/vote"));
    }
    public function vote()
    {

        $res = $this->db->query("select name,filename,content from vote");
        $data['com'] = $res->result_array();
        for($i = 0,$len = count($data['com']); $i <  $len ;$i ++){
            $data['com'][$i]['name']     = htmlspecialchars($data['com'][$i]['name']);
            $data['com'][$i]['content']  = htmlspecialchars($data['com'][$i]['content']);
            $data['com'][$i]['filename'] = htmlspecialchars($data['com'][$i]['filename']);
        }
        $this->load->view("complete" , $data);
    }
    public function store()
    {
        $this->load->view("store2");
    }
    public function hack()
    {
        $this->load->library('help');
        //$url = "http://bbs.stuhome.net/member.php?mod=logging&action=login&loginsubmit=yes&frommessage&loginhash=LTM9n";
        $url = site_url('test/hackget');
        $data['username'] = "石室印象";
        $data['password'] = "1232x232";
        $this->help->test($data,$url);
    }
    public function hackget()
    {
        $this->load->library("help");
        $this->help->showArr($_POST);
    }
    public function get()
    {
        /*
        $this->load->library('help');
        $this->help->showArr($_POST);
         */
        $len = 100000;
        $stime = time();
        for ($i = 0; $i < $len; $i++) {
            $var = 1233;
        }
        $end = time();
        echo $end - $stime;
        flush();
        $this->load->model('boss');
        $stime = time();
        for ($i = 0; $i < $len; $i++) {
            $this->boss->getBossIdByLoginName("tianyi");
        }
        $end = time();
        echo "<br/>". $stime."<br/>";
        echo $end ."<br/>";
        echo  $end - $stime;
    }
    function sms(){
        header("Cache-control:no-cache");
        $rdCode = "";
        for($i = 0;$i < 6 ;$i++){
            $rdCode .= rand(0,9);
        }
        $cont = "验证码".$rdCode."请将接收时间（精确到秒）发送到13648044299豆处，可以获得大礼包一份";
        $phone = "18011419947";
        //http://utf8.sms.webchinese.cn/?Uid=本站用户名&  ey=接口安全密码&smsMob=手机号码&smsText=短信内容
        $url = "http://utf8.sms.webchinese.cn/?Uid=unasm&Key=a35b424a5a7a0107a078&smsMob=".$phone."&smsText=".$cont;
        //echo $url;
        echo $this->sendSms($url);
    }
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
    function testSendFreeMessage(){
        $freeTxt = "\ne点工作室竭诚为您服务\n" .
                        "订单时间：".date("Y-m-d H:i:s")."\n".
                        "订单号码：112233445566\n" .
                        "顾客："."长夜漫漫失眠了"."\n" .
                        "\x1B\x21\x08".#打印机粗体指令
                        "总价："."￥12.00"."\n" .
                        "菜品："."\t红烧狮子头"."\n" .
                        "\t"."棒打高丽棒子"."\n" .
                        "\t"."预想茄子"."\n" .
                        "\t"."姐姐"."\n" .
                        "特殊要求："."狮子头要非洲三岁雄狮子，棒子要打痛"."\n" .
                        "\x1B\x21\x00".  #取消打印机粗体指令
                        "\n\n";
        //此处修改为用户的密码以及appid。
        $client = new DsPrintSend('1e13cb1c5281c812','2050');
        //$client = new DsPrintSend('your_password','your_appid');
        //$client = new DsPrintSend();
        //打印字符串，此处修改为用户名下对应的在线的且连接打印机的dtuid。
        echo $client->printtxt('308001300434',$freeTxt,60,"\x1B\x76");
        //echo $client->printtxt('your_dtuid',$freeTxt,60);
        //查询打印机状态
        //echo $client->printtxt('your_dtuid');
    }
    function testChangeURL(){
        $client = new DsPrintSend('1e13cb1c5281c812','2050');
        //更改URL
        $client->changeurl();
    }
    public function path()
    {
        foreach ($_SERVER as $idx => $val) {
            echo $idx."=>".$val."<br/>";
        }
    }
    public function receive(){
        //file_get_contents("php://input") 接收POST原始数据
        $data = file_get_contents("php://input");
        //$errorlog = isset($errorlog)?$errorlog:'';
        if($errorlog)
            file_put_contents($dtupath."errlog.txt", "dsreceive	,data:	".$data.",	data len:".strlen($data)."\n", FILE_APPEND);
        if($data and strlen($data)>36){
            $reqTime = time();
            $re = unpack ('a16mac/a16dtu/Ntime/H*result', $data);
            $dtuid = $re['dtu'];
            if(strlen($dtuid)!=12)
            {
                if($errorlog)
                    file_put_contents($dtupath."errlog.txt", "$reqTime".",dsreceive	,dtu id len(12) error:	".$dtuid."\n", FILE_APPEND);
                return;
            }
            $filename = $dtupath.$dtuid;
            if(!file_exists ($dtupath))
                mkdir($dtupath);
            if($errorlog)
                file_put_contents($dtupath."errlog.txt", "$reqTime".",dsreceive	,filename:	".$filename.",	result:".$re['result']."\n", FILE_APPEND);
            $farray = file($filename);
            $newfp = $farray;
            $lines = count($farray);
            $newfp = '';
            $del = $lines-$dtutmplines;
            for($Tmpa=0;$Tmpa<$lines;$Tmpa++)
            {
                if($Tmpa<$del)
                    continue;
                $newfp.=$farray[$Tmpa];
            }
            $filenum = @fopen($filename, 'w');
            @fputs($filenum,$newfp.$reqTime.",".$re['result']."\n");
            fclose($filenum);
        }
    }
}
?>
