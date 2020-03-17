<?php

function menu_fun(t){

	$menu_sql = mysql_query("SELECT * FROM ganc WHERE category = ".t."");
	$menu_sum = mysql_num_rows($menu_sql);
	echo $menu_sum;



}




?>