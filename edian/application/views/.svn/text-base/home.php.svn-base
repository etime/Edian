<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>首页</title>
<link rel="stylesheet" type="text/css" href="<?=site_url("../home.css")?>"/>
</head>
<body>
		<form method="post" action="index_into.php" >
				<input type="text" name="name"/>
				<input type="text" name="passwd"/>
				<input type="submit" name="sub"/>
		</form>
<?php
echo site_url();
/*
 * <link rel="stylesheet" type="text/css" href="<?=site_url("../home.css")?>"/>
 */
?>	

	<div id="header">
        <img src="../../../images/bird2.jpg" id="bird2"/>
        <img src="../../../images/bird.jpg" id="bird1"/>
    </div>
     <div id="dir">
       <div id="dir_con">
        <p>348* 760</p>

        <!--
	       <p>用户名:</p><input type="text" name="user_name" />
           <p>密码：</p><input type="password" name="passwd" />
          <input type="submit" name="sub" value="登录" id="sub"/>  
     -->
     <ul type="none">
				 <a href="./imgupload.html"><li>相册</li></a>
				 <a href="<?=site_url("reg")?>"><li>注册</li></a>
				 <a href="<?=site_url("chome/ans_upload/")?>"><li>相册</li></a>
				<?=anchor(site_url("/chome/editor"),"写文章")?>
				<a href="/index.php/chome/editor/">href 写文章</a>
        <li>关注</li>
        <li>关于我们</li>
        <li>邮箱</li>
     </ul>
       </div>
     		<div id="dir_top_bor">
        	</div>
      	     <div id="dir_right">
      	    </div>
       		 <div id="dir_bor2">
       		 </div> 
               <div id="dir_bottom_cor">
      		  </div>
           
      </div>
    <div id="fir" alt="邮箱">
   	     <div id="fir_bor">
	 	 </div> 
         <div id="fir_cor">
   		 </div>
         <p>168*403邮箱</p>
		</div>
    <div id="sec" alt="文章">  
         <div id="sec_cor">
   		 </div>
    	  <div id="sec_bor">
	 	  </div> 
			<!-- 用来显示文章标题 --------------------------------  -->
			<div id="article">
						<ul type="none" >
						<?php foreach($title as $temp): ?>	
					<li><?=anchor(site_url("/showart/index/").'/'.$temp->art_id,$temp->title)?></a></li>
						<?php endforeach ?>
						</ul>
				</div>
    </div>
<!------------------下面开始是相册-------------->
      <div id="third" alt="相册">  
        <div id="third_bor">
	 	  </div>  
         <div id="third_cor">
   		 </div>   
      <p>
      </p>
   	 </div>
       <div id="bottom">
      	</ div>
</body>
</html>
