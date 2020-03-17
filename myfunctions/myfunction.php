<?php 
function IsNullOrEmptyString($var) {
  return (!isset($var) || trim($var)==='');
}

function get_client_ip() 
{
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}

function get_current_time()
{
	return date('Y-m-d H:i:s', time());
}
function after_month()
{
	$time=get_current_time();
	$final = date("Y-m-d", strtotime("+1 month"));//, $time));
	return $final;
}
//შეკვეცა substr("Hello world",0,-1)."<br>";
//mb_substr
//date('d-m-Y', strtotime($res["Come_Date"])); 
?>