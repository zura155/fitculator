<?php
mysql_query("set character set utf8");
	
	if(isset($_POST['lang'])){
			$GLOBALS['lang']  = $_POST['lang'];
			$_SESSION['lang'] = $_POST['lang'];
		}elseif(isset($_SESSION['lang'])){
			$GLOBALS['lang'] = $_SESSION['lang'];
		}else{ 
		$GLOBALS['lang'] = 'geo'; 
		$_SESSION['lang'] = $lang;
		}

	include("../lang/".$lang.".php");
	require_once ("database.php");
	
	
	
	
	$designe_sql = "SELECT * FROM `designes`";
	$product_sql = " WHERE 1=1 ";
	
	// search by DEsigneId
	$descatId = isset($_POST['descatId']) ? $_POST['descatId'] : '';
	
	if(!empty($descatId)) {
		$product_sql .= " AND `descatId` = ".$descatId."";
	}
	
	// search by DEsigneId
	$deserId = isset($_POST['deserId']) ? $_POST['deserId'] : '';
	
	if(!empty($deserId)) {
		$product_sql .= " AND `designerId` = ".$deserId."";
	}

	$product_sql .= " ORDER BY id";
	


			error_reporting(E_ALL);
			ini_set("display_error", 1);

			$db = new PDO('mysql:host=localhost;dbname=greenare_age858', 'greenare_admin', 'Greenarea123');

			$db->exec("set names utf8");
			//get number of total records
			$stmt = $db->query('SELECT count(id) FROM designes ' . $product_sql);

			//include the class
			include('paginator.php');

			$currentPage = isset($_POST["page"]) ? $_POST["page"] : 1;

			if ($currentPage > $stmt / 6)
				$_POST["page"] = 1;

			//create new object pass in number of pages and identifier
			$pages = new Paginator('6','page');
			

			$row = $stmt->fetch(PDO::FETCH_NUM);
			$total = $row[0];
			
			//pass number of records to
			$pages->set_total($total); 
			
			
			$data = $db->query($designe_sql . ' ' . $product_sql. ' ' .$pages->get_limit());
			foreach($data as $designe_row) {
			//display the records here
				
			$images_sql = mysql_query("SELECT * FROM `images` WHERE `table_relative` = 'designes' and `produc_id`= ".$designe_row['id']." LIMIT 1");
			$image_row = mysql_fetch_array($images_sql);

	   
	   ?>  
         	 
            <a href="design_view.php?des_id=<?php echo $designe_row["id"]; ?>">

							<div class="col-md-4 w3ls_news_grid">
								<div class="w3layouts_news_grid">
									<img src="upload/designes/<?php echo $image_row["image_path"]; ?>" alt="" class="img-responsive" />
									<div class="w3layouts_news_grid_pos">
										<div class="wthree_text"><h3><?php echo $designe_row["designe_title_".$lang.""]; ?></h3></div>
									</div>
								</div>

								<div class="agileits_w3layouts_news_grid">
									<ul>
									<li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo $designe_row["designe_title_".$lang.""]; ?></li>
									</ul>
									<h4><?php echo $designe_row["designe_title_".$lang.""]; ?></h4>
									<p><?php echo $designe_row["designe_description_short_".$lang.""]; ?></p>
								</div>
							</div>

            </a>
            
			<?php
			}
			?>
		

<div style="clear:both; height:25px;"></div>
 	
<ul class="pagination" style="float: right;">
    <?php
    
    //create the page links
    echo $pages->page_links();
    
    ?>
</ul>

<div style="clear:both; height:25px;"></div>
 	

