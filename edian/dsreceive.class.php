<?php
require_once 'dsconfig.class.php';
//file_get_contents("php://input") 接收POST原始数据
$data = file_get_contents("php://input");
//$errorlog = isset($errorlog)?$errorlog:'';
if($errorlog)
	file_put_contents($dtupath."errlog.txt", "dsreceive	,data:	".$data.",	data len:".strlen($data)."\n", FILE_APPEND);
if($data and strlen($data)>36)
{
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

?>
