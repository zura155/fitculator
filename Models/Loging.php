<?php 
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../myfunctions/myfunction.php");
require_once( __DIR__ . "/../Models/result.php");
class Loging
{
	private $database;
	public $result;
	function __construct($database)
	{
		$this->database=$database;
		$this->result=new result($database);
	}
	
	function user_log2($table_name,$identificator,$identificator_value,$Colomn_Name,$Old_Value,$New_Value,$Change_User_ID)
	{
		try
		{
			
			
			$query="insert into ".$table_name." (Colomn_Name,".$identificator.",Old_Value, New_Value, Change_User_ID)
			values(?,?,?,?,?)";

			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception("Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("sissi", $Colomn_Name,$identificator_value,$Old_Value,$New_Value,$Change_User_ID)) 
			{
				throw new Exception("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			else
			{
				//echo "<div>მომხმარებლის მონაცემები შეიცვალა წარმატებით!</div>";  //დროებით ეწეროს
				$this->result->get_result(200,"text.success", "Succes"/*$this->dictionary->get_text("text.success")*/,"");
			}
			$this->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),"Succes","");
			$stmt->close();
			
		}
		catch(Exception $e)
		{
			try
			{
				$this->result->get_result(500,"",$e->getMessage(),"");
				$this->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
				throw $e;
			}
			catch(Exception $e1)
			{
				$this->result->get_result(500,"",$e->getMessage(),"");
				throw $e;
			}
		}
	}
	
	function process_log($function_name,$input_params,$output_params,$error_message)
	{
		try{
			$session_value=session_id();
			$ip=get_client_ip();
			$query="insert into global_log (Session_id,IP_Address,Function_Name,Input_Params, Output_Params, Error_Message)
			values(?,?,?,?,?,?)";

			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception("Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("ssssss", $session_value,$ip,$function_name,$input_params,$output_params,$error_message))  
			{
				throw new Exception("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			else
			{
				//echo "<div>დაფიქსირდა შეცდომა!</div>";  //დროებით ეწეროს
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
		
	}
	
	
	function process_succes_log($function_name,$input_params,$output_params,$error_message)
	{
		try{
			$session_value=session_id();
			$ip=get_client_ip();
			$query="insert into global_log (Session_id,IP_Address,Function_Name,Input_Params, Output_Params, Error_Message)
			values(?,?,?,?,?,?)";

			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception("Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("ssssss", $session_value,$ip,$function_name,$input_params,$output_params,$error_message))
			{
				throw new Exception("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			else
			{
				//echo "<div>ლოგირების პროცესი დასრულდა წარმატებით.</div>";  //დროებით ეწეროს
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
		
	}	
}
?>