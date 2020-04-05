<?php
@session_start();

if (isset($_SESSION['username']) && $_SESSION['username'] != ''){
	session_destroy();
	header("Location: login.php");
}