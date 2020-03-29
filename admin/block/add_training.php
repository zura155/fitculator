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
	$training_title_geo = isset($_POST['training_title_geo']) ? $_POST['training_title_geo'] : '';
	$training_title_eng = isset($_POST['training_title_eng']) ? $_POST['training_title_eng'] : '';
	
	$training_description_long_geo = isset($_POST['training_description_long_geo']) ? $_POST['training_description_long_geo'] : '';
	$training_description_long_eng = isset($_POST['training_description_long_eng']) ? $_POST['training_description_long_eng'] : '';

	$treinerId = isset($_POST['treinerId']) ? $_POST['treinerId'] : '';

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
			$logo_name = "";
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
			$file_name = "";
		}
	

	

$sql="INSERT INTO `training` (`id`, `training_title_geo`, `training_title_rus`, `training_title_eng`, `training_description_long_geo`, `training_description_long_rus`, `training_description_long_eng`, `photo`, `silabus`, `treinerId`) VALUES (NULL, '".mysql_real_escape_string($training_title_geo)."', '', '".mysql_real_escape_string($training_title_eng)."', '".mysql_real_escape_string($training_description_long_geo)."', '', '".mysql_real_escape_string($training_description_long_eng)."', '".mysql_real_escape_string($logo_name)."', '".mysql_real_escape_string($file_name)."', '".mysql_real_escape_string($treinerId)."')";
var_dump($sql);
		mysql_query($sql) or die (mysql_error());

?>