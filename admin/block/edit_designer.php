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
			$name_geo = $_POST['name_geo'];
			$name_eng = $_POST['name_eng'];
			
			$fb_link = $_POST['fb_link'];
			$in_link = $_POST['in_link'];
			
			$designerId = $_POST['designerId'];
			
			$image_dir = "../../upload/designers/";
			
			$imageNames = [];
			if (isset($_FILES["images"]))
				{
					$images = reArrayFiles($_FILES['images']);
					foreach ($images as $image) {
						$logo = $image["tmp_name"];
						$logo_name = sha1( microtime(TRUE) . "_" . $image["size"] ) . ".jpg";
						$path = $image_dir . $logo_name;
						$imageNames[] = $path;
						move_uploaded_file($logo, $path);
					}
				} else {
					$logo_name =  $_POST['designerPhoto'];
				}

			$error = mysql_query("UPDATE `designers` SET `name_geo` = '".$name_geo."', `name_eng` = '".$name_eng."', `fb_link` = '".$fb_link."', `in_link` = '".$in_link."', `photo` = '".$logo_name."' WHERE `designers`.`id` = ".$designerId.";");
			
			echo json_encode(["error" => !$error]);
			exit();
		} else {
			echo json_encode(["error" => true]);
		}


