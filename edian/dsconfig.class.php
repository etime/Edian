<?PHP
//COMWAY云打印基本参数设置

//更改APP_ID为在云印开户分配的appid，PASSWORD为用户名密码
define('APP_ID','2050');//每个申请使用Comway云打印的用户即可分配一个唯一的appid号,此处填写您的appid
define('DSUSERID','1264310280@qq.com');//无线串口登录用户名，此处填写您的userid
define('PASSWORD','1e13cb1c5281c812');//无线串口用户登录密码，此处填写您的密码
//查询打印机状态的指令
define('QUERY_PRINTER',"\x1B\x76");//各个打印机可能查询纸状态指令不同0x1B,0x76,默认为：0x1B,0x76,佳博打印机的查询指令

//API的库函数dsreceive.class.php的链接，此处填写您网站空间发布的dsreceive.class.php的访问地址
//内网中测试可以打印，但是可能会提取不到打印机的结果，这是因为COMWAY云打印服务采取异步通讯，url callback的方式提交结果，在公网中访问不到您的内网dsreceive.class.php网页
//当网页发布到公网空间后，若公网可以访问到您网站空间的dsreceive.class.php网页，即可提取到结果。
$receivephp= 'http://www.edian.me/dsreceive.class.php';//填写您的空间访问地址，这个地址只是一个范例
//$receivephp='http://teamfusion.gnway.net:5858/dsreceive.class.php';//填写您的空间访问地址，这个地址只是一个范例

//临时文件目录，云打印需要写临时文件，可根据用户情况更换路径，默认在下级dtulog目录下。
//可以根据用户情况更改路径，路径为相对路径，用户也可以更改为绝对路径，例如：/home/vhosts/comway.freetzi.com/dtulog/
$dtupath='dtulog/';
$dtutmplines=30;//保存dtu log的记录数。默认不需要修改。
$errorlog=true;//是否输出log，默认保存错误log的文件为$dtupath目录下的errlog.txt。

//单个整形转换成16进制字符串，例如15->"f"
function SingleDecToHex($dec)
{
    $tmp="";
    $dec=$dec%16;
    if($dec<10)
        return $tmp.$dec;
    $arr=array("a","b","c","d","e","f");
    return $tmp.$arr[$dec-10];
}

//单个字符串转换为整形，例如'0'-> 0
function SingleHexToDec($hex)
{
    $v=ord($hex);
    if(47<$v&&$v<58)
        return $v-48;
    if(96<$v&&$v<103)
        return $v-87;
}

//将16进制字符串的0x03 0xC5 0x01,转换成字符串“03C501”
function Byte2String($str)
{
    //if(!$str)return false;
    if(strlen($str)==0)
    	return "";
    $tmp="";
    for($i=0;$i<strlen($str);$i++)
    {
        $ord=ord($str[$i]);
        $tmp.=SingleDecToHex(($ord-$ord%16)/16);
        $tmp.=SingleDecToHex($ord%16);
    }
    $tmp=strtoupper($tmp);
    return $tmp;
}

//将字符串“03C501”转换成16进制字符串的0x03 0xC5 0x01
function String2Byte($str)
{
    //if(!$str)return false;
	if(strlen($str)==0||strlen($str)%2!=0)
    	return "";
    $tmp="";
    for($i=0;$i<strlen($str);$i+=2)
    {
        $tmp.=chr(SingleHexToDec(substr($str,$i,1))*16+SingleHexToDec(substr($str,$i+1,1)));
    }
    return $tmp;
}

//ASCII转16进制
function asc2hex($str)
{
	return '\x'.substr(chunk_split(bin2hex($str), 2, '\x'),0,-2);
}
//十六进制 转 ASCII
function hex2asc($str)
{
	$str = join('',explode('\x',$str));
	$len = strlen($str);
	for ($i=0;$i<$len;$i+=2)
		$data.=chr(hexdec(substr($str,$i,2)));
	return $data;
}
?>
