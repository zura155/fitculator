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
			
			$designe_title_geo =  $_POST['designe_title_geo'];
			$designe_title_eng = $_POST['designe_title_eng'];
		
			$designe_description_short_geo = $_POST['designe_description_short_geo'];
			$designe_description_short_eng = $_POST['designe_description_short_eng'];
			
			$designe_description_long_geo =  $_POST['designe_description_long_geo'];
			$designe_description_long_eng = $_POST['designe_description_long_eng'];
			
			$designe_area = $_POST['designe_area'];
			$designerId = $_POST['designerId'];
			$descatId = $_POST['descatId'];
			
			$designeId = $_POST['designeId'];

			$error = mysql_query("UPDATE `designes` SET `designe_title_geo` = '".$designe_title_geo."', `descatId` = '".$descatId."', `designe_title_eng` = '".$designe_title_eng."', `designe_description_short_geo` = '".$designe_description_short_geo."', `designe_description_short_eng` = '".$designe_description_short_eng."', `designe_description_long_geo` = '".$designe_description_long_geo."', `designe_description_long_eng` = '".$designe_description_long_eng."', `designe_area` = '".$designe_area."', `designerId` = '".$designerId."' WHERE `designes`.`id` = ".$designeId.";");
			
	$image_dir = "../../upload/designes/";
	$imageNames = [];
	$filesToInsert = [];
	if (isset($_FILES["images"]))
		{
			$images = reArrayFiles($_FILES['images']);
			foreach ($images as $image) {
				$logo = $image["tmp_name"];
				$logo_name = sha1( microtime(TRUE) . "_" . $image["size"] ) . ".jpg";
				$path = $image_dir . $logo_name;
				$imageNames[] = $path;
				move_uploaded_file($logo, $path);
				$filesToInsert[] = $logo_name;
			}
		} else {
			$logo_name = "";
		}
		

$filesSql = "";
foreach ($filesToInsert as $key=>$fileName) {
	$filesSql .= "('designes', '" . $designeId . "','" . $fileName . "')" . ($key == count($filesToInsert) - 1 ? '' : ',');
}
$filesSql = "INSERT INTO `images`(`table_relative`, `produc_id`, `image_path`) VALUES " . $filesSql . "";


mysql_query($filesSql) or die (mysql_error());

			
			echo json_encode(["error" => !$error]);
			exit();
		} else {
			echo json_encode(["error" => true]);
		}


