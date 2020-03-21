<?php
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../myfunctions/myfunction.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once( __DIR__ . "/../Models/result.php");
require_once( __DIR__ . "/../Models/myexeptions.php");
require_once( __DIR__ . "/../Models/dictionaries.php");
//კლასის აღწერა
class users
{
	public $ID;
	public $facebook_id;
	public $first_name;
	public $last_name;
	public $gender;
	public $email;
	public $picture;
	public $status;
	//ბაზასთან კავშირისთვის ცვლადი:
	public $database;
	//ლოგირების ცვლადი
	public $Loging;
	//json
	public $result;
	//შეცდომების გამოსატანი ცლასისთვის და დასალოგი
	public $myexception;
	public $dictionary;
	
	function __construct($database)
	{
		$this->database=$database;
		$this->Loging=new Loging($database);
		$this->result=new result($database);
		$this->dictionary=new dictionaries($database);
		$this->myexception=new myexception($database);
	}
	function check_user($user_id,$facebook_id) //შემოწმება Users-ში არის თუ არა ჩანაწერი
	{
		try
		{
			if(IsNullOrEmptyString($user_id) && IsNullOrEmptyString($facebook_id))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
				//echo $this->dictionary->get_text($this->dictionary->get_text("text.required"));
				//throw new Exception($this->dictionary->get_text($this->dictionary->get_text("text.required")));
			}
			
			if (!($stmt = $this->database->mysqli->prepare("select * from users where ID=? or facebook_id=?  limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("is",$user_id,$facebook_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			$stmt->close();
			if(isset($row["ID"]) && $row["ID"]>0)
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function login_log($facebook_id)
	{
		try
		{
			
			if(IsNullOrEmptyString($facebook_id))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
		
			if (!($stmt = $this->database->mysqli->prepare("select  * from users a where facebook_id=? and Status='A' limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("i", $facebook_id)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			if(isset($row["ID"]) && $row["ID"]>0)
			{
				//ავტორიზაციის ლოგირება (წარმატებული)
				$query="insert into user_login_hist (User_ID,Session_ID,IP_Address,Status,Error_Message)
				values(?,?,?,?,?)";
				$session_value=session_id();
				$ip=get_client_ip();
				$user_id=$row["ID"];
				$Status='S';
				$Error='';

				if (!($stmt1 = $this->database->mysqli->prepare($query))) 
				{
					throw new Exception("Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
				}
				if (!$stmt1->bind_param("issss", $user_id,$session_value,$ip,$Status,$Error  ))
				{
					throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				if (!$stmt1->execute()) 
				{
					throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				$stmt1->close();
				//return true;
			}
			else
			{
				//ავტორიზაციის ლოგირება (წარუმატებელი)
				$query="insert into user_login_hist (User_ID,Session_ID,IP_Address,Status,Error_Message)
				values(?,?,?,?,?)";
				$session_value=session_id();
				$ip=get_client_ip();
				$system_user=1;
				$Status='E';
				$Error='მონაცემები არაკორექტულია ან მომხმარებელი დაბლოკილია: '.$facebook_id;

				if (!($stmt1 = $this->database->mysqli->prepare($query))) 
				{
					throw new Exception("Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
				}
				if (!$stmt1->bind_param("issss",$system_user,$session_value,$ip,$Status,$Error))  //1 system user 
				{
					throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				if (!$stmt1->execute()) 
				{
					throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				$stmt1->close();
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	
	function login_or_registration($facebook_id,$first_name,$last_name,$gender,$email,$picture)
	{
		try
		{
			if(IsNullOrEmptyString($facebook_id) || IsNullOrEmptyString($first_name)|| IsNullOrEmptyString($last_name)|| /*IsNullOrEmptyString($gender)|| */IsNullOrEmptyString($email)|| IsNullOrEmptyString($picture))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
				//echo $this->dictionary->get_text($this->dictionary->get_text("text.required"));
				//throw new Exception($this->dictionary->get_text($this->dictionary->get_text("text.required")));
			}
			if($this->check_user(null,$facebook_id))
			{
				$this->login_log($facebook_id);
			}
			else
			{
				$this->database->mysqli->begin_Transaction();
				$query="insert into users (facebook_id,first_name,last_name,gender,email,picture)
				values(?,?,?,?,?,?)";

				if (!($stmt1 = $this->database->mysqli->prepare($query))) 
				{
					throw new Exception("Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
				}
				if (!$stmt1->bind_param("ssssss", $facebook_id,$first_name,$last_name,$gender,$email,$picture))
				{
					throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				if (!$stmt1->execute()) 
				{
					throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				$stmt1->close();
				
				$this->login_log($facebook_id);
				$this->database->mysqli->commit();
			}
			$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");
		}
		catch(Exception $e)
		{
			$this->database->mysqli->rollback();
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	function get_user_info($user_id,$facebook_id)
	{
		try
		{
			if(IsNullOrEmptyString($user_id) && IsNullOrEmptyString($facebook_id))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
				//exit;
			}

			if (!($stmt = $this->database->mysqli->prepare("select  * from users where ID=? or facebook_id=? limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("is", $user_id,$facebook_id))
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();

			//თუ მომხმარებელი მოიძებნა
			if($row["ID"]>0)
			{
				$this->ID=$row["ID"];
				$this->facebook_id=$row["facebook_id"];
				$this->first_name=$row["first_name"];
				$this->last_name=$row["last_name"];
				$this->gender=$row["gender"];
				$this->email=$row["email"];
				$this->picture=$row["picture"];
				$this->status=$row["status"];
			}
			else
			{
				throw new Exception( $this->dictionary->get_text("text.user_not_found"));
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function add_succes_user_transactions($User_ID,$Operation_Type,$Operation_Channel,$Invoice_ID,$Amount,$inp_user)
	{
		try
		{
			
			if(IsNullOrEmptyString($User_ID) ||IsNullOrEmptyString($Operation_Type) ||IsNullOrEmptyString($Operation_Channel) ||IsNullOrEmptyString($Amount)||IsNullOrEmptyString($inp_user))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			if($Amount<0)
			{
				throw new Exception($this->dictionary->get_text("text.value_must_be_positive"));
			}
			$query="insert into user_transactions (User_ID,Operation_Type,Operation_Channel,Invoice_ID,Amount,inp_user) values(?,?,?,?,?,?)";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("issids",$User_ID, $Operation_Type,$Operation_Channel,$Invoice_ID,$Amount,$inp_user)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			else
			{
				$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");
				$this->result->get_result(200,$this->dictionary->get_text("text.transaction_created"),$this->dictionary->get_text("text.transaction_created"),"");
			}
			
		}
		catch(Exception $e)
		{
			$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			$this->database->mysqli->rollback();
			throw $e;
		}
	}
}
