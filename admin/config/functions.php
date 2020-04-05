<?php

$error = true;

// bazis gamopdzaxeba
require_once ("database.php");
$database=new data();
// ავტორიზაციის შემოწმება
error_reporting (E_ALL);
ini_set("display_errors", 1);

if (isset($_SESSION['username']) && isset($_SESSION['isadmin']) and $_SESSION['isadmin']=='Y') 
{
	$username=$_SESSION['username'];

	if (!($stmt = $database->mysqli->prepare("SELECT count(*) as num FROM admin WHERE username =?"))) 
	{
		throw new Exception( "Prepare failed: (" . $database->mysqli->errno . ") " . $database->mysqli->error);
	}
	if (!$stmt->bind_param("s",$username)) 
	{
		throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}

	if (!$stmt->execute()) 
	{
		throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	$res = $stmt->get_result();
	$row = $res->fetch_assoc();
	if(isset($row["num"]) && $row["num"]==1 && isset($_SESSION['username']))
	{
		$authorised = true;
	}
	else
	{
		header("location: login.php");
	}
	$stmt->close();
}



// სისტემიდან გამოსვლა
if (isset($_GET['action']) && $_GET['action'] == "logout")
{
	$authorised = false;
	session_destroy();
	header("Location: login.php");
}
?>