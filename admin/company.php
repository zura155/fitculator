<?php session_start(); 
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
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" />
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
						<a class="navbar-brand" href="#">კომპანიის ინფორმაცია</a>
					</div>


					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">notifications_active</i>
									<span class="notification"><?php // countSeen(); ?></span>
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



						<div class="col-md-6">
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




						<div class="col-md-6">
								<div class="card">
									<div class="card-header card-chart" data-background-color="red">
									<h4 class="title">	
	                                    <a href="pagetitle_view.php" class="inlineAdd">
	                                        <i class="material-icons" style="font-size: 40px;">note_add</i> 
	                                        <p>გვერდების სათაურები და ტექსტი</p>
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




                    <div class="row shoparea">
                                        
                        <div class="cloud cloud1">
                            <ul>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                        </div>
                    
                        <div class="cloud cloud2">
                           <ul>
                             <li></li>
                             <li></li>
                             <li></li>
                             <li></li>
                          </ul>
                        </div>
                        

                    
                        <div class="sign">OPEN</div>
                        
                        <div class="store_roof">
                            <ul>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                        </div>
                        
                        <div class="store_roof_opening"></div>
                        <div class="store_window"></div>
                        <div class="store_door"></div>
                        <div class="store_sign">GreenArea</div>
                        <div class="store_frame_shadow"></div>
                        <div class="store_frame"></div>
                        <div class="store_inner_wall"></div>
                        <div class="store_wall"></div>
                        <div class="store_floor"></div>
                        <div class="kerb"><div class="left"></div><div class="right"></div></div>
                        <div class="road"></div>
                        <div class="floor"></div>
                    
                                        
                    </div><!-- end row --> 





				    </div>
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
