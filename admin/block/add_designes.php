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
	$designe_title_geo = isset($_POST['designe_title_geo']) ? $_POST['designe_title_geo'] : '';
	$designe_title_eng = isset($_POST['designe_title_eng']) ? $_POST['designe_title_eng'] : '';

	$designe_description_short_geo = isset($_POST['designe_description_short_geo']) ? $_POST['designe_description_short_geo'] : '';
	$designe_description_short_eng = isset($_POST['designe_description_short_eng']) ? $_POST['designe_description_short_eng'] : '';
	
	$designe_description_long_geo = isset($_POST['designe_description_long_geo']) ? $_POST['designe_description_long_geo'] : '';
	$designe_description_long_eng = isset($_POST['designe_description_long_eng']) ? $_POST['designe_description_long_eng'] : '';
	
	$designe_area = isset($_POST['designe_area']) ? $_POST['designe_area'] : '';
	$designerId = isset($_POST['designerId']) ? $_POST['designerId'] : '';
	$descatId = isset($_POST['descatId']) ? $_POST['descatId'] : '';
	

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

		$sql="INSERT INTO `designes` (`designe_title_geo`, `designe_title_eng`, `designe_description_short_geo`, `designe_description_short_eng`, `designe_description_long_geo`, `designe_description_long_eng`, `designe_area`, `designerId`, `descatId`) VALUES ('".mysql_real_escape_string($designe_title_geo)."', '".mysql_real_escape_string($designe_title_eng)."', '".mysql_real_escape_string($designe_description_short_geo)."', '".mysql_real_escape_string($designe_description_short_eng)."', '".mysql_real_escape_string($designe_description_long_geo)."', '".mysql_real_escape_string($designe_description_long_eng)."', '".mysql_real_escape_string($designe_area)."', '".mysql_real_escape_string($designerId)."', '".mysql_real_escape_string($descatId)."')";

mysql_query($sql) or die (mysql_error());
$lastId = mysql_insert_id();

$filesSql = "";
foreach ($filesToInsert as $key=>$fileName) {
	$filesSql .= "('designes', '" . $lastId . "','" . $fileName . "')" . ($key == count($filesToInsert) - 1 ? '' : ',');
}
$filesSql = "INSERT INTO `images`(`table_relative`, `produc_id`, `image_path`) VALUES " . $filesSql . "";


mysql_query($filesSql) or die (mysql_error());

?>