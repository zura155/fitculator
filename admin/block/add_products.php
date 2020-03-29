<?php
session_start();
require_once ("../config/database.php");
require_once __DIR__ . '../../../database/database.php'; 
require_once __DIR__ . '../../../Models/products.php'; 
$database=new data();
$product=new products($database);

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

if (!isset($_SESSION['username']) || $_SESSION['username'] == ''){
	header("location: login.php");
	exit(0);
}

	$catId = isset($_POST['catId']) ? $_POST['catId'] : '';
	
	$name_geo = isset($_POST['name_geo']) ? $_POST['name_geo'] : '';
	$name_eng = isset($_POST['name_eng']) ? $_POST['name_eng'] : '';
	$name_rus = isset($_POST['name_rus']) ? $_POST['name_rus'] : '';

	$water = isset($_POST['water']) ? $_POST['water'] : '';
	$protein = isset($_POST['protein']) ? $_POST['protein'] : '';
	$fat = isset($_POST['fat']) ? $_POST['fat'] : '';
	$Carbohydrates = isset($_POST['Carbohydrates']) ? $_POST['Carbohydrates'] : '';
	
	$total_kcal = isset($_POST['total_kcal']) ? $_POST['total_kcal'] : '';
	$Status = isset($_POST['Status']) ? $_POST['Status'] : 0;


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
$product->add_product($name_geo,$name_eng,$name_rus,$water,$protein,$fat,$Carbohydrates,$total_kcal,$logo_name,$catId,$Status);

?>