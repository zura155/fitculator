<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../Models/dictionaries.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once (__DIR__ ."/../vendor/autoload.php");

class send_message
{
	public $from='';
	public $from_name='';
	public $replay_to='';
	public $to='';
	public $cc='';
	public $bcc='';
	//public $replay_to='';
	public $attachment_url='';
	public $attachement_file_name='';
	public $string_attachment_file_url='';
	public $string_attachment_file_name='';// 'MyMenu.pdf';
	public $subject='';
	public $message='';
	private $password='Yxgl,C307xBR';   //იუზერი საიდან უნდა გააგზავნოს ბაზიდან იღებს. პაროლი აქ არის ხელით გაწერილი
	
	private $database;
	private $dictionary;
	private $mail;
	/*function __construct()
	{
		$this->database=new data;
		$this->dictionary=new dictionaries;
		$this->Loging=new Loging;
	}*/
	function __construct($database)
	{
		$this->database=$database;
		$this->dictionary=new dictionaries($database);
		$this->Loging=new Loging($database);
		$this->mail = new PHPMailer(true);
	}
	public function send_mail()
	{
		try {
			//Server settings
			//$this->mail->SMTPDebug = 2;                                       // Enable verbose debug output
			$this->mail->isSMTP();                                            // Set mailer to use SMTP
			$this->mail->Host       = /*'smtp.gmail.com';*/substr($this->from, strpos($this->from, "@") + 1);  //'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
			$this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$this->mail->Username   = $this->from;//'user@example.com';                     // SMTP username
			$this->mail->Password   = $this->password;//'secret';                               // SMTP password
			$this->mail->SMTPSecure ='tls';                                  // Enable TLS encryption, `ssl` also accepted
			$this->mail->Port       = 587;                                    // TCP port to connect to

			//Recipients
			$this->mail->setFrom($this->from, $this->from_name);
			$this->mail->clearAddresses();
			$this->mail->addAddress($this->to, $this->to);     // Add a recipient
			//$mail->addAddress('ellen@example.com');               // Name is optional
            $this->mail->clearReplyTos();
			if($this->replay_to=='')
			{
				$this->mail->addReplyTo($this->from, $this->from);
			}
			else
			{
				$this->mail->addReplyTo($this->replay_to, $this->from_name);
			}
            $this->mail->clearCCs();
			if(isset($this->cc) && trim($this->cc)!='')
			{
				$this->mail->addCC($this->cc);
			}
            $this->mail->clearBCCs();
			
			//add bcc mails
			$bcc_array=explode(',',$this->bcc);
			foreach($bcc_array as $item)
			{
				$this->mail->addBCC($item);
			}
				
			//$this->mail->addBCC($this->bcc);

			// Attachments
			/*echo '<img src="src/attachments/courier.jpg">';*/
			if($this->attachment_url!='')
			{
				//$this->mail->addAttachment($_SERVER["DOCUMENT_ROOT"].'/Fitculator/src/attachments/courier.jpg');
				$this->mail->addAttachment($_SERVER["DOCUMENT_ROOT"].$this->attachment_url,$this->attachement_file_name);
			}
			//pdf-ის გასაგზავნად
			if($this->string_attachment_file_url!='')
			{
				//$url='http://localhost/fitculator/menu_pdf.php';//pdf string
				$this->mail->addStringAttachment(file_get_contents($this->string_attachment_file_url), $this->string_attachment_file_name);
			}

			/*$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name*/

			// Content
			$this->mail->CharSet = 'UTF-8';
			$this->mail->isHTML(true);                                  // Set email format to HTML
			$this->mail->Subject = $this->subject;
			$this->mail->Body    = $this->message;
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$this->mail->send();
			//echo 'Message has been sent';
		} 
		catch (Exception $e) 
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage().' '.$this->mail->ErrorInfo);
			exit;
			//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			//throw $e;
		}
		
		
		
	}
	public function get_mail_system_info($Action)
	{
		
		try
		{
			if (!($stmt = $this->database->mysqli->prepare("select  * from mail_system where Action=?"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("s", $Action)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			/*$query='select  * from mail_system where Action="'.$Action.'"';
			$res=$this->database->mysqli->query($query);*/
			$row = $res->fetch_assoc();
			$stmt->close();
			$this->from=$row['From_Email'];
			$this->from_name=$row['From_Name'];
			$this->cc=$row['CC_Emails'];
			$this->bcc=$row['BCC_Emails'];
			//$this->replay_to=$row['From_Email'];Subject_Dictionary_Key
			$this->subject=$this->dictionary->get_text($row['Subject_Dictionary_Key']);
			$this->message=$this->dictionary->get_text($row['Message_Dictionary_Key']);
			
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
		}
	}
	
	
	public function get_mail_system_info1($Action,$array1,$array2)
	{
		
		try
		{
			if (!($stmt = $this->database->mysqli->prepare("select  * from mail_system where Action=?"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("s", $Action)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			/*$query='select  * from mail_system where Action="'.$Action.'"';
			$res=$this->database->mysqli->query($query);*/
			$row = $res->fetch_assoc();
			$stmt->close();
      if($row["ID"]>0)
      {
        $this->from=$row['From_Email'];
        $this->from_name=$row['From_Name'];
        $this->cc=$row['CC_Emails'];
        $this->bcc=$row['BCC_Emails'];
        //$this->replay_to=$row['From_Email'];Subject_Dictionary_Key
        $this->subject=$this->dictionary->get_text($row['Subject_Dictionary_Key']);
        $text=$this->dictionary->get_text($row['Message_Dictionary_Key']);
        $this->message=$this->change_text($text,$array1,$array2);
      }
	
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
		}
	}
	
	
	public function get_mail_system_info_new($Action,$array1,$array2,$language) //ენის მიხედვით აგზავნის მეილს
	{
		
		try
		{
			if (!($stmt = $this->database->mysqli->prepare("select  * from mail_system where Action=?"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("s", $Action)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			/*$query='select  * from mail_system where Action="'.$Action.'"';
			$res=$this->database->mysqli->query($query);*/
			$row = $res->fetch_assoc();
			$stmt->close();
      if($row["ID"]>0)
      {
        $this->from=$row['From_Email'];
        $this->from_name=$row['From_Name'];
        $this->cc=$row['CC_Emails'];
        $this->bcc=$row['BCC_Emails'];
        //$this->replay_to=$row['From_Email'];Subject_Dictionary_Key
        $this->subject=$this->dictionary->get_text_by_language($row['Subject_Dictionary_Key'],$language);
        $text=$this->dictionary->get_text_by_language($row['Message_Dictionary_Key'],$language);
        $this->message=$this->change_text($text,$array1,$array2);
		  
      }
	
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	public function prepare_email()
	{
		try
		{
			$from1=/*$this->from_name.' ' . */$this->from;
			if (!($stmt = $this->database->mysqli->prepare("insert into email_out (	Subject,Message,From_Email,To_Email,Cc,Bcc) values (?,?,?,?,?,?)"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("ssssss", $this->subject,$this->message,$from1,$this->to,$this->cc,$this->bcc)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			else
			{
				echo "შეტყობინება იგზავნება. ";
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			exit;
		}
	}
	
	public function send_mail1($to,$subject,$message,$from,$cc,$bcc)
	{
		/*try{
		// To send HTML mail, the Content-type header must be set
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';

		// Additional headers
		//$headers[] = 'To: '.$this->to;
		$headers[] = 'From: '.$from;
		$headers[] = 'Cc: '.$cc;
		$headers[] = 'Bcc: '.$bcc;
			
			//echo $this->message;
		mail($to, $subject, html_entity_decode($message), implode("\r\n", $headers));
			return true;
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			exit;
		}*/
		
		try {
			$this->to=$to;
			$this->subject=$subject;
			$this->message=$message;
			$this->from=$from;
			$this->cc=$cc;
			$this->bcc=$bcc;
			$this->from_name="SpaceCargo";
			$this->send_mail();
			
			return true;
			/*old
			$from_name="SpaceCargo";
			//Server settings
			//$this->mail->SMTPDebug = 2;  
			//$this->mail->SMTPDebug = 3;// Enable verbose debug output
			$this->mail->isSMTP();                                            // Set mailer to use SMTP
			$this->mail->Host        =$from; // substr($this->from, strpos($this->from, "@") + 1);// //$this->from; //'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
			$this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$this->mail->Username   = $from;//'user@example.com';                     // SMTP username
			$this->mail->Password   = $this->password;//'secret';                               // SMTP password
			$this->mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
			$this->mail->Port       = 587;                                    // TCP port to connect to

			//Recipients
			$this->mail->setFrom($from, $from_name);
			$this->mail->clearAddresses();
			$this->mail->addAddress($to, $to);     // Add a recipient
			//$mail->addAddress('ellen@example.com');               // Name is optional
            $this->mail->clearReplyTos();
			$this->mail->addReplyTo($from, $from);
			$this->mail->clearCCs();
			if(isset($cc) && trim($cc)!='')
			{
				$this->mail->addCC($cc);
			}
			$this->mail->clearBCCs();
			$bcc_array=explode(',',$bcc);
			foreach($bcc_array as $item)
			{
				if(isset($item) && trim($item)!='')
				{
					$this->mail->addBCC($item);
				}
			}
			

			// Attachments
			/*$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			// Content
			$this->mail->CharSet = 'UTF-8';
			$this->mail->isHTML(true);                                  // Set email format to HTML
			$this->mail->Subject = $subject;
			$this->mail->Body    = $message;
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$this->mail->send();
			//echo 'Message has been sent';
			*/
		} 
		catch (Exception $e) 
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage().' '.$this->mail->ErrorInfo);
			exit;
			//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
	
	function send_new_email()
	{
		try
		{
			
			if (!($stmt = $this->database->mysqli->prepare("select * from system_jobs where Name='Email' and  Status='A' limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res3 = $stmt->get_result();
			$row3 = $res3->fetch_assoc();
			$stmt->close();
			if($row3["ID"]>0)
			{
	
				if (!($stmt = $this->database->mysqli->prepare("select  * from email_out where Status='N' order by ID limit 10"))) 
				{
					throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
				}
				if (!$stmt->execute()) 
				{
					throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();
				$stmt->close();


				//თუ მომხმარებელი მოიძებნა
				if($row["ID"]>0)
				{
					foreach($result as $res)
					{
						try
						{
							//გაგზავნა
							$response_string=$this->send_mail1($res["To_Email"],$res["Subject"],$res["Message"],$res["From_Email"],$res["Cc"],$res["Bcc"]);

							//echo "<br/>aaaaaaaaaaaaaaaaaa<br/>". $response->{"code"}." ".$response->{"message"};
							if($response_string)
							{
								$status='S'; 
							}
							else
							{
								$status='E';
							}
							$ID=$res["ID"];
							$current_time=date('Y-m-d H:i:s', time());
							if (!($stmt = $this->database->mysqli->prepare("update email_out set Status=?, Send_date=? where ID=?"))) 
							{
								throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
							}
							if (!$stmt->bind_param("ssi", $status,$current_time,$ID)) 
							{
								throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
							}
							if (!$stmt->execute()) 
							{
								throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
							}
							echo "ჯობმა იმუშავა";
							$stmt->close();
						}
						catch(Exception $e)
						{
							$status='E';
							$ID=$res["ID"];
							$current_time=date('Y-m-d H:i:s', time());
							if (!($stmt = $this->database->mysqli->prepare("update email_out set Status=?, Send_date=? where ID=?"))) 
							{
								throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
							}
							if (!$stmt->bind_param("ssi", $status,$current_time,$ID)) 
							{
								throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
							}
							if (!$stmt->execute()) 
							{
								throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
							}
							//echo "shesrulda";
							$stmt->close();
							$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
							exit;
						}
					}
				}
				else
				{
					echo "ჯობმა იმუშავა";
				}
			}
			else
			{
				echo "ჯობი შეჩერებულია";
				throw new Exception("ჯობი შეჩერებულია");
			}
			
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			exit;
		}
	}
	
	public function try_send_email()
	{
		
		try
		{
			$this->send_mail();
			$from1=/*$this->from_name.' ' . */$this->from;
			$status='S';
			$current_time=date('Y-m-d H:i:s', time());
			if (!($stmt = $this->database->mysqli->prepare("insert into email_out (	Subject,Message,From_Email,To_Email,Cc,Bcc,attachment_url,attachement_file_name,string_attachment_file_url,string_attachment_file_name,Status,Send_date) values (?,?,?,?,?,?,?,?,?,?,?,?)"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("ssssssssssss", $this->subject,$this->message,$from1,$this->to,$this->cc,$this->bcc,$this->attachment_url,$this->attachement_file_name,$this->string_attachment_file_url,$this->string_attachment_file_name,$status,$current_time)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			else
			{
				//echo "შეტყობინება იგზავნება. ";
			}
			$stmt->close();
			
		}
		catch(Exception $e)
		{
			try
			{
				$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
				//exit;
				$from1=/*$this->from_name.' ' . */$this->from;
				$status='N';
				if (!($stmt = $this->database->mysqli->prepare("insert into email_out (	Subject,Message,From_Email,To_Email,Cc,Bcc,attachment_url,attachement_file_name,string_attachment_file_url,string_attachment_file_name,Status) values (?,?,?,?,?,?,?,?,?,?,?)"))) 
				{
					throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
				}
				if (!$stmt->bind_param("sssssssssss", $this->subject,$this->message,$from1,$this->to,$this->cc,$this->bcc,$this->attachment_url,$this->attachement_file_name,$this->string_attachment_file_url,$this->string_attachment_file_name,$status)) 
				{
					throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				if (!$stmt->execute()) 
				{
					throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				else
				{
					echo "შეტყობინება იგზავნება. ";
				}
				$stmt->close();
			}
			catch(Exception $e1)
			{
				$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e1->getMessage());
				exit;
			}
		}
	
	}
  
  function change_text($text,$array1,$array2)
	{
		try
		{
			if(isset($array1) && isset($array2) && sizeof($array1)==sizeof($array2))
			{
				/*str_replace(
				array("search","items"),
				array("replace", "items"),
				$string
				);*/
				return str_replace($array1,$array2,$text);
			}
			else
			{
				throw new Exception( "სმს შეტყობინებაში ცვლადები ვერ შეიცვალა რადგან პარამეტრების რაოდენობა არ ემთხვევა არგუმენტების რაოდენობას");
			}
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			//exit;
			throw $e;
		}
	}
}
?>