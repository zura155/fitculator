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
	$name_geo = isset($_POST['name_geo']) ? $_POST['name_geo'] : '';
	$name_eng = isset($_POST['name_eng']) ? $_POST['name_eng'] : '';
	
	$fb_link = isset($_POST['fb_link']) ? $_POST['fb_link'] : '';
	$in_link = isset($_POST['in_link']) ? $_POST['in_link'] : '';

	$advisorId = isset($_POST['catId']) ? $_POST['catId'] : '';

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
			$logo_name = "";
		}

$sql="INSERT INTO `designers` (`id`, `name_geo`, `name_eng`, `name_rus`, `fb_link`, `in_link`, `photo`) VALUES (NULL,'".mysql_real_escape_string($name_geo)."', '".mysql_real_escape_string($name_eng)."', '',  '".mysql_real_escape_string($fb_link)."', '".mysql_real_escape_string($in_link)."', '".mysql_real_escape_string($logo_name)."')";

		mysql_query($sql) or die (mysql_error());

?>