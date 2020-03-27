<?php
try
{
require_once __DIR__ . '/database/database.php';  
require_once __DIR__ . "/Models/dictionaries.php";
require_once __DIR__ . "/Models/users.php";
require_once(__DIR__ ."/Models/Loging.php");
require_once (__DIR__ ."/vendor/autoload.php");
$database=new data;
$user=new users($database);
$Loging=new Loging($database);
$dictionary=new dictionaries($database);
	
$mpdf = new \Mpdf\Mpdf([190, 236]);
$str='
<html>
<head>
	<meta charset="utf-8">
	<title>'.$dictionary->get_text("text.menu").'</title>
    <body>';

try
{
	if(isset($_GET["menu_id"]) && isset($_GET["facebook_id"]))
	{
		$menu_id=$_GET["menu_id"];
		$facebook_id=$_GET["facebook_id"];
		if(!$user->check_user_menu_header($menu_id,$facebook_id))
		{
			throw new Exception($dictionary->get_text("text.menu_pdf_not_access"));
		}
		else
		{
			$day_numbers=$user->get_user_menu_details_days($menu_id);
			$str.= '<table width="100%" height="100px" border="1" cellpadding="0" cellspacing="0">
		  <tbody>
			<tr>
			  <th scope="col">'.$dictionary->get_text("text.day").'</th>
			  <th scope="col">'.$dictionary->get_text("text.Food").'</th>
			  <th scope="col">'.$dictionary->get_text("text.Total_kcal").'</th>
			</tr>
			  <tr>';
			foreach($day_numbers as $res_day_numbers)
			{
				$day_number=$res_day_numbers['day_number'];
				$str.= '<tr>
				<td align="center">'.$dictionary->get_text("text.day").' N'.$res_day_numbers['day_number'].'</td>';
				$prods=$user->get_user_menu_details_products_by_day($menu_id,$day_number);
				$str.= '<td align="center">';
				foreach($prods as $prod_results)
				{
					$str.= '<p>'.$dictionary->get_text($prod_results["product_dictionary_key"]).'</p>';
				}
				$kcal=$user->get_user_menu_details_kcal_by_day($menu_id,$day_number);
				$str.= '</td>'.
					'<td align="center">'.$kcal.'</td>
					</tr>';
					
			}
			$str.='</tbody>
		</table>
		</body>
		</html>';
		}
	}
	else
	{
		throw new Exception($dictionary->get_text("text.menu_pdf_not_access"));
	}
}
catch(Exception $e)
{
	echo $e->getMessage();
	$Loging->process_log("menu_pdf1.php",serialize(get_defined_vars()),"",$e->getMessage());
}	
/*$str='
<html>

    <head>
    <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
	<title>'.$dictionary->get_text("text.menu").'</title>
    </head>
	<body>
    	<p> áƒ¡áƒáƒ¢áƒ”áƒ¡áƒ¢áƒ </p>
    </body>
    </html>';*/
$mpdf->ignore_invalid_utf8=true;
$mpdf->WriteHTML($str);
$mpdf->Output('Fitculator#'.$dictionary->get_text("text.menu").'.pdf', 'I');
}

catch(Exception $e)
{
	echo $e->getMessage();
}
