<?php

// bazis hosti
define ("DB_HOST", "localhost");

// bazis username
define ("DB_USER", "visittw1_fitcula");

// bazis paroli
define ("DB_PASS", "WlepZgK89,I*");

// bazis saxeli
define ("DB_NAME", "visittw1_fitculator");


// Connection
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS);
if ($conn != true){
	die (mysql_error());
	}


// bazis gamotana
mysql_select_db (DB_NAME) or die (mysql_error());

mysql_query("set character set utf8");

?>