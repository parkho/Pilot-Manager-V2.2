<?php
class Pilotmanager extends CodonModule
{
	public function NavBar()
        {
                echo '<li><a href="'.SITE_URL.'/admin/index.php/Pilotmanager">Pilot Manager</a></li>';
        }
	
	public function index() 
	    {
			$revision = trim(file_get_contents(CORE_PATH.'/version'));
			if($revision != 'simpilot 5.5.2')
				{
					echo '<center>phpVMS Version Installed Is Not Compatible With This Module!</center><br />';
					echo '<center>phpVMS Version Installed: '.$revision.'</center>';
				}
			else
			{
				$this->set('title', 'Pilot Manager');
				$this->set('pilots', PilotData::getAllPilots());
				$this->show('/pm/pilot_manager.php');
			}
        }
        
        public function savepro()
         {
          if ($this->post->firstname == '' || $this->post->lastname == '')
                {
                    $this->set('message', 'The first or lastname cannot be blank!');
                    $this->render('core_error.tpl');
                    return;
                }

                $params = array(
                    'firstname' => $this->post->firstname, 
                    'lastname' => $this->post->lastname, 
                    'email' => $this->post->email, 
                    'hub' => $this->post->hub, 
                    'retired' => $this->post->retired, 
                    'totalflights' => $this->post->totalflights, 
                    'totalpay' => floatval($this->post->totalpay), 
                    'transferhours' => $this->post->transferhours, 
                   );

                PilotData::updateProfile($this->post->pilotid, $params);
                PilotData::SaveFields($this->post->pilotid, $_POST);

                /* Don't calculate a pilot's rank if this is set */
                if (Config::Get('RANKS_AUTOCALCULATE') == false) {
                    PilotData::changePilotRank($this->post->pilotid, $this->post->rank);
                } else {
                    RanksData::calculateUpdatePilotRank($this->post->pilotid);
                }

                StatsData::UpdateTotalHours();

                $this->set('message', 'Profile updated successfully');
                $this->render('core_success.tpl');
                $this->set('pilots', PilotData::getAllPilots());
				$this->render('/pm/pilot_manager.php');
                
                if($this->post->resend_email == 'true') {
                    $this->post->id = $this->post->pilotid;
                    $this->resendemail(false);
                }

                $pilot = PilotData::getPilotData($this->post->pilotid);
                LogData::addLog(Auth::$userinfo->pilotid, 'Updated profile for ' 
                                .PilotData::getPilotCode($pilot->code, $pilot->pilotid) 
                                .' '.$pilot->firstname.' '.$pilot->lastname);

                return;
                break;
        }       
	
	public function emails()
		{
			$this->set('title', 'Pilot Manager');
			$email = $this->post->email;
			$send = $this->post->send;
			Template::Set('send', $send);
			
			if($send == "warning")
				{
					$pilotinfo = PManagerData::getpilotbyemail($email);
					$pilot = $pilotinfo->pilotid;
					Template::Set('pilot', PManagerData::getpilotbyemail($email));
					Template::Set('subject', 'Account termination Warning!!');
					Template::Set('email', $email);
					$subject = "Account termination Warning!!";
					$message = Template::Get('/pm/email_warning.php', true);
					Template::Set('message', $message);
					Util::SendEmail($email, $subject, $message);
					PManagerData::warningsent($pilot, $message);
					$this->show('/pm/email_confirm.php');
				}
			if($send == "welcome")
				{
					$pilotinfo = PManagerData::getpilotbyemail($email);
					$pilot = $pilotinfo->pilotid;
					Template::Set('pilot', PManagerData::getpilotbyemail($email));
					Template::Set('subject', 'Welcome!!');
					Template::Set('email', $email);
					$subject = "Welcome!!";
					$message = Template::Get('/pm/email_welcome.php', true);
					Template::Set('message', $message);
					Util::SendEmail($email, $subject, $message);
					PManagerData::welcomesent($pilot, $message);
					$this->show('/pm/email_confirm.php');
				}
			
			if($send == "blank")
				{
					$this->set('title', 'Pilot Manager');
					$this->set('email', $email);
					$this->show('/pm/blank_email.php');
				}
		}
	
	public function send_blank()
		{
			$this->set('title', 'Pilot Manager');
			$email = $this->post->blank;
			$subject = $this->post->subject;
			$message = $this->post->message;
			$pilotinfo = PManagerData::getpilotbyemail($email);
			$pilot = $pilotinfo->pilotid;
			Template::Set('pilot', PManagerData::getpilotbyemail($email));
			Template::Set('subject', $subject);
			Template::Set('email', $email);
			Template::Set('message', $message);
			if($subject == '')
				{
					$this->set('title', 'Pilot Manager');
					$this->set('message', 'You must enter a subject!');
					$this->render('core_error.tpl');
					$this->set('email', $email);
					$this->show('/pm/blank_email.php');
					return; 
				}
			if($message == '')
				{
					$this->set('title', 'Pilot Manager');
					$this->set('message', 'You must enter a message!');
					$this->render('core_error.tpl');
					$this->set('email', $email);
					$this->show('/pm/blank_email.php');
					return; 
				}
			Util::SendEmail($email, $subject, $message);
			PManagerData::blanksent($pilot, $message);
			$this->show('/pm/email_confirm.php');
		}
	
	public static function deletePilot()
		{
			$pilotid = $_GET["pilotid"];
			$sql = array();
		
	
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'acarsdata WHERE pilotid='.$pilotid;
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'bids WHERE pilotid='.$pilotid;
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'pireps WHERE pilotid='.$pilotid;
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'pilots WHERE pilotid='.$pilotid;
		
			# These SHOULD delete on cascade, but incase they don't
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'fieldvalues WHERE pilotid='.$pilotid;
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'groupmembers WHERE pilotid='.$pilotid;
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'pirepcomments WHERE pilotid='.$pilotid;
		
			foreach($sql as $query)
			{
				$res = DB::query($query);
			}
			echo '<script type="text/javascript">alert("Pilot is deleted!!");</script>';
			$url = $_SERVER['HTTP_REFERER']; // right back to the referrer page from where you came.
			echo '<meta http-equiv="refresh" content="5;URL=' . $url . '">';
		}
}
?>
