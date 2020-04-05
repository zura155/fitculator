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
	if(isset($_POST["dictionary_key"]) && isset($_POST["Dictionary_value_ge"])&& isset($_POST["Dictionary_value_eng"]) && isset($_POST["Dictionary_value_rus"]))
		{
			echo "[";
			if($dictionary->dictionary_change($_POST["dictionary_key"],$_POST["Dictionary_value_ge"],$_POST["Dictionary_value_eng"],$_POST["Dictionary_value_rus"]))
      {
        $result->get_result(200,"","succes","",true);
      }
		
			echo ",{}]";
	}
	else
	{
		echo "[";
		$result->get_result(500,"",$dictionary->get_text("text.required"),"",true);
		echo ",{}]";
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