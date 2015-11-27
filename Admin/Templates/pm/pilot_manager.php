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

<link type="text/css" rel="stylesheet" href="http://onlinehtmltools.com/tab-generator/skins/skin6/top.css"></script>
<div style="border-radius: 10px;" class="FlightInformation">
 <ul style="text-align:center;">
  <li style="border-radius: 10px;" class="tab_selected"><a style="text-decoration: none;" href="#pi">Pilot Information</a></li>
  <li style="border-radius: 10px;"><a style="text-decoration: none;" href="#se">Send Email</a></li>
  <li style="border-radius: 10px;"><a style="text-decoration: none;" href="#dp">Edit Pilots</a></li>
 </ul>
 <div style="height: 100%; border-radius: 10px;" class="content_holder">
  <div id="pi"><?php Template::show('pm/pilot_information.php');?></div>
  <div id="se"><?php Template::show('pm/send_email.php');?></div>
  <div id="dp"><?php Template::show('edit_pilots.php');?></div>
 </div>
</div>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://onlinehtmltools.com/tab-generator/skinable_tabs.min.js"></script>
<script type="text/javascript">
$('.FlightInformation').skinableTabs({
    effect: 'simple_fade',
    skin: 'skin6',
    position: 'top'
  });
</script>
