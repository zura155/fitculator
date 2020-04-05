<?php
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../myfunctions/myfunction.php");
require_once( __DIR__ . "/../Models/users.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once( __DIR__ . "/../Models/result.php");
require_once( __DIR__ . "/../Models/myexeptions.php");
require_once( __DIR__ . "/../Models/dictionaries.php");
//კლასის აღწერა
class invoices
{
	public $ID;
	public $Price;
	public $user_menu_header_id;
	public $Status;
	public $Inp_Date;
	public $Inp_User;
	public $Pay_Date;
	public $Pay_User;
	//ბაზასთან კავშირისთვის ცვლადი:
	public $database;
	//ლოგირების ცვლადი
	public $Loging;
	//json
	public $result;
	//შეცდომების გამოსატანი ცლასისთვის და დასალოგი
	public $myexception;
	public $users;
	public $dictionary;
	function __construct($database)
	{
		$this->database=$database;
		$this->Loging=new Loging($database);
		$this->result=new result($database);
		$this->myexception=new myexception($database);
		$this->users=new users($database);
		$this->dictionary=new dictionaries($database);
	}
	function get_invoice_info($invoice_id)
	{
		try
		{
			if(IsNullOrEmptyString($invoice_id))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}

			if (!($stmt = $this->database->mysqli->prepare("select  * from invoices where ID=? limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("i", $invoice_id))
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			//თუ ინვოისი მოიძებნა
			if(isset($row["ID"]) && $row["ID"]>0)
			{
				$this->ID=$row["ID"];
				$this->user_menu_header_id=$row["user_menu_header_id"];
				$this->Price=$row["Price"];
				$this->Status=$row["Status"];
				$this->Inp_Date=$row["Inp_Date"];
				$this->Inp_User=$row["Inp_User"];
				$this->Pay_Date=$row["Pay_Date"];
				$this->Pay_User=$row["Pay_User"];
			}
			else
			{
				throw new Exception( $this->dictionary->get_text("text.invoice_not_found"));
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	function pay_invoice($invoice_id,$amount,$User_ID,$pay_user='IPAY')
	{
		try
		{
			if(IsNullOrEmptyString($invoice_id) || IsNullOrEmptyString($amount) || IsNullOrEmptyString($pay_user))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			$this->get_invoice_info($invoice_id);
			if($this->Price!=$amount)
			{
				throw new Exception($this->dictionary->get_text("text.incorect_amount"));
			}
			if($this->Status!='N')
			{
				throw new Exception($this->dictionary->get_text("text.incorect_invoice_status"));
			}
			else
			{
				$this->database->mysqli->begin_Transaction();
				$this->users->add_succes_user_transactions($User_ID,"P","BOG",$invoice_id,$amount,$pay_user);
				if (!($stmt = $this->database->mysqli->prepare("update invoices set Status='C',Pay_Date=now(),Pay_User=? where ID=?  limit 1")))
				{
					throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
				}
				if (!$stmt->bind_param("si",$pay_user,$invoice_id)) 
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
					$this->result->get_result(200,$this->dictionary->get_text("text.invoice_payed"),$this->dictionary->get_text("text.invoice_payed"),"");
					$this->database->mysqli->commit();
				}
				$stmt->close();
			}
		}
		catch(Exception $e)
		{
			$this->database->mysqli->rollback();
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function invoice_registration($user_menu_header_id,$Price)
	{
		try
		{
			if(	IsNullOrEmptyString($user_menu_header_id)||IsNullOrEmptyString($Price))
			{
				//echo $this->dictionary->get_text("text.required");
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			if(!is_numeric($Price) || $Price<=0)
			{
				throw new Exception($this->dictionary->get_text("text.price_mus_be_positive"));
			}
			
			if (!($stmt = $this->database->mysqli->prepare("insert into invoices (user_menu_header_id,Price) values(?,?)"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("id",$user_menu_header_id,$Price)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$stmt->close();
			
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			//exit;
			throw $e;
		}
	}
	function get_last_current_user_invoice_info_by_header_id($user_menu_header_id)
	{
		try
		{
			$this->users->get_user_info(null,$_SESSION["facebook_id"]);
			$User_ID=$this->ID;
			$query="select * from  invoices where user_menu_header_id=? order by id desc limit 1";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("i",$user_menu_header_id)) 
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
				$this->ID=$row["ID"];
				$this->user_menu_header_id=$row["user_menu_header_id"];
				$this->Price=$row["Price"];
				$this->Status=$row["Status"];
				$this->Inp_Date=$row["Inp_Date"];
				$this->Inp_User=$row["Inp_User"];
				$this->Pay_Date=$row["Pay_Date"];
				$this->Pay_User=$row["Pay_User"];
			}
			else
			{
				throw new Exception( $this->dictionary->get_text("text.invoice_not_found"));
			}
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	
	function get_invoices($status=null)
	{
		try
		{
			if(IsNullOrEmptyString($status))
			{
				$status='C';
			}
			$query="select u.email, u.first_name,u.last_name,i.Inp_Date as inv_date,bpld.Inp_date as pay_date,i.Price, umh.ID as header_id, u.facebook_id 
					from invoices i, user_menu_header umh, users u, bog_pay_log bpl, bog_pay_log_details bpld
					where i.Status=?
					and i.user_menu_header_id=umh.ID
					and umh.User_ID=u.ID
					and i.ID=bpl.invoice_id
					and bpld.order_id=bpl.order_id
					and bpld.Status='PERFORMED'
					and bpld.transaction_id is not null";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("s", $status))
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
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