<!doctype html>	
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="<?=base_url("common_content.css")?>">
		<style type="text/css">
		table{
				table-layout: fixed;
			white-space: nowrap;
			width: 100%;
			border-top: 1px solid #ccc;
			font-size: 16px;
				text-align:center;
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
		</style>
		
	</head>
		<!--  S - body -->
	<body>
			
				<table cellspacing="0" class="mail-box">
						<tr>
							<th class="user">用户名</th>
							<th class="id">用户id</th>
							<th class="id">冻结状态</th>
							<th class="time">注册时间</th>
							<th class="action">操作</th>
						</tr>
					<?php foreach($blockAll as $temp):?>
						<tr>
								<td class="user"><?php echo $temp->user_name?></td>
								<td class="id"><?php echo $temp->user_id?></td>
								<td class="id"><?php echo $temp->block?></td>
							  <td class="time"><?php echo $temp->reg_time ?></td>
								<td class="action"><a href="<?=site_url("bg/blocklist/enable/$temp->user_id")?>">解冻</a></td>
					</tr>
				<?php endforeach?>
				</table>
			
	</body>
		<!--  E - body -->
</html>
