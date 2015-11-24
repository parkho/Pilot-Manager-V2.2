<h3><?php echo $title ;?></h3>
<table class="balancesheet" width="50%" align="center">
	<tr class="balancesheet_header">
		<td align="center">Email Confirmation</td>
	</tr>
	<tr>
		<th align="center">Recipient Information</th>
	</tr>
		<td>Recipient First Name: <b><?php echo $pilot->firstname ;?></td>
	<tr>
	</tr>
		<td>Recipient Last Name: <b><?php echo $pilot->lastname ;?></td>
	<tr>
	</tr>
		<td>Recipient Email Address: <b><?php echo $email ;?></td>
	<tr>
	</tr>
		<td>Email Subject: <b><?php echo $subject ;?></td>
	<tr>
	</tr>
		<td>Email Message: <b><?php echo $message ;?></td>
	</tr>
	<tr>
	<td>Confirmation email was sent on <b><?php echo date("d/m/y - H:i:s", time()) ;?></b>.</td>
	</tr>
	<tr>
		<td align="center"><a href="<?php echo adminurl('/pilotmanager') ;?>"><input type="button" value="Back to Pilot Manager"></a></td>
	</tr>
</table>