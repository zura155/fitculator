<?php
require_once __DIR__ . '/Models/FacebookApi.php';   
	$fbapi=new FacebookApi();
$fbapi->fb_logout();
?>