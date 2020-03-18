<?php
try
{//$_POST["invoice_id"]
	require_once("../Models/bogpay.php");
	require_once("../database/database.php");
	require_once("../Models/users.php");
	require_once("../Models/result.php");
	require_once("../Models/Loging.php");
	$database=new data;
	$user=new users($database);
	$result=new result($database);
   	$Loging=new Loging($database);
	//გადახდა:
	$bogpay=new bogpay($database);
	$_POST['amount']=10;
	$_POST["invoice_id"]=1;
	if(isset($_SESSION['username']) && isset($_SESSION["facebook_id"]) && isset($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount']>0 && isset($_POST["invoice_id"]))
	{
		echo "[";
		$json_begin=1;
		$user->get_user_info(null,$_SESSION["facebook_id"]);
		$name=$user->first_name.' '.$user->last_name;
		$bogpay->fill_balance(abs($_POST['amount']),"ინვოისის გადახდა-".$name.': '.$user->facebook_id.' '.$_POST["invoice_id"],$user->facebook_id,$_POST["invoice_id"]);
		echo "{}]";
	}
	else
	{
		throw new Exception("text.required");
	}
}
catch(Exception $e)
{
	if(isset($json_begin) && $json_begin==0)
	{
		echo "[";
	}
	$result->get_result(500,"",$e->getMessage(),"");
	$Loging->process_log("bog/fill.php",serialize(get_defined_vars()),"",$e->getMessage());
	echo "{}]";
}
?>



