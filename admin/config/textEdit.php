<?php

require_once ("database.php");
// ტექსტური გვერდების რედაქტირება, ჩვენ შესახებ ჩვენი მისია ტრეინინგი და ა.შ.	

	if(!empty($_POST))
		{
			$currentPage = "about";
			header('Content-Type: application/json');
			$page_title_geo = isset($_POST['page_title_geo']) ? $_POST['page_title_geo'] : "" ;
			$page_title_eng = isset($_POST['page_title_eng']) ? $_POST['page_title_eng'] : "" ;
			
			$page_desription_short_geo = isset($_POST['page_desription_short_geo']) ? $_POST['page_desription_short_geo'] : "" ;
			$page_desription_short_eng = isset($_POST['page_desription_short_eng']) ? $_POST['page_desription_short_eng'] : "" ;
			
			$page_desription_long_geo = isset($_POST['page_desription_long_geo']) ? $_POST['page_desription_long_geo'] : "" ;
			$page_desription_long_eng = isset($_POST['page_desription_long_eng']) ? $_POST['page_desription_long_eng'] : "" ;
			
			$error = mysql_query("UPDATE `pages` SET `page_desription_short_geo` = '".$page_desription_short_geo."', `page_desription_short_eng` = '".$page_desription_short_eng."', `page_desription_long_geo` = '".$page_desription_long_geo."', `page_desription_long_eng` = '".$page_desription_long_eng."', `page_title_geo` = '".$page_title_geo."', `page_title_eng` = '".$page_title_eng."' WHERE `pages`.`page` = '".$currentPage."';");
			
			echo json_encode(["error" => !$error]);
			exit();
		} else {
			echo json_encode(["error" => true]);
		}










?>