<?php session_start(); 


$currentPage = 'about';

// bazis gamopdzaxeba
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
	<title>GreenAdmin</title>
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

	    <div class="sidebar" data-color="purple" data-image="../assets/img/sidebar-1.jpg">
			<div class="logo">
				<a href="index.php" class="simple-text"> GreenArea	</a>
			</div>

	    	<div class="sidebar-wrapper">
	            <ul class="nav">

	                <li>
	                    <a href="index.php">
	                        <i class="material-icons">home</i>
	                        <p>მთავარი</p>
	                    </a>
	                </li>

	                <li class="active">
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
						<a class="navbar-brand" href="company.php">კომპანიის შესახებ</a>
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
									<li style="padding-top: 5px;"><a href="?action=logout"><i class="material-icons" style="font-size: 18px; padding-right: 10px; padding-bottom: 1px;">delete_forever</i>	გამოსვლა ( <b><?php echo $_SESSION['username']; ?></b> )</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>


			<!--start full content-->
	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">

	                   <div class="col-md-8">
							<div class="card card-nav-tabs">

								<!--satauri-->
								<div class="card-header" data-background-color="purple">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
											<span class="nav-tabs-title">კომპანიის შესახებ</span>
											<ul class="nav nav-tabs" data-tabs="tabs">
												<li class="active">
													<a href="#profile" data-toggle="tab">ქართულად<div class="ripple-container"></div></a>
												</li>
												<li class="">
													<a href="#messages" data-toggle="tab">ინგლისურად<div class="ripple-container"></div></a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								
<form method="post">
									<!--form contenti-->
									<div class="card-content">
										<div class="tab-content">
										<!-- georgian -->
                                        	
													<div class="tab-pane active" id="profile">
						                                    <div class="row">


						                                        <div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">სათაური</label>
																		<input type="text" name="page_title_geo" class="form-control" value="<?php echo $page_title_geo; ?>">
																	</div>
						                                        </div>



						                                        <div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">აღწერა</label>
																		<div style="clear: both; height: 40px;"></div>
																		<textarea name="page_desription_short_geo" class="form-control textareaa"><?php echo $page_desription_short_geo; ?></textarea>
																	</div>
						                                        </div>


						                                        <div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">ვრცელი ტექსტი</label>
																		<div style="clear: both; height: 40px;"></div>
																		<textarea name="page_desription_long_geo" class="form-control textareaa"><?php echo $page_desription_long_geo; ?></textarea>
																	</div>
						                                        </div>



						                                    </div>
													</div>



										<!--english-->
													<div class="tab-pane" id="messages">
															<div class="row">


					                                        	<div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">title</label>
																		<input name="page_title_eng" type="text" class="form-control" value="<?php echo $page_title_eng; ?>">
																	</div>
																</div>



					                                        	<div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">Description</label>
																		<input name="page_desription_short_eng" type="text" class="form-control" value="<?php echo $page_desription_short_eng; ?>">
																	</div>
																</div>



						                                        <div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">Full Text</label>
																		<div style="clear: both; height: 40px;"></div>
																		<textarea name="page_desription_long_eng" class="form-control textareaa"><?php echo $page_desription_long_eng; ?></textarea>
																	</div>
						                                        </div>


					                                    </div>
													</div>



											<!--add button-->
		                                    <button type="submit" class="btn btn-primary pull-right" class="alert alert-info alert-with-icon">რედაქტირება</button>
		                                    <div class="clearfix"></div>

											
									 </div>
							   	</div>
							   	<!--end form content-->
							</form>

							</div>



						</div>



						<div class="col-md-4">
								<div class="card">
									<div class="card-header card-chart" data-background-color="green">
									<h4 class="title">	
	                                    <a href="company_view.php" class="inlineAdd">
	                                        <i class="material-icons" style="font-size: 40px;">note_add</i> 
	                                        <p>კომპანიის შესახებ</p>
	                                    </a>
	                                </h4>									
									</div>
									<!--
									<div class="card-content">
										<h4 class="title"><a href="#" style="color: inherit !important;">კომპანიის შესახებ</a></h4>
										
										<p class="category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 5 </span>-დამატებული </p>
									</div>-->

									<div class="card-footer">
										<div class="stats">
											<i class="material-icons">info_outline</i> ბოლო 1 თვის შეკვეთები
										</div>
									</div>
								</div>
						</div>




						<div class="col-md-4">
								<div class="card">
									<div class="card-header card-chart" data-background-color="red">
									<h4 class="title">	
	                                    <a href="pagetitle_view.php" class="inlineAdd">
	                                        <i class="material-icons" style="font-size: 40px;">note_add</i> 
	                                        <p>გვერდების სათაურები</p>
	                                    </a>
	                                </h4>									
									</div>
									<!--
									<div class="card-content">
										<h4 class="title"><a href="#" style="color: inherit !important;">კომპანიის შესახებ</a></h4>
										
										<p class="category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 5 </span>-დამატებული </p>
									</div>-->

									<div class="card-footer">
										<div class="stats">
											<i class="material-icons">info_outline</i> ბოლო 1 თვის შეკვეთები
										</div>
									</div>
								</div>
						</div>



						<div class="col-md-4">
								<div class="card">
									<div class="card-header card-chart" data-background-color="blue">
									<h4 class="title">	
	                                    <a href="pagetext_view.php" class="inlineAdd">
	                                        <i class="material-icons" style="font-size: 40px;">note_add</i> 
	                                        <p>გვერდების სათაურების ტექსტი</p>
	                                    </a>
	                                </h4>									
									</div>
									<!--
									<div class="card-content">
										<h4 class="title"><a href="#" style="color: inherit !important;">კომპანიის შესახებ</a></h4>
										
										<p class="category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 5 </span>-დამატებული </p>
									</div>-->

									<div class="card-footer">
										<div class="stats">
											<i class="material-icons">info_outline</i> ბოლო 1 თვის შეკვეთები
										</div>
									</div>
								</div>
						</div>






					</div>
				</div>
			</div>
			<!--end full content-->






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
			
			$('form').on('submit', function(e) {
				$.post("config/textEdit.php", $(this).serialize()).then(function(response){
					if (response.error) {
						demo.showNotification('top','center', 'შეცდომა რედაქტირებისას');
					} else {
				debugger;
						demo.showNotification('top','center', 'დარედაქტირდა');
					}
				});
				return false;
			});
    	});
	</script>
</html>
<!--by Webmania-->
