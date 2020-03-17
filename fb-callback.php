<?php

require_once __DIR__ . '/Models/FacebookApi.php';   
if(!isset($_SESSION))
{
	session_start();
}
$fbapi=new FacebookApi();
//$fbapi->Get_User_Info();
$fbapi->Login_Call_Back();
//echo '<h1>'.$_SESSION['fb_access_token'].'</h1>';
//echo '<h1>'.$fbapi->Access_Token.'</h1>';
//$_SESSION["token"]=$fbapi->Access_Token;
?>