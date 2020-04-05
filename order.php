<?php
require_once __DIR__ . '/Models/calculator.php';  
require_once __DIR__ . '/database/database.php';   
require_once __DIR__ . '/Models/FacebookApi.php';
try{
$database=new data();
$calculator=new calculator($database);
$fbapi=new FacebookApi();
$loginurl=$fbapi->get_Login_url();	
$gender=$_POST['gender'];
	
if($gender=='мужской' ||$gender=='კაცი' || $gender=='Male' )
{
	$gender='Male';
}
else
{
	$gender='Female';
}
	$naxshirwylebi=$_POST["naxshirwylebi"];
	$cilebi=$_POST["cilebi"];
	$cximebi=$_POST["cximebi"];
	$bostneuli=$_POST["bostneuli"];
	$xili=$_POST["xili"];
	
	$age=$_POST["age"];
	$height=$_POST["height"];
	$weight=$_POST["weight"];
	$target=$_POST["target"];
	$email=$_POST["email"];
	
	$not_wanted=[];
	if(strlen($naxshirwylebi)>0)
	{
		array_push($not_wanted,$naxshirwylebi);
	}
	if(strlen($cilebi)>0)
	{
		array_push($not_wanted,$cilebi);
	}
	if(strlen($cximebi)>0)
	{
		array_push($not_wanted,$cximebi);
	}
	if(strlen($bostneuli)>0)
	{
		array_push($not_wanted,$bostneuli);
	}
	if(strlen($xili)>0)
	{
		array_push($not_wanted,$xili);
	}
	$not_wanted_result="";
	foreach($not_wanted as $res)
	{
		$not_wanted_result.=$res;
	}
	//echo $not_wanted_result;
	//თუ დალოგინებული არაა დალოგინების გვერძე ვამისამართებთ:
	if(!isset($_SESSION["facebook_id"]) || strlen($_SESSION["facebook_id"])==0 || $_SESSION["facebook_id"]=='' )
	{
	echo "need login";		
//Set Access-Control-Allow-Origin with PHP
//header('Access-Control-Allow-Origin: '.$loginurl, false);
		//header("Location: ".$loginurl);
	}
	else
	{
$calculator->calculate_menu($gender,$not_wanted_result,$weight,$age,$height,$target,$email,null,null);
	}

}
catch(Exception $e)
{
	echo $e->getMessage().'<br> '.$e;
}
?>