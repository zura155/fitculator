<?php
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../myfunctions/myfunction.php");
require_once( __DIR__ . "/../Models/users.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once( __DIR__ . "/../Models/result.php");
require_once( __DIR__ . "/../Models/myexeptions.php");
//კლასის აღწერა
class invoices
{
	public $ID;
	public $Price;
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
	
	function __construct($database)
	{
		$this->database=$database;
		$this->Loging=new Loging($database);
		$this->result=new result($database);
		$this->myexception=new myexception($database);
		$this->users=new users($database);
	}
	function get_invoice_info($invoice_id)
	{
		try
		{
			if(IsNullOrEmptyString($invoice_id))
			{
				throw new Exception("text.required");
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
				$this->Price=$row["Price"];
				$this->Status=$row["Status"];
				$this->Inp_Date=$row["Inp_Date"];
				$this->Inp_User=$row["Inp_User"];
				$this->Pay_Date=$row["Pay_Date"];
				$this->Pay_User=$row["Pay_User"];
			}
			else
			{
				throw new Exception( "text.invoice_not_found");
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
				throw new Exception("text.required");
			}
			$this->get_invoice_info($invoice_id);
			if($this->Price!=$amount)
			{
				throw new Exception("text.incorect_amount");
			}
			if($this->Status!='N')
			{
				throw new Exception("text.incorect_invoice_status");
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
					$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),"text.success","");
					$this->result->get_result(200,"text.invoice_payed","text.invoice_payed","");
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
}