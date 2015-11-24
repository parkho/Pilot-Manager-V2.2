<link type="text/css" rel="stylesheet" href="<?php echo fileurl('lib/css/pagination_parkho.css') ;?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo fileurl('lib/css/pagination.css') ;?>"/>
<link rel="stylesheet" href="./css/style.css" type="text/css" />
<h3><?php echo $title ;?></h3>
<form  name="welcome" method="post" action="<?php echo adminurl('/pilotmanager/send_blank');?>">
<table width="100%" align="center">
<tr>
	<th colspan="2" align="center">Blank Email Form</th>
</tr>
<tr>
	<td width="10%" align="right">To:</td>
	<td align="left"><input type="text" value="<?php echo $email ;?>" disabled="disabled"></td>
</tr>
<tr>
	<td align="right">Subject:</td>
	<td align="left"><input type="text" name="subject" value="" /></td>
</tr>
<tr>
	<td align="right" valign="top">Message:</td>
	<td align="left"><textarea name="message" id="editor" style="width: 400px; height: 150px;"></textarea></td>
</tr>
<tr>
<td align="right" valign="top">&nbsp;</td>
<td align="left">
<input type="hidden" name="blank" value="<?php echo $email ;?>">
<button style="width:100px" type="submit" name="submit" value="Send Email">Send Email</button>
<a href="<?php echo adminurl('/pilotmanager') ;?>"><button type="button" value="Back to Pilot Manager" style="width:200px">Back To Pilot Manager</button></a>
</td>
</tr>
</table>
</form>