<h3><?php echo $title ;?></h3>
<?php
$plts = PManagerData::pilots();
foreach ($plts as $plt)
	{
		$id = $plt->pilotid;
		$check = PManagerData::checkpilot($id);
		
		if(!$check)
			{
				$pid = $plt->pilotid;
				$pfname = $plt->firstname;
				$plname = $plt->lastname;
				PManagerData::createpilot($pid, $pfname, $plname);
			}
	}
?>
<head>
	<link rel="stylesheet" href="./css/style.css" type="text/css" />
	<link type="text/css" rel="stylesheet" href="<?php echo fileurl('lib/css/pagination.css') ;?>"/>
	<link type="text/css" rel="stylesheet" href="<?php echo fileurl('lib/css/pagination_parkho.css') ;?>"/>
	<script type="text/javascript" src="<?php echo fileurl('lib/js/jquery-1.3.1.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo fileurl('lib/js/jquery.tablesorter.js');?>"></script>
	<script type="text/javascript" src="<?php echo fileurl('lib/js/jquery.tablesorter.pager1.js');?>"></script>
	<script type="text/javascript" src="<?php echo fileurl('lib/js/jquery.simplePagination.js') ;?>"></script>
</head>
<body>
<script defer="defer">
	$(document).ready(function() 
    { 
        $("#pilot_edit")
		.tablesorter({widthFixed: true, widgets: ['zebra'], cssStyle: 'light-theme'})
		.tablesorterPager({container: $("#pager")}); 
    } 
	); 
</script>
<table id="pilot_edit" align="center" border="1" width="100%" cellpadding="0" cellspacing="0" >
<thead>
	<tr><td align="center" colspan="14" bgcolor="grey"><font color="white" size="6"><b>Pilot Manager</b></font></td></tr>
		<tr>
			<td align="left" colspan="14">
				<image src="<?php echo SITE_URL ;?>/admin/lib/images/OFF.png"> = Pilot has been retired. 
				<image src="<?php echo SITE_URL ;?>/admin/lib/images/Warning.png"> = Pilot has not filed any reports in 3 days.
				<image src="<?php echo SITE_URL ;?>/admin/lib/images/ON.png"> = Pilot is ok.<br />
			</td>
		</tr>
		<tr>
			<td align="center"><b>ID</b></td>
			<td align="center"><b>Name</b></td>
			<td align="center"><b>HUB</b></td>
			<td align="center"><b>Date Joined</b></td>
			<td align="center"><b>Last Pirep</b></td>
			<td align="center"><b>Last Email Sent</b></td>
			<td align="center"><b>Warning</b></td>
			<td align="center"><b>Welcome</b></td>
			<td align="center"><b>General</b></td>
			<td align="center"><b>Status</b></td> 
			
			
			<td align="center" colspan="3"><b>Options</b></td>			
		</tr>
</thead>
<tbody)
<?php
foreach($pilots as $pilot)
	{
			$pid = $pilot->pilotid;
			$param = PManagerData::param($pid);
			$jtme = strtotime($pilot->joindate);
			$ptme = strtotime($pilot->lastpirep);
			$dtme = strtotime($param->datesent);
			$chk = date("Y", $dtme);
			$thrd = date("m-d", $dtme);
			$trd = date("d", $ptme);
			$dte = date("d");
			$res = $dte - $trd;
?>
		<tr>
			<td align="left"><?php echo $pilot->code.''.$pilot->pilotid ;?></td>
			<td align="left"><?php echo $pilot->firstname.' '.$pilot->lastname ;?></td>
			<td align="center"><?php echo $pilot->hub ;?></td>
			<td align="center"><?php echo date("Y-m-d", $jtme) ;?></td>
			<td align="center"><?php echo date("Y-m-d", $ptme) ;?></td>
			<td align="center">
			<?php 
			if($chk == "-0001")
			{
				echo ' ';
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
			<td align="center"><?php 
			$date0 = date(DATE_FORMAT, strtotime($pilot->lastpirep));
			$date1 = $pilot->lastpirep ;
			
			if($pilot->retired == "1")
			{
			?>
				<image src="<?php echo SITE_URL ;?>/admin/lib/images/OFF.png">
			<?php
			}
			elseif($res >= 03 )
			{
			?>
				<image src="<?php echo SITE_URL ;?>/admin/lib/images/Warning.png">
			<?php
			}
			else
			{
			?>
				<image src="<?php echo SITE_URL ;?>/admin/lib/images/ON.png">
			<?php
			}
			?>
			</td>			
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
			<td align="center">
			<button type="button" Value="Edit" onclick="$('#pilot_<?php echo $pilot->pilotid;?>').toggle()">Edit</button>
		
			</td>
			<td align="center">
			<?php
			if(PilotGroups::group_has_perm(Auth::$usergroups, FULL_ADMIN)) 
				{
					$pilotid = $pilot->pilotid;
			?>
			<form id="deletepilot" method="get" action="<?php echo adminurl('/pilotmanager/deletePilot');?>">
			<input type="hidden" name="pilotid" value="<?php echo $pilotid ;?>" />
			<button type="submit" name="submit" value="Delete" onclick="return doublecheck()" ;?>Delete</button>
			</form>
			<?php
				}
			?>
			</td>
		</tr>
		<tr id="pilot_<?php echo $pilot->pilotid;?>" style="display:none">
		<td colspan="10" align="center" style="width:100%">
		<form method="post" action="<?php echo adminurl('/pilotmanager/savepro');?>">
		<table>
		<tr>
		 <td align="right"><b>First Name:</b></td>
		 <td><input type="text" name="firstname" value="<?php echo $pilot->firstname;?>" /></td>
		</tr>
		<tr>		 
		 <td align="right"><b>Last Name:</b></td>
		 <td><input type="text" name="lastname" value="<?php echo $pilot->lastname;?>" /></td>
		</tr>
		<tr>
		 <td align="right"><b>Airline:</b></td>
		 <td>
		  <select name="code">
		  <?php
		  $allairlines = OperationsData::GetAllAirlines();
		  foreach($allairlines as $airline)
		   {
		    if($pilot->code == $airline->code)
			$sel =  ' selected';
		    else
		 	$sel = '';
		    echo '<option value="'.$airline->code.'" '.$sel.'>'.$airline->name.'</option>';
		   }
		  ?>	
		  </select>
		 </td>
		</tr>
		<tr>
		 <td align="right"><b>Transfer Hours:</b></td>
		 <td><input type="text" name="transferhours" value="<?php echo $pilot->transferhours;?>" /></td>
		</tr>
		<tr> 
		 <td align="right"><b>Hub:</b></td>
		 <td>
		  <select name="hub">
		  <?php
		  $allhubs = OperationsData::GetAllHubs();
		  foreach($allhubs as $hub)
		   {
		    if($pilot->hub == $hub->icao)
		        $sel = ' selected';
		    else
			$sel = '';
		    echo '<option value="'.$hub->icao.'" '.$sel.'>'.$hub->icao.' - ' . $hub->name .'</option>';
		   }
                  ?>	
		  </select>
		 </td>
		</tr>
		<tr>
		 <td align="right"><b>Total Flights:</b></td>
		 <td><input type="text" name="totalflights" value="<?php echo $pilot->totalflights;?>" /></td>
		</tr>
		<tr> 
		 <td align="right"><b>Total Pay:</b></td>
		 <td><input type="text" name="totalpay" value="<?php echo $pilot->totalpay;?>" /></td>
		</tr>
		<tr> 
		 <td align="right"><b>Pilot active:</b></td>
		 <td>
		  <?php 
		  if(intval($pilot->retired) == 1) 
		   {  
		    $retsel='selected'; 
		    $activesel = ''; 
		   }
		  else
		   {
		    $activesel = 'selected'; 
		    $retsel = '';
		   }
		  ?>
		  <select name="retired">
		   <option value="0" <?php echo $activesel?>>Active</option>
		   <option value="1" <?php echo $retsel?>>Inactive</option>
		  </select>
		 </td>
		</tr>
		<tr> 
		 <td align="right"><b>Email Address:</b></td>
		 <td><input type="text" name="email" value="<?php echo $pilot->email;?>" /></td>
		</tr>
		<tr>
		 <td align="center" colspan="2">
		  <input type="hidden" name="pilotid" value="<?php echo $pilot->pilotid;?>" />
		  <input type="hidden" name="action" value="saveprofile" />
		   <button style="width:200px" type="submit" name="submit" value="Save Changes" />Save Changes</button>
		 </td>
		</tr>
		</table>
	        </form>
	        </td>
	        </tr>
				
<?php
}
?>

<script type="text/javascript">
function doublecheck()
{
	var answer = confirm("Are you sure you want to delete the pilot?")
	if (answer) {
		return true;
	}
	
	return false;
}
</script>
</tbody>
</table>
<div align="center" id="pager" class="pager">
	<table width="100%" align="center">
	<form>
		<tr>
			<td align="center">
			<input type="button" value="First" class="first"/>
			<input type="button" value="Previous" class="prev"/>
			<input type="button" class="pagedisplay" disabled="disabled">
			<input type="button" value="Next" class="next"/>
			<input type="button" value="Last" class="last"/><input type="hidden" value="5" class="pagesize">
			</td>
		</tr>
	</form>
	</table>
</div>
</body>	
