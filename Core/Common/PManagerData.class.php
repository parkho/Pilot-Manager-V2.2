<?php
class PManagerData extends CodonData
{
	public static function pilots()
	{
		$sql="SELECT * FROM phpvms_pilots";
		
		return DB::get_results($sql);
	}
	
	public static function getpilotbyemail($email)
	{
		$sql="SELECT * FROM phpvms_pilots WHERE email = '$email' ";
		
		return DB::get_row($sql);
	}
	
	public static function checkpilot($id)
	{
		$sql="SELECT * FROM pilot_manager WHERE pid = '$id' ";
		
		return DB::get_row($sql);
	}
	
	public static function createpilot($pid, $pfname, $plname)
	{
		$sql = "INSERT INTO pilot_manager (pid, pfname, plname, blank, warning, welcome, message, datesent) 
								  VALUES ('$pid', '$pfname', '$plname', '0', '0', '0', 'welcome', '')";
			DB::query($sql);
	}
	
	public static function param($pid)
	{
		$sql="SELECT * FROM pilot_manager WHERE pid = '$pid'";
		
		return DB::get_row($sql);
	}
	
	public static function getpirep($pilotid)
	{
		$sql="SELECT * FROM phpvms_pireps WHERE pilotid = '$pilotid' ORDER BY submitdate DESC";
		
		return DB::get_row($sql);
	}
	
	public static function warningsent($pilot, $message)
		{
			$sent = self::param($pilot);
			$sen = $sent->warning;
			$sql = "UPDATE pilot_manager SET warning='$sen' + '1', message='$message', datesent=NOW() WHERE pid='$pilot'";
			
			DB::query($sql);
		}
		
	public static function welcomesent($pilot, $message)
		{
			$sent = self::param($pilot);
			$sen = $sent->welcome;
			$sql = "UPDATE pilot_manager SET welcome='$sen' + '1', message='$message', datesent=NOW() WHERE pid='$pilot'";
			DB::query($sql);
		}
	
	public static function blanksent($pilot, $message)
		{
			$sent = self::param($pilot);
			$sen = $sent->blank;
			$sql = "UPDATE pilot_manager SET blank='$sen' + '1', message='$message', datesent=NOW() WHERE pid='$pilot'";
			DB::query($sql);
		}
}
?>