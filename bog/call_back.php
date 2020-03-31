<?php 
try
{
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
  header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-Type: application/xml; charset=utf-8");
	/*სტატუსები:  success
	REJECTED
	PERFORMED,
	REVERSED,
	CREATED,
	AUTHORIZED,
	VIEWED
	*/
	//საიდან აკითხავს Ip მისამართის დადგენა:
	$ip=get_client_ip();
	//თუ სხვა ip-დან მოვიდა მოთხოვნა პირდაპირ ვაერორებთ:
	/*if($ip!='91.209.131.193' && $ip!='188.169.46.8')
	{
		throw new Exception("Incorrect IP Address: ".$ip);
	}*/
	$inp_data=json_encode($_POST);
	$response=$inp_data;
  
	if (isset($_POST['order_id']) && isset($_POST['payment_hash']) && !empty($_POST['order_id']) && !empty($_POST['payment_hash'])) 
	{
		$ORDER_ID = (isset($_POST['order_id']) && !empty($_POST['order_id']) ? $_POST['order_id'] : null);
		$PAYMENT_HASH = (isset($_POST['payment_hash']) && !empty($_POST['payment_hash']) ? $_POST['payment_hash'] : null);
		$STATUS =  $_POST['status']; //გადახდის სტატუსი success||error
		$STATUS_DESCRIPTION =  $_POST['status_description'];  //გადახდის სტატუსი აღწერა
		$SHOP_ORDER_ID = (isset($_POST['shop_order_id']) && !empty($_POST['shop_order_id']) ? $_POST['shop_order_id'] : null); // მერჩანტის შეკვეთის იდენტიფიკატორი //ბარათის ნომერია
		$PAN = $_POST['pan']; // ბარათის დამაკსული პანი რომლითაც მოხდა ანგარიშსწორება
		$TRANSACTION_ID = $_POST['transaction_id']; // ტრანზაქციის იდენტიფიკატორი რომელიც საჭიროა რეკურენტული გადახდისთვის
		$IPAY_PAYMENT_ID = $_POST['ipay_payment_id']; // გადახდის იდენტიფიკატორი რომელიც იბეჭდება ქვითარზე
		$pan='';
		if(isset($_POST['pan']) && !empty($_POST['pan']))
		{
			$pan=$_POST['pan'];
		}
		if($bogpay->process_pay($ORDER_ID,$PAYMENT_HASH,$STATUS,$STATUS_DESCRIPTION,$response,$SHOP_ORDER_ID,$PAN,$TRANSACTION_ID,$IPAY_PAYMENT_ID))
		{
			header("HTTP/1.1 200 Ok");
		}
		else
		{
			//როგორც ლევანიმ მითხრა თუ გადახდა უარყოფილია და ბანკიდან მოვიდა ინფორმაცია, სტატუსი მაინც 200 უნდა დავაბრუნოთ. დამატებით რომ აღარ მოაკითხონ.
			header("HTTP/1.1 200 Ok");
			//header("HTTP/1.0 404 Not Found");
		}
		
	} 
	elseif(isset($_POST['order_id']) && isset($_POST['payment_hash']))
	{
		header("HTTP/1.0 404 Not Found");
		$bogpay->process_check_pay_log($ORDER_ID,$response,$STATUS_DESCRIPTION);
		$Loging->process_succes_log("bog/call_back.php",$response,"text.success","");
	}
 else
 {
    	header("HTTP/1.0 404 Not Found");
		  $Loging->process_succes_log("bog/call_back.php",$response,"text.success","");
 }
}

catch(Exception $e)
{
	header("HTTP/1.0 404 Not Found");
	$inp_data=json_encode($_POST);
	$response=$inp_data;
	$ORDER_ID = (isset($_POST['order_id']) && !empty($_POST['order_id']) ? $_POST['order_id'] : null);
	$STATUS_DESCRIPTION =  $_POST['status_description'];  //გადახდის სტატუსი აღწერა
	$bogpay->process_check_pay_log($ORDER_ID,$response,$STATUS_DESCRIPTION,$e->getMessage());
	$Loging->process_log("bog/call_back.php",serialize(get_defined_vars()),"",$e->getMessage());
	$result->get_result(500,"",$e->getMessage(),"");
}
?>