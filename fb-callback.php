<?php
require_once __DIR__ . '/database/database.php';  
require_once __DIR__ . '/Models/FacebookApi.php';  
require_once __DIR__ . '/Models/users.php';  
require_once( __DIR__ . '/Models/result.php');
require_once( __DIR__ . '/Models/Loging.php');
if(!isset($_SESSION))
{
	session_start();
}
try
	{	
	$database=new data();
	$fbapi=new FacebookApi();
	$user=new users($database);
	$result=new result($database);
	$Loging=new Loging($database);
	//$fbapi->Get_User_Info();
	$fbapi->Login_Call_Back($database);
	$fbapi->Get_User_Info();
	$user->login_or_registration($fbapi->Login_User_ID,$fbapi->Login_User_FirstName,$fbapi->Login_User_LastName,$fbapi->Login_User_Gender,$fbapi->Login_User_Email,$fbapi->Login_User_Picture);
	header("Location: index.php");
	//echo '<h1>'.$_SESSION['fb_access_token'].'</h1>';
	//echo '<h1>'.$fbapi->Access_Token.'</h1>';
	//$_SESSION["token"]=$fbapi->Access_Token;
}
catch(Exception $e)
{
	echo "[";
	$result->get_result(500,"",$e->getMessage(),"");
	$Loging->process_log("fb-callback",serialize(get_defined_vars()),"",$e->getMessage());
	echo "{}]";
	//$fbapi->fb_logout();
	session_unset();
	session_destroy();
	session_abort();
}
?>