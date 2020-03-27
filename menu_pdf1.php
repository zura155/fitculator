<?php
require_once("header_template.php");
	require_once 'database/database.php';  
	require_once 'Models/users.php';
	require_once( "Models/Loging.php");
	require_once( "Models/dictionaries.php");
	$database=new data;
	$user=new users($database);
	$Loging=new Loging($database);
	$dictionary=new dictionaries($database);
?>
<body class="first-page theme male">
	 <header class="container">
		<div class="logo">
            <img src="themes/fitculator/images/logo.png" alt="Fitculator.com" />
        </div>  
		 
	</header>
	<main style="margin-top: 10px;">
		<style>
			tr th{
				color: white;
				font-weight: bold;
			}
			tr td{
				color: white;
			}
		</style>
		
<?php
try
{
	//echo $_SESSION["facebook_id"];
	if(isset($_GET["menu_id"]) && isset($_SESSION["facebook_id"]))
	{
		$menu_id=$_GET["menu_id"];
		$facebook_id=$_SESSION["facebook_id"];
		if(!$user->check_user_menu_header($menu_id,$facebook_id))
		{
			throw new Exception($dictionary->get_text("text.menu_pdf_not_access"));
		}
		else
		{
			$day_numbers=$user->get_user_menu_details_days($menu_id);
			echo '<table width="100%" height="100px" border="1" cellpadding="0" cellspacing="0">
		  <tbody>
			<tr>
			  <th scope="col">დღე</th>
			  <th scope="col">საკვები</th>
			  <th scope="col">ჯამური კკალ</th>
			</tr>
			  <tr>';
			foreach($day_numbers as $res_day_numbers)
			{
				$day_number=$res_day_numbers['day_number'];
				echo '<tr>
				<td align="center">'.$dictionary->get_text("text.day").' N'.$res_day_numbers['day_number'].'</td>';
				$prods=$user->get_user_menu_details_products_by_day($menu_id,$day_number);
				echo '<td align="center">';
				foreach($prods as $prod_results)
				{
					echo '<p>'.$dictionary->get_text($prod_results["product_dictionary_key"]).'</p>';
				}
				$kcal=$user->get_user_menu_details_kcal_by_day($menu_id,$day_number);
				echo '</td>'.
					'<td align="center">'.$kcal.'</td>
					</tr>';
					
			}
			echo'</tbody>
		</table>';
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
?>
	
	</main>
</body>
</html>
