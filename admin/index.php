<?php session_start(); 


// bazis gamopdzaxeba
require_once ("config/database.php");
require_once ("config/functions.php");

// errorebi
error_reporting (0);

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png" />
	<link rel="icon" type="image/png" href="img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>GreenArea - სამართავი პანელი </title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/material-dashboard.css" rel="stylesheet"/>
    <link href="css/demo.css" rel="stylesheet" />
    <link href="css/pagination.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href='css/roboto.css' rel='stylesheet' type='text/css'>
	<script src="tinymce/tinymce.min.js"></script>
	<script>tinymce.init({selector:'textarea'});</script>
	<!--image-->
	<link rel="stylesheet" type="text/css" href="css/image_upload.css">
</head>

<body>

	<div class="wrapper">

<?php require_once("admin_menu.php"); ?>
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
									<li style="padding-top: 5px;"> <a href="new_orders.php"><i class="material-icons" style="font-size: 18px; padding-right: 10px; padding-bottom: 1px;">shopping_cart</i>შეკვეთები</a></li>
									<li style="padding-top: 5px;"><a href="new_register.php"><i class="material-icons" style="font-size: 18px; padding-right: 10px; padding-bottom: 1px;">school</i>ტრენინგები</a></li>
								</ul>
							</li>


							<li class="dropdown">
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
	 							   <i class="material-icons">person</i>
	 							   <p class="hidden-lg hidden-md">Profile</p>
		 						</a>
								<ul class="dropdown-menu">
									<li style="padding-top: 5px;"><a href="?action=logout"><i class="material-icons" style="font-size: 18px; padding-right: 10px; padding-bottom: 1px;">delete_forever</i>	გამოსვლა ( <b><?php echo $_SESSION['username']; ?></b> )</a></li>
								</ul>
							</li>

						</ul>
					</div>
				</div>
			</nav>


			<div class="content">
				<div class="container-fluid">
					<div class="row">


						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="red">
									<a href="products_view.php"><i class="material-icons">store</i></a>
								</div>
								<div class="card-content">
									<p class="category">ონლაინ მაღაზია</p><br><br>
								</div>
								<div class="card-footer">
									<div class="stats"><a href="products_view.php" class="redi">ყველა პროდუქტი <h3 class="title right"><?php countResult("product"); ?></h3> </a></div>
								</div>
							</div>
						</div>


						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="orange">
									<a href="design_view.php"><i class="material-icons">brush</i></a>
								</div>
								<div class="card-content">
									<p class="category">დიზაინი</p><br><br>
								</div>
								<div class="card-footer">
                                	<div class="stats"><a href="design_view.php" class="orangei">ყველა დიზაინი <h3 class="title right"><?php countResult("designes"); ?></h3> </a></div>
								</div>
							</div>
						</div>


						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="green">
									<a href="tips.php"><i class="material-icons">library_books</i></a>
								</div>
								<div class="card-content">
									<p class="category">ჩვენი რჩევები</p><br><br>
								</div>
								<div class="card-footer">
                                	<div class="stats"><a href="tips.php">ყველა რჩევა <h3 class="title right"><?php countResult("tips"); ?></h3> </a></div>
								</div>
							</div>
						</div>


						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="blue">
									<a href="training_view.php"><i class="material-icons">school</i></a>
								</div>
								<div class="card-content">
									<p class="category">ტრენინგები</p><br><br>
								</div>
								<div class="card-footer">
                                	<div class="stats"><a href="training_view.php" class="bluei">ყველა ტრენინგი <h3 class="title right"><?php countResult("training"); ?></h3> </a></div>
								</div>
							</div>
						</div>
					</div>


			<div class="row">

				<div class="col-md-3">
                        <div class="card">
                            <div class="card-header card-chart" data-background-color="red">
                                <h4 class="title">	
                                    <a href="add_product.php" class="inlineAdd">
                                        <i class="material-icons" style="font-size: 40px;">local_florist</i> 
                                        <p>პროდუქტის დამატება</p>
                                    </a>
                                </h4>
                            </div>
                           	 <!--
                            <div class="card-content">
                                <p class="category"><span class="redi"><i class="fa fa-long-arrow-up"></i> 55%  </span>-იანი ზრდა </p>
                            </div>-->
                            
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">info_outline</i> ბოლო 1 თვის მონაცემები
                                </div>
                            </div>
                        </div>
				</div>


				<div class="col-md-3">
                        <div class="card">
                            <div class="card-header card-chart" data-background-color="orange">
                                <h4 class="title">	
                                    <a href="add_design.php" class="inlineAdd">
                                        <i class="material-icons" style="font-size: 40px;">art_track</i> 
                                        <p>დიზაინის დამატება</p>
                                    </a>
                                </h4>
                            </div>
                            
                            <!--
                            <div class="card-content">
                                <p class="category"><span class="orangei"><i class="fa fa-long-arrow-up"></i> 15%  </span>-იანი ზრდა </p>
                            </div>-->
                            
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">info_outline</i> ბოლო 1 თვის მონაცემები
                                </div>
                            </div>
                        </div>
				</div>


				<div class="col-md-3">
                        <div class="card">
                            <div class="card-header card-chart" data-background-color="green">
                            <h4 class="title">	
                                <a href="add_training.php" class="inlineAdd">
                                    <i class="material-icons" style="font-size: 40px;">import_contacts</i> 
                                    <p>ტრენინგის დამატება</p>
                                </a>
                            </h4>
                            </div>
                             <!--
                            <div class="card-content">
                                <p class="category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 15%  </span>-იანი ზრდა </p>
                            </div>-->
                            
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">info_outline</i> ბოლო 1 თვის მონაცემები
                                </div>
                            </div>
                        </div>
				</div>



				<div class="col-md-3">
                        <div class="card">
                            <div class="card-header card-chart" data-background-color="blue">
                            <h4 class="title">	
                                <a href="add_tips.php" class="inlineAdd">
                                    <i class="material-icons" style="font-size: 40px;">my_library_add</i> 
                                    <p>რჩევის დამატება</p>
                                </a>
                             </h4>
                            </div>
                             <!--
                            <div class="card-content">
                                <p class="category"><span class="bluei"><i class="fa fa-long-arrow-up"></i> 15%  </span>-იანი ზრდა </p>
                            </div>-->
                            
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">info_outline</i> ბოლო 1 თვის მონაცემები
                                </div>
                            </div>
                        </div>
				</div>

			</div>



					<div class="row">
						<div class="col-lg-6 col-md-12">
							
                            
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-stats" >
                                    <div class="card-header" data-background-color="red">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">შეკვეთები</p>
                                        <h3 class="title"><?php countResult("orders"); ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats"><a href="#" class="redi"> შეკვეთილი პროდუქტები </a></div>
                                    </div>
                                </div>
                            </div>
    
    
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-stats" >
                                    <div class="card-header" data-background-color="orange">
                                        <i class="material-icons">school</i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">რეგისტრანტები</p>
                                        <h3 class="title"><?php countResult("order_trainings"); ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats"> <a href="#" class="orangei">რეგისტრანტების რაოდენობა </a> 	</div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card card-stats" >
                                    <div class="card-header" data-background-color="red">
                                        <i class="material-icons">person_add</i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">მომხმარებლები</p>
                                        <h3 class="title"><?php countResult("users"); ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats"><a href="#" class="redi"> დარეგისტრირებული მომხმარებლები </a></div>
                                    </div>
                                </div>
                            </div>


                            
						</div>
						<!--end statistic block-->



						<!-- service block-->
						<div class="col-lg-6 col-md-12">
							<div class="card">
	                            <div class="card-header" style="background-color: #607D8B;">
	                                <h4 class="title">დარეგისტრირებული მომხმარებლები <span style="float: right;"><?php countResult("users"); ?></span></h4>
	                            </div>
	                            <div class="card-content table-responsive">
	                                <table class="table table-hover">
	                                    <thead class="text-warning">
	                                    	<th>სახელი და გვარი</th>
	                                    	<th>ტელეფონი</th>
	                                    	<th>ელ-ფოსტა</th>
	                                    </thead>
	                                    <tbody>


							            <?php
											$category_sql = mysql_query("SELECT * FROM `users` order by userId desc limit 5");
											while($category_row = mysql_fetch_assoc($category_sql))
											{

										?>	                                    
	                                        <tr>
	                                        	<td><?php echo $category_row["userName"]." ".$category_row["userLast"]; ?></td>
	                                        	<td><?php echo $category_row["userPhone"]; ?></td>
	                                        	<td><?php echo $category_row["userEmail"]; ?></td>
	                                        </tr>


	                                     <?php } ?>

	                                    </tbody>
	                                </table>
	                            </div>
	                        </div>
						</div>
						<!--end service blck-->


					</div>
					<!--end row-->




				</div>
			</div>

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
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="http://greenarea.ge/">GreenArea</a>,<a href="http://webmania.ge/" target="_blank" style="color:gray;">Created By <b>Webmania</b> </a></p>
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
