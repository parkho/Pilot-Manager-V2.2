<link type="text/css" rel="stylesheet" href="<?php echo fileurl('lib/css/pagination.css') ;?>"/>
	<link type="text/css" rel="stylesheet" href="<?php echo fileurl('lib/css/pagination_parkho.css') ;?>"/>
<style type="text/css">
td{
	padding-left: 10px;
}
</style>
<table align="center" border="1" width="100%" cellpadding="0" cellspacing="0" >
		<tr>
			<td><b>Name</b></td>
			<td><b>Last Pirep</b></td>
			<td><b>Last Email Sent</b></td>
			<td align="center"><b>Warning</b></td>
			<td align="center"><b>Welcome</b></td>
			<td align="center"><b>General</b></td>
			<td align="center"><b>Send Email</b></td>
		</tr>
<?php
foreach($pilots as $pilot)
	{
			$pid = $pilot->pilotid;
			$param = PManagerData::param($pid);
			$ptme = strtotime($pilot->lastpirep);
			$dtme = strtotime($param->datesent);
			$chk = date("Y", $dtme);
			$chk1 = date("Y", $ptme);
			$thrd = date("m-d", $dtme);
			$trd = date("d", $ptme);
			$dte = date("d");
			$res = $dte - $trd;
?>
		<tr>
			<td><?php echo $pilot->firstname.' '.$pilot->lastname ;?></td>
			<td>
			<?php 
			if($chk1 == "-0001")
			{
				echo ' None ';
			}
			else
			{
				echo date("Y-m-d", $ptme) ;
			}
			?>
			</td>
			<td>
			<?php 
			if($chk == "-0001")
			{
				echo ' None ';
			}
			else
			{
				echo date("Y-m-d h:ia", $dtme) ;
			}	
			?>
			</td>
			<td title="Warning Email Sent On <?php echo $param->datesent;?>" align="center"><b><font size="3" color="red"><?php echo $param->warning;?></font></b></td>
			<td title="Warning Email Sent On <?php echo $param->datesent;?>" align="center"><b><font size="3" color="red"><?php echo $param->welcome;?></font></b></td>
			<td title="Warning Email Sent On <?php echo $param->datesent;?>" align="center"><b><font size="3" color="red"><?php echo $param->blank ;?></font></b></td>
			<td align="center">
			<form  name="warning" method="post" action="<?php echo adminurl('/pilotmanager/emails');?>">
			<select name="send">
				<option value="blank">Blank Email</option>
				<option value="warning">Warning Email</option>
				<option value="welcome">Welcome Email</option>
			</select>
			<input name="email" type="hidden" Value="<?php echo $pilot->email ;?>">
			&nbsp;&nbsp;&nbsp;<button type="submit" value="submit">Send</button>
			</form>
			</td>
		</tr>
<?php
}
?>
</table>