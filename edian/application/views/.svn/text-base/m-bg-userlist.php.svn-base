<!doctype html>	
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<style type="text/css">
		table{
				table-layout: fixed;
			white-space: nowrap;
			width: 100%;
			border-top: 1px solid #ccc;
			font-size: 16px;
				text-align:center;
		}
		a{
				text-decoration:none;		
		}
		.mail-box th{
			font-size: 20px;
			color: #4bbdfd;
			border-bottom: 1px solid #ccc;
		}

		.mail-box td{
			border-bottom: 1px solid #ccc;
		}
		.mail-box .user{
			width: 100px;
				overflow:hidden;
		}
		.mail-box .date{
				width: 150px;
		}
		.mail-box .tm{
			overflow: hidden;
				text-overflow:ellipsis;
		}
		.mail-box .action{
				width:70px;		
		}
		.mail-box .passwd{
				width:100px;				
		}
		.mail-box .action{
				width:70px;		
		}
/*
		body tr td  div{
				background:blue;
				width:150px;
				height:170px;
		}
*/
		</style>
		
	</head>
		<!--  S - body -->
	<body>
			
				<table cellspacing="0" class="mail-box">
						<tr>
							<th class="user">用户id</th>
							<th class="user">用户等级</th>
							<th class="tm">用户名</th>
							<th class="passwd">密码</th>
							<th class="data">注册时间</th>
							<th class="user">冻结状态</th>
							<th class="action">操作</th>
						</tr>
					<?php foreach($userall as $temp):?>
						<tr>
<!--
这里本来是想添加用户头像发现太耗费，将来在用户空间之中在添加显示用户头像
								<td>
										<div > 
												<img src="<?=base_url("upload")."/".$temp->user_photo?>"/>
												<a href="<?=site_url("")?>">上传图片</a>
										</div>
								</td>
-->
								<td class="user"><?php echo $temp->user_id?></td>
								<td class="user"><?php echo $temp->user_level?></td>
								<td class="tm"><?php echo $temp->user_name?></td>
							  <td class="passwd"><?php echo $temp->user_passwd ?></td>
								<td class="data"><?php echo $temp->reg_time?></td>
								<td class="user"><?php echo $temp->block?></td>
								<td class="data"><a href="<?=site_url("bg/userlist/userDel")."/".$temp->user_id?>">删除</a>|<a href="<?=site_url("bg/userlist/userBlock")."/".$temp->user_id?>">冻结</a></td>
					</tr>
				<?php endforeach?>
				</table>
			
	</body>
		<!--  E - body -->
</html>
