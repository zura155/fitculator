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
	$categoryNameGeo = isset($_POST['categoryNameGeo']) ? $_POST['categoryNameGeo'] : '';
	$categoryNameEng = isset($_POST['categoryNameEng']) ? $_POST['categoryNameEng'] : '';
	

		$sql="INSERT INTO `design_category` (`id`, `category_name_geo`, `category_name_eng`) VALUES (NULL, '".mysql_real_escape_string($categoryNameGeo)."', '".mysql_real_escape_string($categoryNameEng)."')";

		mysql_query($sql) or die (mysql_error());

?>