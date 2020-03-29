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
			
			$name_geo =  $_POST['name_geo'];
			$name_eng = $_POST['name_eng'];
		
			$desc_geo = $_POST['desc_geo'];
			$desc_eng = $_POST['desc_eng'];
			
			$price =  $_POST['price'];
			$valuta = $_POST['valuta'];
			
			$discount = $_POST['discount'];
			
			$catId = $_POST['catId'];
			$prodId = $_POST['prodId'];
			
			$status = $_POST['statusi'] == 1 ? 1 : 0;
			

			$error = mysql_query("UPDATE `product` SET `name_geo` = '".$name_geo."', `name_eng` = '".$name_eng."', `desc_geo` = '".$desc_geo."', `desc_eng` = '".$desc_eng."', `price` = '".$price."', `valuta` = '".$valuta."', `discount` = '".$discount."', `catId` = '".$catId."', `status` = '".$status."' WHERE `product`.`id` = ".$prodId.";");

	$image_dir = "../../upload/products/";
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
	$filesSql .= "('product', '" . $prodId . "','" . $fileName . "')" . ($key == count($filesToInsert) - 1 ? '' : ',');
}
$filesSql = "INSERT INTO `images`(`table_relative`, `produc_id`, `image_path`) VALUES " . $filesSql . "";

var_dump($filesSql);


mysql_query($filesSql) or die (mysql_error());

			
			echo json_encode(["error" => !$error]);
			exit();
		} else {
			echo json_encode(["error" => true]);
		}


