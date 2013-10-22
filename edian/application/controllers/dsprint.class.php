<?php

//引用库
require_once $_SERVER["DOCUMENT_ROOT"].'/dsconfig.class.php';
//require_once 'dsconfig.class.php';
require_once 'HttpClient.class.php';
/*
require_once $_SERVER["DOCUMENT_ROOT"].'application/controller/dsconfig.class.php';
require_once $_SERVER["DOCUMENT_ROOT"].'application/controller/HttpClient.class.php';

 */
/*
 * dsprint天同云打印接口类,构造函数参数为dtuid以及用户密码
 */
class DsPrintSend {
	var $password='';
	var $appid='';
	function DsPrintSend($password=PASSWORD,$app_id=APP_ID) {
        $this->password = $password;
        $this->appid = $app_id;
    }
	/*
	功能：打印自由格式文本或者打印机查询指令，格式为UTF-8编码，便于网络应用，若为GBK编码，则在下面注释GBK转码代码。
	参数： dtuid,		指定打印的dtuid号
		  text,			需打印文本，UTF-8编码。若不是UTF-8编码，请调用前用iconv转换为UTF-8编码。
						若为空，则查询打印机当前状态
		  timeout,		超时时间，默认是60s。
		  querycmd,		打印机查询状态指令，不同打印机可能不同，默认为多数打印机的查询指令0x1B 0x76
	返回： 打印机查询状态的指令返回的结果
	*/
	function printtxt($dtuid,$text='',$timeout=60,$querycmd=QUERY_PRINTER){
		global $dtupath,$errorlog;
		$reqTime = time();
		$dtuid = trim($dtuid);
		if(strlen($dtuid)!=12)
		{
			if($errorlog)
				file_put_contents($dtupath."errlog.txt", "$reqTime".",dsprint	,dtu id len(12) error:	".$dtuid."\n", FILE_APPEND);
			return 'error';
		}
		$head = pack('a16N', $dtuid, $reqTime);
		//将UTF-8编码转换为GBK编码，适应打印机的中文字库，若传过来的字符集为GBK编码，则注释掉下面中文转码行。
		//如果在传入字符串中有打印机的指令，例如0x80，则可能造成转码失败。在这种情况下，可以先将打印的字符串转成GBK后，再添加打印机指令。
		//或者页面中用GBK编码传输，用户可以根据自己情况灵活运用。
		//iconv,针对€转码有问题，建议用mb_convert_encoding，对GBK不识别的字符用0x00 0x80替换。
		//$text = iconv("UTF-8","GBK//ignore",$text);
		$text = mb_convert_encoding($text, "GBK","UTF-8");
		//将打印内容后面串上打印机的查询指令。
		$data = $head.$text.$querycmd;
		//校验算法，客户不用关心
		$mac = md5($data.md5($this->password,TRUE),TRUE);
		$data = $mac.$data;
		//请求的URL："http://ds.fusionunix.com/prn/".$this->appid
		//若php空间的域名解析偶尔出现问题，在errlog中看到如下提示：php_network_getaddresses: getaddrinfo failed: Name or service not known，可以改成IP：125.208.3.26
		$client = new HttpClient("ds.fusionunix.com",80);
		if(!$client->post("/prn/".$this->appid,$data,$timeout)){ //提交失败
			if($errorlog)
				file_put_contents($dtupath."errlog.txt", "$reqTime".",dsprint	,post data error,dtuid:".$dtuid.",msg:	".$client->errormsg."\n", FILE_APPEND);
			return 'error';
		}
		else{
			if($client->getContent()=='OK')
			{
				//提交请求正常，接收打印机查询结果,每隔3s，循环查询dtu缓存log文件
				while($timeout>3)
				{
					sleep(3);
					if($fp = file($dtupath.$dtuid))
					{
						$re=$fp[count($fp)-1];
						list($retime,$content)= explode (",", $re);
						if($retime>=$reqTime)
							return trim($content);
					}
					$timeout=$timeout-3;
				}
			}
			if($errorlog)
				file_put_contents($dtupath."errlog.txt", "$reqTime".",dsprint	,dtuid:".$dtuid.",	return:	".$client->getContent().",timeout:	".$timeout."\n", FILE_APPEND);
			return 'error';
		}
	}

	/*
	功能：更改dsreceive.class.php的访问URL位置更改为dsconfig里面设置的$receivephp，此函数主要是管理功能。客户更改dsrecerive的URL访问地址时可调用，其他时候无需调用。
	返回：服务器更改URL返回的结果
	*/
	function changeurl($timeout=60)
	{
		global $dtupath,$errorlog,$receivephp;
		$reqTime = time();
		$head = pack('N', $reqTime);
		$data = $head.'setAcc '.$this->appid.' '.DSUSERID.' '.$this->password.' '.$receivephp;
		//校验算法，客户不用关心
		$mac = md5($data.md5($this->password,TRUE),TRUE);
		$data = $mac.$data;
		//若php空间的域名解析偶尔出现问题，在errlog中看到如下提示：php_network_getaddresses: getaddrinfo failed: Name or service not known，可以改成IP：125.208.3.26
		$client = new HttpClient("ds.fusionunix.com",80);
		if(!$client->post("/prn/m",$data,$timeout)){ //提交失败
			if($errorlog)
				file_put_contents($dtupath."errlog.txt", "$reqTime".",dsprint	,post data error,userid:".DSUSERID.",msg:	".$client->errormsg."\n", FILE_APPEND);
			return 'error';
		}
		else{
			if($client->getContent()=='OK')
				return 'ok';
			else
			{
				if($errorlog)
					file_put_contents($dtupath."errlog.txt", "$reqTime".",dsprint	,userid:".DSUSERID.",	return:	".$client->getContent().",timeout:	".$timeout."\n", FILE_APPEND);
				return 'error';
			}
		}
	}

}
?>
