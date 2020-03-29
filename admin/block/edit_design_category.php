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
			$categoryNameGeo = $_POST['categoryNameGeo'];
			$categoryNameEng = $_POST['categoryNameEng'];

			
			
			$designerId = $_POST['designerId'];
			

			$error = mysql_query("UPDATE `design_category` SET `category_name_geo` = '".$categoryNameGeo."', `category_name_eng` = '".$categoryNameEng."' WHERE `design_category`.`id` = ".$designerId.";");
			$ss = "UPDATE `design_category` SET `category_name_geo` = '".$categoryNameGeo."', `category_name_eng` = '".$categoryNameEng."' WHERE `design_category`.`id` = ".$designerId.";";
			var_dump($ss);
			
			echo json_encode(["error" => !$error]);
			exit();
		} else {
			echo json_encode(["error" => true]);
		}


