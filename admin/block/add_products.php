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

	$catId = isset($_POST['catId']) ? $_POST['catId'] : '';
	
	$name_geo = isset($_POST['name_geo']) ? $_POST['name_geo'] : '';
	$name_eng = isset($_POST['name_eng']) ? $_POST['name_eng'] : '';

	$desc_geo = isset($_POST['desc_geo']) ? $_POST['desc_geo'] : '';
	$desc_eng = isset($_POST['desc_eng']) ? $_POST['desc_eng'] : '';
	
	$price = isset($_POST['price']) ? $_POST['price'] : '';
	$valuta = isset($_POST['valuta']) ? $_POST['valuta'] : '';
	
	$discount = isset($_POST['discount']) ? $_POST['discount'] : '';
	$status = isset($_POST['statusi']) ? $_POST['statusi'] : 0;


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

		$sql="INSERT INTO `product` (`catId`, `name_geo`, `name_eng`, `desc_geo`, `desc_eng`, `price`, `valuta`, `discount`, `status`) VALUES ('".mysql_real_escape_string($catId)."', '".mysql_real_escape_string($name_geo)."', '".mysql_real_escape_string($name_eng)."', '".mysql_real_escape_string($desc_geo)."', '".mysql_real_escape_string($desc_eng)."', '".mysql_real_escape_string($price)."', '".mysql_real_escape_string($valuta)."', '".mysql_real_escape_string($discount)."', '".mysql_real_escape_string($status)."')";

var_dump($sql);

mysql_query($sql) or die (mysql_error());
$lastId = mysql_insert_id();

$filesSql = "";
foreach ($filesToInsert as $key=>$fileName) {
	$filesSql .= "('product', '" . $lastId . "','" . $fileName . "')" . ($key == count($filesToInsert) - 1 ? '' : ',');
}
$filesSql = "INSERT INTO `images`(`table_relative`, `produc_id`, `image_path`) VALUES " . $filesSql . "";


mysql_query($filesSql) or die (mysql_error());

?>