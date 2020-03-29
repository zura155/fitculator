<?php
session_start();
require_once ("../config/database.php");

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

if (isset($_SESSION['username'])) {
		$user_sql = mysql_query("SELECT * FROM admin WHERE username = '".$_SESSION['username']."'");
		$num_rows = mysql_num_rows($user_sql);
		}

if (!isset($_SESSION['username']) || $_SESSION['username'] == '' || $num_rows != 1){
	header("location: login.php");
	exit(0);
}

		if(!empty($_POST))
		{
			header('Content-Type: application/json');
			$address_geo = $_POST['address_geo'];
			$address_eng = $_POST['address_eng'];

			$email = $_POST['email'];
			$facebook = $_POST['facebook'];
			$linkedin = $_POST['linkedin'];
			$flickr = $_POST['flickr'];
			$youtube = $_POST['youtube'];
			$phone = $_POST['phone'];

			
			$designerId = $_POST['designerId'];
			
			$error = mysql_query("UPDATE `contact` SET `address_geo` = '".$address_geo."',`address_eng` = '".$address_eng."',`email` = '".$email."',`phone` = '".$phone."',`facebook` = '".$facebook."', `linkedin` = '".$linkedin."', `flickr` = '".$flickr."', `youtube` = '".$youtube."' WHERE `contact`.`id` = 1");
			
			echo json_encode(["error" => !$error]);
			exit();
		} else {
			echo json_encode(["error" => true]);
		}


