<?php
$pilotid = $pilot->pilotid;
$pirp = PManagerData::getpirep($pilotid);
$pir = $pirp->submitdate;
?>
<p>Dear <?php echo $pilot->firstname.' '.$pilot->lastname ;?>,</p>
<p>You are required to submit one PIREP every day.  
<?php 
if(!$pir)
{
	echo'You have not filed any PIREPS Yet!';
}
else
{
	echo 'Your last PIREP was sent on.'.$pir;
}
	 
?>
</p>
<p>Please be advised if you do not send a report within the next 2 days your account will be deleted.</p>
<p>Sincerely</p>
<p><?php echo SITE_NAME ;?> - Staff</p>