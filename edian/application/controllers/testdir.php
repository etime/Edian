<?php
//测试是否支持创建相对目录以及文件
//或者绝对路径，例如COMWAY云打印的PHP空间路径：/home/vhosts/comway.freetzi.com/dtulog/
$mk=mkdir('dtulog');	
var_dump($mk);
//或者绝对路径文件名，例如COMWAY云打印的PHP空间路径：/home/vhosts/comway.freetzi.com/dtulog/123
$filenum = @fopen("dtulog/123", 'w');
var_dump($filenum);	
@fputs($filenum,"123123\n");	
fclose($filenum);
?> 