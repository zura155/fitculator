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
			var_dump($_POST);
			header('Content-Type: application/json');
			$training_title_geo = $_POST['training_title_geo'];
			$training_title_eng = $_POST['training_title_eng'];
			
			
			$training_description_long_geo = $_POST['training_description_long_geo'];
			$training_description_long_eng = $_POST['training_description_long_eng'];

			
			$treiningId = $_POST['treiningId'];
			
			$image_dir = "../../upload/trainings/";
			
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
					$logo_name =  $_POST['trainigPhoto'];
				}
			
			$file_dir = "../../upload/trainings/silabus/";
			$fileNames = [];
			
				if (isset($_FILES["classnotes"]))
				{
					$silabusebi = reArrayFiles($_FILES['classnotes']);
					foreach ($silabusebi as $silabusi) {
						$pdf = $silabusi["tmp_name"];
						$file_name = sha1( microtime(TRUE) . "_" . $silabusi["size"] ) . ".pdf";
						$filepath = $file_dir . $file_name;
						$fileNames[] = $filepath;
						move_uploaded_file($pdf, $filepath);
					}	
				} else {
					$file_name = $_POST['trainigfile'];
				}	
					
			
			
			$error = mysql_query("UPDATE `training` SET `training_title_geo` = '".$training_title_geo."', `training_title_eng` = '".$training_title_eng."',  `training_description_long_geo` = '".$training_description_long_geo."', `training_description_long_eng` = '".$training_description_long_eng."', `silabus` = '".$file_name."', `photo` = '".$logo_name."' WHERE `training`.`id` = ".$treiningId.";");
			
			echo json_encode(["error" => !$error]);
			exit();
		} else {
			echo json_encode(["error" => true]);
		}


