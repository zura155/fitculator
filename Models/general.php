<?php
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../myfunctions/myfunction.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once( __DIR__ . "/../Models/result.php");
require_once( __DIR__ . "/../Models/myexeptions.php");
require_once( __DIR__ . "/../Models/dictionaries.php");
require_once( __DIR__ . "/../Models/menus.php");
//კლასის აღწერა
class general
{
	//ბაზასთან კავშირისთვის ცვლადი:
	public $database;
	//ლოგირების ცვლადი
	public $Loging;
	//json
	public $result;
	//შეცდომების გამოსატანი ცლასისთვის და დასალოგი
	public $myexception;
	public $dictionary;
	public $menu;
	function __construct($database)
	{
		$this->database=$database;
		$this->Loging=new Loging($database);
		$this->result=new result($database);
		$this->dictionary=new dictionaries($database);
		$this->myexception=new myexception($database);
		$this->menu=new menus($database);
	}
	function get_gender_id($gender_name) //შემოწმება Users-ში არის თუ არა ჩანაწერი
	{
		try
		{
			if(IsNullOrEmptyString($gender_name))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			
			if (!($stmt = $this->database->mysqli->prepare("select * from gender where Name=? limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("s",$gender_name)) 
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
				return $row["ID"];
			}
			else
			{
				throw new Exception($this->dictionary->get_text("text.not_found"));
			}
			
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	function get_system_parameters($parameter_name)
	{
		try
		{
			if(IsNullOrEmptyString($parameter_name))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			
			if (!($stmt = $this->database->mysqli->prepare("select * from parameters where Name=? limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("s",$parameter_name)) 
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
				return $row["Value"];
			}
			else
			{
				throw new Exception($this->dictionary->get_text("text.not_found"));
			}
			
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	function get_product_types()
	{
		try
		{
			if (!($stmt = $this->database->mysqli->prepare("select * from product_types where Status='A'"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			//$row = $res->fetch_assoc();
			return $res;
			$stmt->close();
			
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	function get_product_type_id($prouct_name)
	{
		try
		{
			if (!($stmt = $this->database->mysqli->prepare("select * from product_types where Name=? and  Status='A'"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("s",$prouct_name)) 
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
				return $row["ID"];
			}
			else
			{
				throw new Exception($this->dictionary->get_text("text.not_found"));
			}
			
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function get_product_type_info($ID)
	{
		try
		{
			if (!($stmt = $this->database->mysqli->prepare("select * from product_types where ID=? and  Status='A'"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("i",$ID)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			return $res;
			
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
}