<?php
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../myfunctions/myfunction.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once( __DIR__ . "/../Models/result.php");
require_once( __DIR__ . "/../Models/myexeptions.php");
require_once( __DIR__ . "/../Models/dictionaries.php");
require_once( __DIR__ . "/../Models/products.php");
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
	function add_user_menu_header($gender_id,$menu_id,$my_weight,$age,$height,$target_weight,$email,$total_kcal,$physical_activity=null,$Lifestyle=null)
	{
		try
		{
			
			if(IsNullOrEmptyString($gender_id) ||IsNullOrEmptyString($menu_id) ||IsNullOrEmptyString($my_weight) ||IsNullOrEmptyString($age)||IsNullOrEmptyString($height)||IsNullOrEmptyString($target_weight)||IsNullOrEmptyString($email))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			$this->get_user_info(null,$_SESSION["facebook_id"]);
			$User_ID=$this->ID;
			
			$query="insert into user_menu_header (User_ID,menu_id,gender_id,my_weight,age,height,target_weight,email,total_kcal,physical_activity,Lifestyle) values(?,?,?,?,?,?,?,?,?,?,?)";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("iiididdsdss",$User_ID,$menu_id,$gender_id,$my_weight,$age,$height,$target_weight,$email,$total_kcal,$physical_activity,$Lifestyle)) 
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
			}
			
		}
		catch(Exception $e)
		{
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function get_last_current_user_menu_header()
	{
		try
		{
			$this->get_user_info(null,$_SESSION["facebook_id"]);
			$User_ID=$this->ID;
			$query="select * from  user_menu_header where User_ID=? order by id desc limit 1";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("i",$User_ID)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			if(isset($row['ID']) && $row['ID']>0)
			{
				return $row['ID'];
			}
			else
			{
				throw new Exception('not_found');
			}
			$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");	
		}
		catch(Exception $e)
		{
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	
	function add_user_menu_details($user_menu_header_id,$menu_array)
	{
		try
		{
			
			if(IsNullOrEmptyString($user_menu_header_id) || empty($menu_array))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			//var_dump($menu_array);
			$day_number=1;
			foreach($menu_array as $menu_item)
			{
				$item=explode(',',$menu_item);
				
				foreach($item as $result_item)
				{
					if($result_item=='')
					{
						continue;
					}
					$product=new products($this->database);
					$product->get_product_info_by_id($result_item);
					//გასაგრძელებელია
					$query="insert into user_menu_details (master_id,day_number,product_id,total_kcal) values(?,?,?,?)";
					if (!($stmt = $this->database->mysqli->prepare($query))) 
					{
						throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
					}
					if (!$stmt->bind_param("iiid",$user_menu_header_id,$day_number,$product->ID,$product->total_kcal)) 
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
					}
					
				}
				$day_number+=1;
				
			}
			
		}
		catch(Exception $e)
		{
			
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function check_user_menu_header($menu_header_id,$facebook_id)
	{
		try
		{
			$this->get_user_info(null,$facebook_id);
			$User_ID=$this->ID;
			$query="select * from  user_menu_header where User_ID=? and ID=?";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("is",$User_ID,$menu_header_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			if(isset($row['ID']) && $row['ID']>0)
			{
				return true;
			}
			else
			{
				return false;
			}
			$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");	
		}
		catch(Exception $e)
		{
			return false;
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function get_user_menu_header($menu_header_id,$facebook_id)
	{
		try
		{
			$this->get_user_info(null,$facebook_id);
			$User_ID=$this->ID;
			$query="select * from  user_menu_header where User_ID=? and ID=?";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("is",$User_ID,$menu_header_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			if(isset($row['ID']) && $row['ID']>0)
			{
				return $res;
			}
			else
			{
				throw new Exception("not found");
			}
			$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");	
		}
		catch(Exception $e)
		{
			return false;
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function get_user_menu_header_by_id($id)
	{
		try
		{
			$query="select * from  user_menu_header where ID=?";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("i",$id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			if(isset($row['ID']) && $row['ID']>0)
			{
				return $res;
			}
			else
			{
				throw new Exception("not found");
			}
			$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");	
		}
		catch(Exception $e)
		{
			return false;
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	
	function get_user_menu_details($menu_header_id)
	{
		try
		{
			/*$this->get_user_info(null,$facebook_id);
			$User_ID=$this->ID;*/
			$query="select p.product_dictionary_key, u.* from  user_menu_details u, products p
									where u.product_id=p.id 
									and u.master_id=?
									order by day_number";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("i",$menu_header_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			if(isset($row['ID']) && $row['ID']>0)
			{
				return $res;
			}
			else
			{
				throw new Exception("not found");
			}
			$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");	
		}
		catch(Exception $e)
		{
			return false;
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	function get_user_menu_details_products_by_day($menu_header_id,$day_number)
	{
		try
		{
			/*$this->get_user_info(null,$facebook_id);
			$User_ID=$this->ID;*/
			$query="select p.product_dictionary_key, u.* from  user_menu_details u, products p
									where u.product_id=p.id 
									and u.master_id=?
									and day_number=?";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("ii",$menu_header_id,$day_number)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			if(isset($row['ID']) && $row['ID']>0)
			{
				return $res;
			}
			else
			{
				throw new Exception("not found");
			}
			$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");	
		}
		catch(Exception $e)
		{
			return false;
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function get_user_menu_details_days($menu_header_id)
	{
		try
		{
			/*$this->get_user_info(null,$facebook_id);
			$User_ID=$this->ID;*/
			$query="select  distinct(u.day_number) from  user_menu_details u
									where u.master_id=?
									order by day_number";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("i",$menu_header_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			if(isset($row['day_number']) && $row['day_number']>0)
			{
				return $res;
			}
			else
			{
				throw new Exception("not found");
			}
			$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");	
		}
		catch(Exception $e)
		{
			return false;
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function get_user_menu_details_kcal_by_day($menu_header_id,$day_number)
	{
		try
		{
			/*$this->get_user_info(null,$facebook_id);
			$User_ID=$this->ID;*/
			$query="select sum(u.total_kcal) as total_kcal from  user_menu_details u
									where u.master_id=?
									and day_number=?";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("ii",$menu_header_id,$day_number)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			if(isset($row['total_kcal']) && $row['total_kcal']>0)
			{
				return $row['total_kcal'];
			}
			else
			{
				return 0;
			}
			$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");	
		}
		catch(Exception $e)
		{
			return false;
			//$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	
	function get_users($status=null)
	{
		try
		{
			if(IsNullOrEmptyString($status))
			{
				$query="SELECT u.* FROM users u";
			}
			else
			{
				$query="SELECT u.* FROM users u
				where u.Status='".$status."'";
			}
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			return $res;
			$stmt->close();
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
}
