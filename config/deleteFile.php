<?php
require_once ("database.php");
$imageId = $_POST["id"];

$imagePath = mysql_fetch_assoc(mysql_query("SELECT image_path FROM images WHERE id = ".$imageId.""));

unlink("../../upload/designes/".$imagePath["image_path"]);

mysql_query("DELETE FROM images WHERE id = ".$imageId."");

header('Content-type: application/json');
echo json_encode(["success" => true]);