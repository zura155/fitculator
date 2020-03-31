<?php
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once(__DIR__ . "/../Models/users.php");
require_once(__DIR__ . "/../Models/result.php");
require_once( __DIR__ . "/../myfunctions/myfunction.php");
require_once( __DIR__ . "/../Models/invoices.php");
require_once( __DIR__ . "/../Models/dictionaries.php");
require_once __DIR__ . '/../Models/message.php';  
class bogpay
{
	private $grant_type='client_credentials';
	private $token_url='https://dev.ipay.ge/opay/api/v1/oauth2/token';
	private $client_id='1006';
	private $client_secret='581ba5eeadd657c8ccddc74c839bd3ad';
	public $access_token;
	public $token_type;
	public $app_id;
	public $expires_in;
	//გადახდისთვის საჭირო ცვლადები:
	private $pay_url='https://dev.ipay.ge/opay/api/v1/checkout/orders';
	private $intent="AUTHORIZE";
	private $pay_amount=1.00;//პროდუქტის ფასი
	private $invoice_id=null;
	private $description= "ინვოისის გადახდა"; //პროდუქტის აღწერა
	private $quantity = 1; //პროდუქტის რაოდენობა
	private $product_id = "123456789"; //პროდუქტის იდენტიფიკატორი
	
	private $locale="ka"; //ან en-US
	private $redirect_url = "http://localhost/fitculator/index.php"; // პარამეტრში ვუთითებთ იმ მისამართს რომელზეც უნდა გადმოვიდეს მომხმარებელი წარმატებული ან წარუმატებელი 																			გადახდის შემდეგ
	private $shop_order_id=""; //"მაღაზიის_შეკვეთის_იდენტიფიკატორი", // არაა სავალდებულო
	private $card_transaction_id=""; //რეკურენტული გადახდისთვისაა საჭირო. არაა სავალდებულო
	private $currency_code="GEL";
	private $industry_type="ECOMMERCE";
	
	//გადახდის დროს დაბრუნებული პარამეტრები:
	private $pay_status;
	private $pay_payment_hash;
	private $links1_href;
	private $links1_rel;
	private $links1_method;
	private $links2_href;
	private $links2_rel;
	private $links2_method;
	private $order_id;
	
	//გადახდის შემოწმება
	private $check_payment_url="https://dev.ipay.ge/opay/api/v1/checkout/orders/";
	
	//ბაზასთან კავშირისთვის ცვლადი:
	public $database;
	//ლოგირების ცვლადი
	public $Loging;
	public $dictionary;
	public $users;
	public $result;
	public $invoices;
	
	function __construct($database)
	{
		$this->database=$database;
		$this->Loging=new Loging($database);
		$this->users=new users($database);
		$this->result=new result($database);
		$this->invoices=new invoices($database);
		$this->dictionary=new dictionaries($database);
		$this->get_token();
	}
	
	
	public 	function get_token()
	{
		try
		{
			$auth=$this->client_id.':'.$this->client_secret;
			$data = array('grant_type' => $this->grant_type);
			$headers = array(
				'Content-Type: application/x-www-form-urlencoded',
				'Authorization: Basic '. base64_encode($auth)
			);
			$postString = http_build_query($data, '', '&');
			$ch = curl_init(); 
			curl_setopt ($ch, CURLOPT_URL, $this->token_url); 
			curl_setopt ($ch, CURLOPT_POST, 1); 
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $postString); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			$post = curl_exec ($ch); 
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			if($curl_errno>0)
			{
				throw new Exception($curl_error);
			}
			curl_close ($ch);
			$json = $post;
			$obj = json_decode($json);
			$this->setparameters($obj->{'access_token'},$obj->{'token_type'},$obj->{'app_id'},$obj->{'expires_in'});
			$this->Loging->process_succes_log(__FUNCTION__,serialize(get_defined_vars()),$this->dictionary->get_text("text.success").$json,"");
		}
		catch(Exception $e)
		{
			$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	public	function setparameters($access_token,$token_type,$app_id,$expires_in)
	{
		$this->access_token=$access_token;
		$this->expires_in=$expires_in;
		$this->token_type=$token_type;
		$this->app_id=$app_id;
	}
	
	public	function setpayparameters($pay_status,$pay_payment_hash,$links1_href,$links1_rel,$links1_method,$links2_href,$links2_rel,$links2_method,$order_id)
	{
		$this->pay_status=$pay_status;
		$this->pay_payment_hash=$pay_payment_hash;
		$this->links1_href=$links1_href;
		$this->links1_rel=$links1_rel;
		$this->links1_method=$links1_method;
		$this->links2_href=$links2_href;
		$this->links2_rel=$links2_rel;
		$this->links2_method=$links2_method;
		$this->order_id=$order_id;
	}
	
	//მცდელობების ლოგირება:
	public function process_log($inp_params,$output_params,$inp_user_id,$facebook_id,$invoice_id,$pay_amount,$status='N', $order_id=null,$payment_hash=null)
	{
		try{
			$query="insert into bog_pay_log (inp_params,output_params,inp_user_id,facebook_id,invoice_id,Pay_Amount,Status,order_id,payment_hash)
			values(?,?,?,?,?,?,?,?,?)";

			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception("Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("ssisidsss", $inp_params,$output_params,$inp_user_id,$facebook_id,$invoice_id,$pay_amount,$status,$order_id,$payment_hash))
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
			$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	//გადახდის სტატუსის შემოწმების ლოგირება:
	public function process_check_pay_log($order_id,$bog_response,$Status,$myerror="",$SHOP_ORDER_ID=null,$PAN=null,$TRANSACTION_ID=null,$IPAY_PAYMENT_ID=null)
	{
		try{
			$ip=get_client_ip();
			$query="insert into bog_pay_log_details (order_id,bog_response,Status,ip,Error,shop_order_id,pan,transaction_id,ipay_payment_id)
			values(?,?,?,?,?,?,?,?,?)";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception("Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("sssssssss", $order_id,$bog_response,$Status,$ip,$myerror,$SHOP_ORDER_ID,$PAN,$TRANSACTION_ID,$IPAY_PAYMENT_ID))
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
			$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	public function fill_balance($pay_amount,$description,$facebook_id,$invoice_id,$inp_user=null)
	{
		try
		{
			$this->pay_amount=$pay_amount;
			$this->description=$description;
			$this->product_id=$facebook_id.' '.$invoice_id;
			$this->invoice_id=$invoice_id;
			$curl = curl_init();
			//სატესტოდ:
			$inp_user_id=1;
			$this->database->mysqli->begin_Transaction();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->pay_url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "{\"intent\":\"$this->intent\",\"items\":[{\"amount\":\"$this->pay_amount\",\"description\":\"$this->description\",\"quantity\":1,\"product_id\":\"$this->product_id\"}],\"locale\":\"$this->locale\",\"redirect_url\":\"$this->redirect_url\",\"shop_order_id\":\"$this->shop_order_id\",\"card_transaction_id\":\"$this->card_transaction_id\",\"purchase_units\":[{\"amount\":{\"currency_code\":\"$this->currency_code\",\"value\":\"$this->pay_amount\"},\"industry_type\":\"$this->industry_type\"}]}",
			  CURLOPT_HTTPHEADER => array(
				"Authorization: ".$this->token_type." ".$this->access_token,
				"Content-Type: application/json",
				"accept: application/json"
			  ),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  throw new Exception("cURL Error #:" . $err);
			} 
			else 
			{
				$obj = json_decode($response,true);
				$this->Loging->process_succes_log(__FUNCTION__,serialize(get_defined_vars()),$this->dictionary->get_text("text.success").$response,"");

				$this->process_log(serialize(get_defined_vars()),$response,$inp_user_id,$facebook_id,$this->invoice_id,$this->pay_amount,"N",$obj['order_id'],$obj['payment_hash']);
				$this->database->mysqli->commit();
				//პარამეტრების მინიჭება:
				$this->setpayparameters($obj['status'],$obj['payment_hash'],$obj['links'][0]['href'],$obj['links'][0]['rel'],$obj['links'][0]['method'],$obj['links'][1]['href'],$obj['links'][1]['rel'],$obj['links'][1]['method'],$obj['order_id']);

				//თუ ყველაფერი სწორად შესრულდა ბანკის საიტზე უნდა გადავამისამართოთ.
				if(isset($this->links2_href) && isset($this->links2_rel) && $this->links2_rel=="approve")
				{
					$this->result->get_result(200,"",$this->links2_href,$this->links2_href,true);
					//header("Location: ".$this->links2_href);
				}
				
			}
		}
		catch(Exception $e)
		{
			$this->database->mysqli->rollback();
			$this->result->get_result(500,"",$e->getMessage(),"");
			$this->process_log(serialize(get_defined_vars()),$response,$inp_user_id,$facebook_id,$invoice_id,'E');
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	public function check_payment($order_id)
	{
		try
		{
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->check_payment_url.$order_id."?locale=".$this->locale,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
				"Authorization: ".$this->token_type." ".$this->access_token,
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);
			$obj = json_decode($response,true);
			
			if ($err) 
			{
			  echo "cURL Error #:" . $err;
			} 
			else 
			{
				//თუ ოპერაცია წარმატებულია ბალანსზე უნდა აესახოს
				$this->process_check_pay_log($order_id,$response,$obj['status']);
			  	echo $response;
			}
		}
		catch(Exception $e)
		{
			$this->database->mysqli->rollback();
			$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	
	
	public function process_pay($order_id,$payment_hash,$bog_STATUS,$bog_status_desc,$response,$SHOP_ORDER_ID,$PAN,$TRANSACTION_ID,$IPAY_PAYMENT_ID)
	{
		try
		{
			if(IsNullOrEmptyString($order_id) || IsNullOrEmptyString($payment_hash) || IsNullOrEmptyString($bog_STATUS)|| IsNullOrEmptyString($bog_status_desc))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
				//exit;
			}
			$this->process_check_pay_log($order_id,$response,$bog_status_desc,$SHOP_ORDER_ID,$PAN,$TRANSACTION_ID,$IPAY_PAYMENT_ID);
			
			if (!($stmt = $this->database->mysqli->prepare("select  * from bog_pay_log where order_id=? and payment_hash=? and Status='N' limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("ss", $order_id,$payment_hash)) //if (!$stmt->bind_param("s", $user_id)) 
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();

			//გადახდის მცდელობა მოიძებნა
			if(isset($row["ID"]) && $row["ID"]>0)
			{
				$facebook_id=$row["facebook_id"];
				$Pay_Amount=$row["Pay_Amount"];
				$my_Status=$row["Status"];
				$invoice_id=$row["invoice_id"];
				if($my_Status!='N') //გადახდილი ან დაერორებული თუ არის აღარ ვამუშავებთ გადახდას.
				{
					return false;
				}
				if($bog_STATUS=="success" && $bog_status_desc=='PERFORMED')
				{
					//თანხის ანგარიშზე ასახვა;
					
					$inp_user='bogipay';
					$this->database->mysqli->begin_Transaction();

					$this->users->get_user_info(null,$facebook_id);
					$user_id= $this->users->ID;
					//თანხის დამატება
					//$this->users->add_user_balance_bog($this->users->ID,$Pay_Amount,$inp_user);
					$this->invoices->pay_invoice($invoice_id,$Pay_Amount,$user_id,$pay_user='IPAY');
					if (!($stmt2 = $this->database->mysqli->prepare("update bog_pay_log set Status='S' where order_id=? and payment_hash=? limit 1")))
					{
						throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
					}
					if (!$stmt2->bind_param("ss",$order_id, $payment_hash)) 
					{
						throw new Exception( "Binding parameters failed: (" . $stmt2->errno . ") " . $stmt2->error);
					}

					if (!$stmt2->execute()) 
					{
						throw new Exception( "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error);
					}
					//გადახდასთან დაკავშირებით შეტყობინებების გაგზავნა მეილზე
					$this->invoices->get_invoice_info($invoice_id);
					$send_to_email='';
					$user_menu_header_info=$this->users->get_user_menu_header_by_id($this->invoices->user_menu_header_id);
					foreach($user_menu_header_info as $res_info)
					{
						$send_to_email=$res_info['email'];
					}
					$message=new send_message($this->database);
					$message->get_mail_system_info_new('send_menu',array('$'),array('$'),'geo');
					//$message->to='zuraaa19@gmail.com';
					$message->to=$send_to_email;
					/*$message->attachment_url='/Fitculator/src/attachments/courier.jpg';
					$message->attachement_file_name='zura';*/

					//$message->string_attachment_file_url='http://localhost/fitculator/menu_system_pdf.php?menu_id=82&facebook_id=3162168463828068';
					$message->string_attachment_file_url='http://localhost/fitculator/menu_system_pdf.php?menu_id='.$this->invoices->user_menu_header_id.'&facebook_id='.$row["facebook_id"];
					$message->string_attachment_file_name='MyMeny.pdf';
					$message->try_send_email();
					
					
					$this->database->mysqli->commit();
					return true;
				}
				else
				{
					$this->process_check_pay_log($order_id,$response,$bog_status_desc,"not succes payment",$SHOP_ORDER_ID,$PAN,$TRANSACTION_ID,$IPAY_PAYMENT_ID);
				}
				
			}
			else
			{
				throw new Exception( "ჩანაწერი ვერ მოიძებნა ან ოპერაცია დაერორებულია: order_id: ".$order_id." payment_hash:".$payment_hash);
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			try
			{
				$this->database->mysqli->rollback();
				$this->process_check_pay_log($order_id,$response,$bog_status_desc,$e->getMessage(),$SHOP_ORDER_ID,$PAN,$TRANSACTION_ID,$IPAY_PAYMENT_ID);
				//მეილის გაგზავნა:
				throw $e;
			}
			catch(Exception $e1)
			{
				$this->database->mysqli->rollback();
				$this->result->get_result(500,"",$e1->getMessage(),"");
				$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e1->getMessage());
				throw $e1;
			}
			
		}
	}
}
?>