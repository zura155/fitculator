<?php
require_once ("config/functions.php");
require_once __DIR__ . '../../database/database.php'; 
require_once __DIR__ . '../../Models/products.php'; 

require_once(__DIR__ ."../../Models/dictionaries.php");
require_once(__DIR__ ."../../Models/result.php");
require_once(__DIR__ ."../../Models/Loging.php");
$database=new data;
$result=new result($database);
$Loging=new Loging($database);
$dictionary=new dictionaries($database);
try
{
	if(isset($_POST["datalist_value"]) && strlen($_POST["datalist_value"])>=3)
		{
			echo "[";
			$res=$dictionary->get_dictionary_by_value($_POST["datalist_value"]);
			$res1=array();
			foreach($res as $value)
				{
					array_push($res1,$value);
				}
			$result->get_result(200,"",$res1,"",true);
			echo ",{}]";
	}
	else
	{
		$result->get_result(500,"",$dictionary->get_text("text.required"),"",true);
		echo "{}]";
	}
}
catch(Exception $e)
{
	echo "[";
	$result->get_result(500,"",$e->getMessage(),"",true);
	$Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
	throw $e;
	echo ",{}]";
}
?>