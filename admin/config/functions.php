<?php

$error = true;

// bazis gamopdzaxeba
require_once ("database.php");

// ავტორიზაციის შემოწმება
error_reporting (E_ALL);
ini_set("display_errors", 1);

if (isset($_SESSION['username'])) {
		$user_sql = mysql_query("SELECT * FROM admin WHERE username = '".$_SESSION['username']."'");
		$num_rows = mysql_num_rows($user_sql);
		}

if (isset($_SESSION['username']) && isset($num_rows) && $num_rows == 1 ){
	$authorised = true;
}
else{
	$authorised = false;	
}

if (!isset($_SESSION['username']) || $_SESSION['username'] == '' || $num_rows != 1){
	header("location: login.php");
	exit(0);
}


// სისტემიდან გამოსვლა
if (isset($_GET['action']) && $_GET['action'] == "logout")
{
	session_destroy();
	header("Location: login.php");
}
	
	
// ტექსტური გვერდის დამატება
if(!isset($currentPage)){ $currentPage = ''; }

$edit_about_sql = mysql_query("SELECT * FROM `pages` WHERE page = '".$currentPage."'");
$edit_about_row = mysql_fetch_assoc($edit_about_sql);
$page_title_geo = $edit_about_row["page_title_geo"] ;
$page_title_eng = $edit_about_row["page_title_eng"] ;

$page_desription_short_geo = $edit_about_row["page_desription_short_geo"] ;
$page_desription_short_eng = $edit_about_row["page_desription_short_eng"] ;

$page_desription_long_geo = $edit_about_row["page_desription_long_geo"] ;
$page_desription_long_eng = $edit_about_row["page_desription_long_eng"] ;	





// მონაცემების რაოდენობა 
function countResult($tablename) 
{
	$countResult = mysql_query("SELECT COUNT(*) AS `count` FROM `".$tablename."`");
	$countrow = mysql_fetch_assoc($countResult);
	echo $count = $countrow['count'];

}



// მონაცემის სტატუსის შეცვლა ბაზიდან
if($authorised){
	
	if(isset($_POST["setStatus"]) && isset($_POST["table_name"])){
		$setStatus = $_POST["setStatus"] == 1 ? 1 : 0;
		$tab_name = $_POST["table_name"];
		$status_id = $_POST["status_id"];
		
		$sqli = "UPDATE `".$tab_name."` SET `status` = '".$setStatus."' WHERE `".$tab_name."`.`id` = ".$status_id;
		$retval = mysql_query( $sqli );
		if(! $retval )
		{
		  die('Could not update status: ' . mysql_error());
		}

	}
}



// notifications

function countSeen() 
{
	$seen_trainings_sql = mysql_query("SELECT * FROM `order_trainings` WHERE `view_status` = 0");
	$result_trainings =  mysql_num_rows($seen_trainings_sql);
	
	$seen_orders_sql = mysql_query("SELECT * FROM `orders` WHERE `view_status` = 0");
	$result_orders =  mysql_num_rows($seen_orders_sql);
	
	$result = ($result_trainings + $result_orders);
	
	echo $result;
}
// მონაცემის წაშლა ბაზიდან
if($authorised){
	
	if(isset($_POST["data_id"]) && isset($_POST["table_name"])){
		$del_id = $_POST["data_id"];
		$tab_name = $_POST["table_name"];
		$sqli = ("DELETE FROM `".$tab_name."` WHERE `".$tab_name."`.`id` = '".$del_id."'");	
		$retval = mysql_query( $sqli );
		
		if(! $retval )
		{
		  die('Could not delete data: ' . mysql_error());
		}

	}
}


?>


