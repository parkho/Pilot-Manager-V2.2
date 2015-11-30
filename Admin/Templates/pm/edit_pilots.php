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
		<td><b>Airline</b></td>
		<td><b>Transfer Hours</b></td>
		<td><b>HUB</b></td>
		<td><b>Flights</b></td>
		<td><b>Total Pay</b></td>
		<td align="center" colspan="3"><b>Options</b></td>			
	</tr>
<?php
foreach($pilots as $pilot)
	{
?>
	<tr>
		<td align="left"><?php echo $pilot->firstname.' '.$pilot->lastname ;?></td>
		<td align="left">
		<?php 
			$sql = "SELECT * FROM phpvms_airlines WHERE code = '$pilot->code'";
			$airline = DB::get_row($sql);
			echo $airline->name;
		?>
		</td>
		<td><?php echo $pilot->transferhours; ?></td>
		<td><?php echo $pilot->hub; ?></td>
		<td><?php echo $pilot->totalflights; ?></td>
		<td><?php echo $pilot->totalpay; ?></td>
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
		<td colspan="13" align="center" style="width:100%">
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
	
</table>
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
