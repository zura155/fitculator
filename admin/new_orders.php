<?php session_start(); 
// bazis gamopdzaxeba
require_once ("config/functions.php");


if(isset($_POST["data_id"]) && isset($_POST["table_name"])){
	
		$del_id2 = $_POST["data_id"];
		$sqli2 = ("DELETE FROM `order_products` WHERE `order_id` = ".$del_id2."");	
		$retval2 = mysql_query( $sqli2 );
		if(! $retval2 )
		{
		  die('Could not delete data: ' . mysql_error());
		}

	}

if(isset($_POST["mim_id"])){
	
		$mim_id = $_POST["mim_id"];
		$mimsql = ("UPDATE `orders` SET `status` = '2' WHERE `orders`.`id` = ".$mim_id.";");	
		$retval3 = mysql_query( $mimsql );
		if(! $retval3 )
		{
		  die('Could not update data: ' . mysql_error());
		}

	}

if(isset($_POST["das_id"])){
	
		$das_id = $_POST["das_id"];
		$dassql = ("UPDATE `orders` SET `status` = '3' WHERE `orders`.`id` = ".$das_id.";");	
		$retval4 = mysql_query( $dassql );
		if(! $retval4 )
		{
		  die('Could not update data: ' . mysql_error());
		}

	}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png" />
	<link rel="icon" type="image/png" href="img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>GreenAdmin</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/material-dashboard.css" rel="stylesheet"/>
    <link href="css/demo.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href='css/roboto.css' rel='stylesheet' type='text/css'>
	<script src="tinymce/tinymce.min.js"></script>
	<script>tinymce.init({selector:'textarea'});</script>
	<!--image-->
	<link rel="stylesheet" type="text/css" href="css/image_upload.css">
<style type="text/css">

	.editDel {
		margin-top: 7%;
	}
	
	.btn .material-icons {
    vertical-align: middle;
    font-size: 20px;
    top: 0px;
    position: relative;
}

</style>
</head>

<body>

	<div class="wrapper">

	    <div class="sidebar" data-color="purple" data-image="img/sidebar-1.jpg">
			<div class="logo">
				<a href="#" class="simple-text"> GreenArea	</a>
			</div>

	    	<div class="sidebar-wrapper">
	            <ul class="nav">

	                <li class="active">
	                    <a href="index.php">
	                        <i class="material-icons">home</i>
	                        <p>მთავარი</p>
	                    </a>
	                </li>

	                <li>
	                    <a href="company.php">
	                        <i class="material-icons">location_city</i>
	                        <p>კომპანია</p>
	                    </a>
	                </li>



	                <li>
	                    <a href="news.php">
	                        <i class="material-icons">sms</i>
	                        <p>სიახლეები</p>
	                    </a>
	                </li>



	                <li>
	                    <a href="products.php">
	                        <i class="material-icons">store</i>
	                        <p>პროდუქცია</p>
	                    </a>
	                </li>

	                <li>
	                    <a href="design.php">
	                        <i class="material-icons">brush</i>
	                        <p>დიზაინი</p>
	                    </a>
	                </li>

	                <li>
	                    <a href="tips.php">
	                        <i class="material-icons">library_books</i>
	                        <p>რჩევები</p>
	                    </a>
	                </li>

	                <li>
	                    <a href="training.php">
	                        <i class="material-icons">school</i>
	                        <p>ტრენინგები</p>
	                    </a>
	                </li>


	                <li>
	                    <a href="service.php">
	                        <i class="material-icons">nature_people</i>
	                        <p>სერვისი</p>
	                    </a>
	                </li>


	                <li>
	                    <a href="contact.php">
	                        <i class="material-icons">contacts</i>
	                        <p>კონტაქტი</p>
	                    </a>
	                </li>
	                


	            </ul>
	    	</div>
	    </div>

	    <div class="main-panel">
			<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">


					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">სამართავი პანელი</a>
					</div>


					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">notifications_active</i>
									<span class="notification"><?php countSeen(); ?></span>
									<p class="hidden-lg hidden-md">Notifications</p>
								<div class="ripple-container"></div></a>
								<ul class="dropdown-menu">
									<li style="padding-top: 5px;"> <a href="new_orders.php"><i class="material-icons" style="font-size: 18px; padding-right: 10px; padding-bottom: 1px;">shopping_basket</i>შეკვეთები</a></li>
									<li style="padding-top: 5px;"><a href="new_register.php"><i class="material-icons" style="font-size: 18px; padding-right: 10px; padding-bottom: 1px;">school</i>ტრენინგები</a></li>
								</ul>
							</li>

							<li class="dropdown">
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
	 							   <i class="material-icons">person</i>
	 							   <p class="hidden-lg hidden-md">Profile</p>
		 						</a>
								<ul class="dropdown-menu">
									<li style="padding-top: 5px;"><a href="?action=logout"><i class="material-icons" style="font-size: 18px; padding-right: 10px; padding-bottom: 1px;">delete_forever</i>	გამოსვლა</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>


			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">
							<div class="card card-nav-tabs">
							


								<div class="card-header" data-background-color="purple">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
											
											<ul class="nav nav-tabs" data-tabs="tabs">

												<li class="active">
													<a href="#profile" data-toggle="tab">ახალი შეკვეთები
													<div class="ripple-container"></div></a>
												</li>
												<li class="">
													<a href="#messages" data-toggle="tab">მიმდინარე შეკვეთები
													<div class="ripple-container"></div></a>
												</li>


												<li class="">
													<a href="#settings" data-toggle="tab">დასრულებული შეკვეთები
													<div class="ripple-container"></div></a>
												</li>


											</ul>
										</div>
									</div>
								</div>

								
								<!--content-->
								<div class="card-content">
									<div class="tab-content">
										

												<div class="tab-pane active" id="profile">
                                                
													<table class="table mintable">
                                                    <thead>
                                                    	<tr>
                                                        	<td> თარიგი </td>
                                                        	<td> დამკვეთი </td>
                                                            <td> ტელეფონი </td>
                                                            <td> ელ-ფოსტა </td>
                                                            <td> პროდუქტების რაოდენობა </td>
                                                            <td> ჯამური თანხა </td>
                                                            <td>  </td>
                                                            <td> </td>
                                                        </tr>
                                                    </thead>
													
                                                    <tbody>

												<?php
                                                	$order1sql = mysql_query("SELECT * FROM orders WHERE `status` = 1");
													while($orders1row = mysql_fetch_array($order1sql))
													{
														$orderuser1sql = mysql_query("SELECT * FROM users WHERE `userId` = ".$orders1row['user_id']."");
														$orderuser1row = mysql_fetch_assoc($orderuser1sql);
												?>
															<tr<?php if($orders1row['view_status'] == 0){echo ' style="font-weight:bold;"';}  ?>>
																<td>
																	<em style="font-size:11px;"><?php echo $orders1row['date']; ?></em> 
																</td>
																<td> <?php echo $orderuser1row['userName']; ?> </td>
                                                                <td> <?php echo $orderuser1row['userPhone']; ?>  </td>
                                                                <td> <?php echo $orderuser1row['userEmail']; ?>  </td>
                                                                <td> <?php echo $orders1row['allqty']; ?>  </td>
                                                                <td> <?php echo $orders1row['totalPrice']; ?> </td>
                                                                <td>
																	<form method="post" class="editDel">
                                                                        <input type="hidden" name="mim_id" value="<?php echo $orders1row["id"]; ?>">
                                                                        <button type="submit" rel="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="მიმდინარეში გადატანა" onclick="return confirm('Are you sure?')">
                                                                            მიმდინარეში
                                                                        </button>
                                                                    </form>
																</td>
                                                                
                                                                <td>
																	<form method="post" class="editDel">
                                                                        <input type="hidden" name="das_id" value="<?php echo $orders1row["id"]; ?>">
                                                                        <button type="submit" rel="tooltip" title="" name="current" class="btn btn-warning btn-xs" data-original-title="დასრულებულში გადატანა" onclick="return confirm('Are you sure?')">
                                                                            დასრულებულში
                                                                        </button>
                                                                    </form>
																</td>
                                                                
                                                                <td>
																	<form method="post" class="editDel">
                                                                        <input type="hidden" name="data_id" value="<?php echo $orders1row["id"]; ?>">
                                                                        <input type="hidden" name="table_name" value="orders">
                                                                        <button type="submit" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="წაშლა" onclick="return confirm('Are you sure?')">
                                                                            <i class="material-icons">delete_forever</i>
                                                                        </button>
                                                                    </form>
																</td>
                                                                <td> <a href="#" class="wrapp"><i class="material-icons" data-toggle="dropdown" href="#about">arrow_drop_down</i> </a></td>
															</tr>
                                                            
                                                            <tbody  class="dropdown-products">
 
												<?php
                                                	$orderprod1sql = mysql_query("SELECT * FROM order_products WHERE `order_id` = ".$orders1row['id']."");
													while($orderprod1row = mysql_fetch_array($orderprod1sql))
													{
																$prodimage1sql = mysql_query("SELECT * FROM images WHERE `table_relative` = 'product' and `produc_id` = ".$orderprod1row['product_id']."");
																$image1row = mysql_fetch_assoc($prodimage1sql);
															
												?>
                                                                <tr class="drop-span">
                                                                	<td>  </td>
                                                                    <td>  </td>
                                                                    <td>  </td>
                                                                    <td>  </td>
                                                                    <td>  </td>
                                                                    <td> <img src="../upload/products/<?php echo $image1row['image_path'];  ?>" style="width:100px;"> </td>
                                                                    <td> <span>პროდუქტი:</span><br> <?php echo $orderprod1row["name"] ?> </td>
                                                                    <td> <span>რაოდენობა: </span><br> <?php echo $orderprod1row["qty"] ?> </td>
                                                                    <td> <span>ფასი: </span><br> <?php echo $orderprod1row["price"] ?> </td>
                                                                    <td> <span>ჯამში: </span><br> <?php echo ($orderprod1row["price"] * $orderprod1row["qty"]); ?> </td>
                                                                    
                                                                </tr>
    											<?php
													}
												?>
                                                            </tbody>

                                                            
												<?php
													}
												?>
                                                
												</tbody>
                                                </table>

												</div> <!-- mimdinare -->
                                                


												<div class="tab-pane" id="messages">
                                                
													<table class="table mintable">
                                                    <thead>
                                                    	<tr>
                                                        	<td> თარიგი </td>
                                                        	<td> დამკვეთი </td>
                                                            <td> ტელეფონი </td>
                                                            <td> ელ-ფოსტა </td>
                                                            <td> პროდუქტების რაოდენობა </td>
                                                            <td> ჯამური თანხა </td>
                                                            <td>  </td>
                                                            <td> </td>
                                                        </tr>
                                                    </thead>
													
                                                    <tbody>

												<?php
                                                	$order1sql = mysql_query("SELECT * FROM orders WHERE `status` = 2");
													while($orders1row = mysql_fetch_array($order1sql))
													{
														$orderuser1sql = mysql_query("SELECT * FROM users WHERE `userId` = ".$orders1row['user_id']."");
														$orderuser1row = mysql_fetch_assoc($orderuser1sql);
												?>
															<tr>
																<td>
																	<em style="font-size:11px;"><?php echo $orders1row['date']; ?></em> 
																</td>
																<td> <?php echo $orderuser1row['userName']; ?> </td>
                                                                <td> <?php echo $orderuser1row['userPhone']; ?>  </td>
                                                                <td> <?php echo $orderuser1row['userEmail']; ?>  </td>
                                                                <td> <?php echo $orders1row['allqty']; ?>  </td>
                                                                <td> <?php echo $orders1row['totalPrice']; ?> </td>
                                                                
                                                                <td>
																	<form method="post" class="editDel">
                                                                        <input type="hidden" name="das_id" value="<?php echo $orders1row["id"]; ?>">
                                                                        <button type="submit" rel="tooltip" title="" name="current" class="btn btn-warning btn-xs" data-original-title="დასრულებულში გადატანა" onclick="return confirm('Are you sure?')">
                                                                            დასრულებულში
                                                                        </button>
                                                                    </form>
																</td>
                                                                
                                                                <td>
																	<form method="post" class="editDel">
                                                                        <input type="hidden" name="data_id" value="<?php echo $orders1row["id"]; ?>">
                                                                        <input type="hidden" name="table_name" value="orders">
                                                                        <button type="submit" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="წაშლა" onclick="return confirm('Are you sure?')">
                                                                            <i class="material-icons">delete_forever</i>
                                                                        </button>
                                                                    </form>
																</td>
                                                                <td> <a href="#" class="wrapp"><i class="material-icons" data-toggle="dropdown" href="#about">arrow_drop_down</i> </a></td>
															</tr>
                                                            
                                                            <tbody  class="dropdown-products">
 
												<?php
                                                	$orderprod1sql = mysql_query("SELECT * FROM order_products WHERE `order_id` = ".$orders1row['id']."");
													while($orderprod1row = mysql_fetch_array($orderprod1sql))
													{
																$prodimage1sql = mysql_query("SELECT * FROM images WHERE `table_relative` = 'product' and `produc_id` = ".$orderprod1row['product_id']."");
																$image1row = mysql_fetch_assoc($prodimage1sql);
															
												?>
                                                                <tr class="drop-span">
                                                                    <td>  </td>
                                                                    <td>  </td>
                                                                    <td>  </td>
                                                                    <td>  </td>
                                                                    <td> <img src="../upload/products/<?php echo $image1row['image_path'];  ?>" style="width:100px;"> </td>
                                                                    <td> <span>პროდუქტი:</span><br> <?php echo $orderprod1row["name"] ?> </td>
                                                                    <td> <span>რაოდენობა: </span><br> <?php echo $orderprod1row["qty"] ?> </td>
                                                                    <td> <span>ფასი: </span><br> <?php echo $orderprod1row["price"] ?> </td>
                                                                    <td> <span>ჯამში: </span><br> <?php echo ($orderprod1row["price"] * $orderprod1row["qty"]); ?> </td>
                                                                    
                                                                </tr>
    											<?php
													}
												?>
                                                            </tbody>

                                                            
												<?php
													}
												?>
                                                
												</tbody>
                                                </table>

												</div>


												<div class="tab-pane" id="settings">
                                                
													<table class="table mintable">
                                                    <thead>
                                                    	<tr>
                                                        	<td> თარიგი </td>
                                                        	<td> დამკვეთი </td>
                                                            <td> ტელეფონი </td>
                                                            <td> ელ-ფოსტა </td>
                                                            <td> პროდუქტების რაოდენობა </td>
                                                            <td> ჯამური თანხა </td>
                                                            <td>  </td>
                                                            <td> </td>
                                                        </tr>
                                                    </thead>
													
                                                    <tbody>

												<?php
                                                	$order1sql = mysql_query("SELECT * FROM orders WHERE `status` = 3");
													while($orders1row = mysql_fetch_array($order1sql))
													{
														$orderuser1sql = mysql_query("SELECT * FROM users WHERE `userId` = ".$orders1row['user_id']."");
														$orderuser1row = mysql_fetch_assoc($orderuser1sql);
												?>
															<tr>
																<td>
																	<em style="font-size:11px;"><?php echo $orders1row['date']; ?></em> 
																</td>
																<td> <?php echo $orderuser1row['userName']; ?> </td>
                                                                <td> <?php echo $orderuser1row['userPhone']; ?>  </td>
                                                                <td> <?php echo $orderuser1row['userEmail']; ?>  </td>
                                                                <td> <?php echo $orders1row['allqty']; ?>  </td>
                                                                <td> <?php echo $orders1row['totalPrice']; ?> </td>
                                                                                                                                
                                                                <td>
																	<form method="post" class="editDel">
                                                                        <input type="hidden" name="data_id" value="<?php echo $orders1row["id"]; ?>">
                                                                        <input type="hidden" name="table_name" value="orders">
                                                                        <button type="submit" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="წაშლა" onclick="return confirm('Are you sure?')">
                                                                            <i class="material-icons">delete_forever</i>
                                                                        </button>
                                                                    </form>
																</td>
                                                                <td> <a href="#" class="wrapp"><i class="material-icons" data-toggle="dropdown" href="#about">arrow_drop_down</i> </a></td>
															</tr>
                                                            
                                                            <tbody  class="dropdown-products">
 
												<?php
                                                	$orderprod1sql = mysql_query("SELECT * FROM order_products WHERE `order_id` = ".$orders1row['id']."");
													while($orderprod1row = mysql_fetch_array($orderprod1sql))
													{
																$prodimage1sql = mysql_query("SELECT * FROM images WHERE `table_relative` = 'product' and `produc_id` = ".$orderprod1row['product_id']."");
																$image1row = mysql_fetch_assoc($prodimage1sql);
															
												?>
                                                                <tr class="drop-span">
                                                                    <td colspan="3">  </td>
                                                                    <td> <img src="../upload/products/<?php echo $image1row['image_path'];  ?>" style="width:100px;"> </td>
                                                                    <td> <span>პროდუქტი:</span><br> <?php echo $orderprod1row["name"] ?> </td>
                                                                    <td> <span>რაოდენობა: </span><br> <?php echo $orderprod1row["qty"] ?> </td>
                                                                    <td> <span>ფასი: </span><br> <?php echo $orderprod1row["price"] ?> </td>
                                                                    <td> <span>ჯამში: </span><br> <?php echo ($orderprod1row["price"] * $orderprod1row["qty"]); ?> </td>
                                                                    
                                                                </tr>
    											<?php
													}
												?>
                                                            </tbody>

                                                            
												<?php
													}
												?>
                                                
												</tbody>
                                                </table>

												</div>
									</div>
								</div>
								<!--end content-->

							</div>
						</div>
						<!--end statistic block-->


					</div>
					<!--end row-->


				</div>
			</div>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">

$('.dropdown-products tr').hide();
$( ".wrapp" ).on('click', function(e) {
	e.preventDefault();
	$(this).closest('tbody').next().find('tr').toggle('slow')
});


</script>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul>
							<li><a href="#">მთავარი</a></li>
							<li><a href="#">მაღაზია</a></li>
							<li><a href="#">დიზაინი</a></li>
							<li><a href="#">ტრენინგები</a></li>
							<li><a href="#">რჩევები</a></li>
							<li><a href="#">სერვისი</a></li>
							<li><a href="#">პროფილი</a></li>
						</ul>
					</nav>
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="webmania.ge">GreenArea</a>,Created By Webmania </p>
				</div>
			</footer>
		</div>
	</div>

</body>
	<!--image upload-->
	<script src="js/image_upload.js"></script>
	<!--   Core JS Files   -->
	<script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/material.min.js" type="text/javascript"></script>
	<!--  Charts Plugin -->
	<script src="js/chartist.min.js"></script>
	<!--  Notifications Plugin    -->
	<script src="js/bootstrap-notify.js"></script>
	<!--  Google Maps Plugin    -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
	<!-- Material Dashboard javascript methods -->
	<script src="js/material-dashboard.js"></script>
	<!-- Material Dashboard DEMO methods, don't include it in your project! -->
	<script src="js/demo.js"></script>
	<script type="text/javascript">
    	$(document).ready(function(){
			// Javascript method's body can be found in assets/js/demos.js
        	demo.initDashboardPageCharts();
    	});
	</script>
</html>
<!--by Webmania-->
<?php 

// ნახვის სტატუსის შეცვლა

$notification_status_sql = mysql_query("UPDATE `orders` SET `view_status` = '1' WHERE `orders`.`view_status` = 0;")


?>