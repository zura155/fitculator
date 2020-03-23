<?php
require_once __DIR__ . '/Models/calculator.php';  
require_once __DIR__ . '/database/database.php';  
try{
$database=new data();
$calculator=new calculator($database);
$calculator->calculate_menu('Male','',100,20,20,20,50,12,null,null);
}
catch(Exception $e)
{
	echo $e->getMessage().'<br> '.$e;
}
?>