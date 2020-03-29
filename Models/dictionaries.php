<?php
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once( __DIR__ . "/../Models/myexeptions.php");
require_once(__DIR__ . "/../Models/result.php");

class dictionaries	
{
	private $database;
	private $Loging;
	
	public $ID;
	public $dictionary_key;
	public $language_code;
	public $result;
	/*function __construct()
	{
		$this->database=new data;
		$this->Loging=new Loging;
	}*/
	
	function __construct($database)
	{
		$this->database=$database;
		$this->Loging=new Loging($database);
		$this->result=new result($database);
	}
	
	function get_text($dictionary)
	{
		try
		{
			$language=$_SESSION['lang'];
			$database=new data;

			if (!($stmt = $this->database->mysqli->prepare("select  * from languages where Value=?"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}

			if (!$stmt->bind_param("s", $language)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			$res = $stmt->get_result();
			$stmt->close();

			$row = $res->fetch_assoc();
			$language_id=$row['ID'];
			if(!isset($language_id))
			{
				throw new Exception('Language is not correct: '.$_SESSION['lang']);
			}



			if (!($stmt = $this->database->mysqli->prepare("select  * from dictionaries where Dictionary_Key=? and Language_ID=?"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}

			if (!$stmt->bind_param("si",$dictionary, $language_id)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			$res = $stmt->get_result();
			$stmt->close();

			$row = $res->fetch_assoc();
			if($row['ID']>0)
			{
				$dictionary_value=$row['Value'];
				if(!isset($dictionary_value))
				{
					throw new Exception('Dictionary_key not found: '.$dictionary);
				}
				return $dictionary_value;
			}
			else
			{
				return $dictionary;
			}
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
		}

	}
	
	
	function get_text_by_language($dictionary,$language)
	{
		try
		{
			
			$database=new data;

			if (!($stmt = $this->database->mysqli->prepare("select  * from languages where Value=?"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}

			if (!$stmt->bind_param("s", $language)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			$res = $stmt->get_result();
			$stmt->close();

			$row = $res->fetch_assoc();
			$language_id=$row['ID'];
			if(!isset($language_id))
			{
				throw new Exception('Language is not correct: '.$_SESSION['lang']);
			}



			if (!($stmt = $this->database->mysqli->prepare("select  * from dictionaries where Dictionary_Key=? and Language_ID=?"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}

			if (!$stmt->bind_param("si",$dictionary, $language_id)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			$res = $stmt->get_result();
			$stmt->close();

			$row = $res->fetch_assoc();
			if($row['ID']>0)
			{
				$dictionary_value=$row['Value'];
				if(!isset($dictionary_value))
				{
					throw new Exception('Dictionary_key not found: '.$dictionary);
				}
				return $dictionary_value;
			}
			else
			{
				return $dictionary;
			}
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
		}

	}
	
	
	
	function get_language_id($language_code)
	{
		try
		{
			if (!($stmt = $this->database->mysqli->prepare("select  * from languages where Value=?"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}

			if (!$stmt->bind_param("s", $language_code)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			$res = $stmt->get_result();
			$stmt->close();
			$row = $res->fetch_assoc();
			if($row["ID"]>0)
			{
				return $row["ID"];
			}
			else
			{
				throw new Exception( "ენა ვერ მოიძებნა აღნიშნული პარამეტერებით!");
			}
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			exit;
		}
	}
	
	function get_dictionary_info($dictionary_key,$language_code)
	{
		try
		{
			$language_id=$this->get_language_id($language_code);
			if (!($stmt = $this->database->mysqli->prepare("select * from dictionaries where Dictionary_Key=? and Language_ID=?"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}

			if (!$stmt->bind_param("si",$dictionary_key, $language_id)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			$res = $stmt->get_result();
			$stmt->close();

			$row = $res->fetch_assoc();
			if($row["ID"]>0)
			{
				$this->ID=$row["ID"];
				$this->language_code=$row["language_code"];
				$this->dictionary_key=$row["dictionary_key"];
			}
			else
			{
				throw new Exception( "ენა ვერ მოიძებნა აღნიშნული პარამეტერებით!");
			}
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			exit;
		}
	}
	
	
	
	
	function get_dictionary_id($dictionary_key,$language_code)
	{
		try
		{
			$language_id=$this->get_language_id($language_code);
			if (!($stmt = $this->database->mysqli->prepare("select * from dictionaries where Dictionary_Key=? and Language_ID=?"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}

			if (!$stmt->bind_param("si",$dictionary_key, $language_id)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			$res = $stmt->get_result();
			$stmt->close();

			$row = $res->fetch_assoc();
			if(isset($row["ID"]) && $row["ID"]>0)
			{
				return $row["ID"];
			}
			else
			{
				return 0;
			}
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			exit;
		}
	}
	
	
	
	function check_dictionary($dictionary_key,$language_code)
	{
		try
		{
			$this->get_dictionary_id($dictionary_key,$language_code);
			if($this->ID>0)
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
			return false;
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			exit;
		}
	}
	function add_dictionary($dictionary_key, $language_code,$value)
	{
		try
		{
			$language_id=$this->get_language_id($language_code);
			if($language_id>0 and !$this->check_dictionary($dictionary_key,$language_code))
			{

				//dictionary-ს ბაზაში ჩაწერა:

				if (!($stmt = $this->database->mysqli->prepare("insert into  dictionaries (Dictionary_Key,Value,Language_ID) values(?,?,?)"))) 
				{
					throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
				}

				if (!$stmt->bind_param("ssi",$dictionary_key,$value,$language_id)) //if (!$stmt->bind_param("s", $user_id)) 
				{
					throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				if (!$stmt->execute()) 
				{
					throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				else
				{
					//echo $this->get_text("text.success");
					$this->result->get_result(200,"text.success",$this->get_text("text.success"),"");
					$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->get_text("text.success"),"");
				}
			}
			else
			{
				throw new Exception($this->get_text("text.dictionary.exists"));
			}
		}
		catch(Exception $e)
		{
			/*$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			exit;*/
			$this->result->get_result(500,"",$e->getMessage(),"");
			$this->database->mysqli->rollback();
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			//exit;
			throw $e;
		}
	}
	
	
	
	function get_dictionary_by_value($value)
	{
		try
		{
			$param="%$value%";
			//$language_id=$this->get_language_id($language_code);
			if (!($stmt = $this->database->mysqli->prepare("select a.Dictionary_Key, a.Value as Dictionary_value_ge, b.Value as Dictionary_value_eng from dictionaries a, dictionaries b
where a.Dictionary_Key=b.Dictionary_Key
and (a.Value like ?
or b.Value like ? or a.Dictionary_Key like ?)
and a.Language_ID=1
and b.Language_ID=2"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}

			if (!$stmt->bind_param("sss",$param,$param,$param)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			$res = $stmt->get_result();
			
			$stmt->close();
			return $res;
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			exit;
		}
	}
	//dasaweria
	function dictionary_change($dictionary_key,$Dictionary_value_ge,$Dictionary_value_eng)
	{
		try
		{
      
      //ქართული ტექსტის ცვლილება
			if (!($stmt = $this->database->mysqli->prepare("update dictionaries set Value=? where Dictionary_Key=? and Language_ID=1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}

			if (!$stmt->bind_param("ss",$Dictionary_value_ge,$dictionary_key)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			//ინგლისური ტექსტის ცვლილება
      	if (!($stmt = $this->database->mysqli->prepare("update dictionaries set Value=? where Dictionary_Key=? and Language_ID=2"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}

			if (!$stmt->bind_param("ss",$Dictionary_value_eng,$dictionary_key)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			
			$stmt->close();
			return true;
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			//exit;
      return false;
		}
	}
}
?>