<?php

require_once ("database.php");



	if(!empty($_POST))
		{
			

			$currentPagee = "title";
			header('Content-Type: application/json');
			$about_company_title_geo = isset($_POST['about_company_title_geo']) ? $_POST['about_company_title_geo'] : "" ;
			$about_company_title_eng = isset($_POST['about_company_title_eng']) ? $_POST['about_company_title_eng'] : "" ;
			
			$about_company_text_geo = isset($_POST['about_company_text_geo']) ? $_POST['about_company_text_geo'] : "" ;
			$about_company_text_eng = isset($_POST['about_company_text_eng']) ? $_POST['about_company_text_eng'] : "" ;
			
			$our_product_title_geo = isset($_POST['our_product_title_geo']) ? $_POST['our_product_title_geo'] : "" ;
			$our_product_title_eng = isset($_POST['our_product_title_eng']) ? $_POST['our_product_title_eng'] : "" ;
			
			$our_product_text_geo = isset($_POST['our_product_text_geo']) ? $_POST['our_product_text_geo'] : "" ;
			$our_product_text_eng = isset($_POST['our_product_text_eng']) ? $_POST['our_product_text_eng'] : "" ;

			$design_title_geo = isset($_POST['design_title_geo']) ? $_POST['design_title_geo'] : "" ;
			$design_title_eng = isset($_POST['design_title_eng']) ? $_POST['design_title_eng'] : "" ;
			
			$design_text_geo = isset($_POST['design_text_geo']) ? $_POST['design_text_geo'] : "" ;
			$design_text_eng = isset($_POST['design_text_eng']) ? $_POST['design_text_eng'] : "" ;

			$designer_title_geo = isset($_POST['designer_title_geo']) ? $_POST['designer_title_geo'] : "" ;
			$designer_title_eng = isset($_POST['designer_title_eng']) ? $_POST['designer_title_eng'] : "" ;
			
			$designer_text_geo = isset($_POST['designer_text_geo']) ? $_POST['designer_text_geo'] : "" ;
			$designer_text_eng = isset($_POST['designer_text_eng']) ? $_POST['designer_text_eng'] : "" ;
			
			$tips_title_geo = isset($_POST['tips_title_geo']) ? $_POST['tips_title_geo'] : "" ;
			$tips_title_eng = isset($_POST['tips_title_eng']) ? $_POST['tips_title_eng'] : "" ;
			
			$tips_text_geo = isset($_POST['tips_text_geo']) ? $_POST['tips_text_geo'] : "" ;
			$tips_text_eng = isset($_POST['tips_text_eng']) ? $_POST['tips_text_eng'] : "" ;

			$training_title_geo = isset($_POST['training_title_geo']) ? $_POST['training_title_geo'] : "" ;
			$training_title_eng = isset($_POST['training_title_eng']) ? $_POST['training_title_eng'] : "" ;
			
			$training_text_geo = isset($_POST['training_text_geo']) ? $_POST['training_text_geo'] : "" ;
			$training_text_eng = isset($_POST['training_text_eng']) ? $_POST['training_text_eng'] : "" ;

			$trainer_title_geo = isset($_POST['trainer_title_geo']) ? $_POST['trainer_title_geo'] : "" ;
			$trainer_title_eng = isset($_POST['trainer_title_eng']) ? $_POST['trainer_title_eng'] : "" ;
			
			$trainer_text_geo = isset($_POST['trainer_text_geo']) ? $_POST['trainer_text_geo'] : "" ;
			$trainer_text_eng = isset($_POST['trainer_text_eng']) ? $_POST['trainer_text_eng'] : "" ;

			$service_title_geo = isset($_POST['service_title_geo']) ? $_POST['service_title_geo'] : "" ;
			$service_title_eng = isset($_POST['service_title_eng']) ? $_POST['service_title_eng'] : "" ;
			
			$service_text_geo = isset($_POST['service_text_geo']) ? $_POST['service_text_geo'] : "" ;
			$service_text_eng = isset($_POST['service_text_eng']) ? $_POST['service_text_eng'] : "" ;
			
			$contact_title_geo = isset($_POST['contact_title_geo']) ? $_POST['contact_title_geo'] : "" ;
			$contact_title_eng = isset($_POST['contact_title_eng']) ? $_POST['contact_title_eng'] : "" ;

			$contact_text_geo = isset($_POST['contact_text_geo']) ? $_POST['contact_text_geo'] : "" ;
			$contact_text_eng = isset($_POST['contact_text_eng']) ? $_POST['contact_text_eng'] : "" ;

			
			$error = mysql_query("UPDATE `page_title` SET `about_company_title_geo` = '".$about_company_title_geo."', `about_company_title_eng` = '".$about_company_title_eng."', `about_company_text_geo` = '".$about_company_text_geo."',`about_company_text_eng` = '".$about_company_text_eng."', `our_product_title_geo` = '".$our_product_title_geo."', `our_product_title_eng` = '".$our_product_title_eng."', `our_product_text_geo` = '".$our_product_text_geo."', `our_product_text_eng` = '".$our_product_text_eng."', `design_title_geo` = '".$design_title_geo."', `design_title_eng` = '".$design_title_eng."', `design_text_geo` = '".$design_text_geo."', `design_text_eng` = '".$design_text_eng."', `designer_title_geo` = '".$designer_title_geo."', `designer_title_eng` = '".$designer_title_eng."', `designer_text_geo` = '".$designer_text_geo."', `designer_text_eng` = '".$designer_text_eng."', `tips_title_geo` = '".$tips_title_geo."', `tips_title_eng` = '".$tips_title_eng."', `tips_text_geo` = '".$tips_text_geo."', `tips_text_eng` = '".$tips_text_eng."', `training_title_geo` = '".$training_title_geo."', `training_title_eng` = '".$training_title_eng."', `training_text_geo` = '".$training_text_geo."', `training_text_eng` = '".$training_text_eng."', `trainer_title_geo` = '".$trainer_title_geo."', `trainer_title_eng` = '".$trainer_title_eng."', `trainer_text_geo` = '".$trainer_text_geo."', `trainer_text_eng` = '".$trainer_text_eng."', `service_title_geo` = '".$service_title_geo."', `service_title_eng` = '".$service_title_eng."', `service_text_geo` = '".$service_text_geo."', `service_text_eng` = '".$service_text_eng."', `contact_title_geo` = '".$contact_title_geo."', `contact_title_eng` = '".$contact_title_eng."', `contact_text_geo` = '".$contact_text_geo."', `contact_text_eng` = '".$contact_text_eng."' WHERE `page_title`.`id` = '1';");




			echo json_encode(["error" => !$error]);
			exit();
		} else {
		

			echo json_encode(["error" => true]);
		}



?>