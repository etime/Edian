<div id="header">
	<div class="content">
		<ul class = "clearfix">
		<a href = "<?php echo site_url('mainpage/index')?>">
			<li class="index">首页</li>
		</a>
		<a href = "<?php echo site_url('space/index/'.$masterId)?>">
			<li>空<span class="direc">间</span></li>
		</a>
		<a href ="<?php echo site_url('spacePhoto/index/'.$masterId)?>"><li>相册</li></a>
		<a href = "<?php echo site_url("info/index/".$masterId)?>"><li>我的<span class="direc">名</span>片</li></a>
		<img class = "liImg block"src = "<?php echo base_url('upload/'.$photo)?>"/>	
		</ul>	
	</div>
</div>
