<style type="text/css">
td{
	padding-left: 10px;
}
</style>

<table align="center" border="1" width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td><b>ID</b></td>
		<td><b>Name</b></td>
		<td><b>HUB</b></td>
		<td><b>Location</b></td>
		<td><b>Total Hours</b></td>
		<td><b>Rank</b></td>
		<td><b>Date Joined</b></td>
		<td><b>Status</b></td> 
	</tr>
<?php
			$days = Config::Get('PILOT_INACTIVE_TIME');
foreach($pilots as $pilot)
	{
			$pid = $pilot->pilotid;
			$param = PManagerData::param($pid);
			$jtme = strtotime($pilot->joindate);
			$ptme = strtotime($pilot->lastpirep);
			$trd = date("d", $ptme);
			$dte = date("d");
			$res = $dte - $trd;
?>
	<tr>
		<td><?php echo $pilot->code.''.$pilot->pilotid ;?></td>
		<td><?php echo $pilot->firstname.' '.$pilot->lastname ;?></td>
		<td><?php echo $pilot->hub ;?></td>
		<td><?php echo $pilot->location ;?></td>
		<td><?php echo $pilot->totalhours ;?></td>
		<td><?php echo $pilot->rank ;?></td>
		<td><?php echo date("Y-m-d", $jtme) ;?></td>
		<td>
			<?php 
			$date0 = date(DATE_FORMAT, strtotime($pilot->lastpirep));
			$date1 = $pilot->lastpirep ;
			
			if($pilot->retired == "1")
			{
				echo '<font color="red">Retired</font>';
			}
			elseif($res >= $days)
			{
				echo '<font color="orange">No Reports Over '.$days.' Days</font>';
			}
			else
			{
				echo '<font color="green">Okay</font>';
			}
			?>
		</td>			
	</tr>
<?php
}
?>
</table>
