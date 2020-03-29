<?php
require_once __DIR__ . '/Models/calculator.php';  
require_once __DIR__ . '/database/database.php';  
require_once __DIR__ . '/Models/message.php';  
require_once __DIR__ . '/Models/products.php';  
try{
$database=new data();
	$product=new products($database);
	$product->add_product("ზეითუნის ზეთი","Olive oil","Оливковое масло",0,0.5,82.5,0.8,748,2);
/*$calculator=new calculator($database);
$calculator->calculate_menu('Male','',100,20,20,50,'zuraaa19@gmail.com',null,null);*/
	
	/*$message=new send_message($database);
	$message->get_mail_system_info_new('send_menu',array('$'),array('$'),'geo');
	$message->to='zuraaa19@gmail.com';
	$message->attachment_url='/Fitculator/src/attachments/courier.jpg';
	$message->attachement_file_name='zura';
	
	$message->string_attachment_file_url='http://localhost/fitculator/menu_system_pdf.php?menu_id=82&facebook_id=3162168463828068';
	$message->string_attachment_file_name='MyMeny.pdf';
	$message->try_send_email();*/
}
catch(Exception $e)
{
	echo $e->getMessage().'<br> '.$e;
}
?>