<?php session_start(); 

// bazis gamopdzaxeba
require_once ("config/database.php");
require_once ("config/functions.php");
require_once __DIR__ . '../../Models/invoices.php'; 
$database=new data();
$invoice=new invoices($database);

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
        <title>FitCulator - სამართავი პანელი </title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <link href="css/bootstrap.css" rel="stylesheet" />
        <link href="css/material-dashboard.css" rel="stylesheet" />
        <link href="css/demo.css" rel="stylesheet" />
        <link href="css/pagination.css" rel="stylesheet" />
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href='css/roboto.css' rel='stylesheet' type='text/css'>
        <script src="tinymce/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: 'textarea'
            });
        </script>
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
                                        <ul class="dropdown-menu">
                                            <li style="padding-top: 5px;"> <a href="new_orders.php"><i class="material-icons" style="font-size: 18px; padding-right: 10px; padding-bottom: 1px;">shopping_cart</i>შეკვეთები</a></li>
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
								<div class="col-md-3">
                                    <div class="card">
                                        <div class="card-header card-chart" data-background-color="green">
                                            <h4 class="title">	
				                                <a href="products_view.php" class="inlineAdd">
				                                    <i class="material-icons" style="font-size: 40px;">import_contacts</i> 
				                                    <p>პროდუქცია</p>
				                                </a>
                            				</h4>
                                        </div>

                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">info_outline</i>  დამატებული პროდუქტების სია
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
 
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">info_outline</i> ახალი პროდუქტის დამატება
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-header card-chart" data-background-color="orange">
                                            <h4 class="title">	
			                                    <a href="users_view.php" class="inlineAdd">
			                                        <i class="material-icons" style="font-size: 40px;">art_track</i> 
			                                        <p>დარეგისტრირებული მომხმარებლები</p>
			                                    </a>
			                                </h4>
                                        </div>

                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">info_outline</i> დარეგისტრირებული მომხმარებლების სია
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-header card-chart" data-background-color="blue">
                                            <h4 class="title">	
			                                <a href="products_view.php" class="inlineAdd">
			                                    <i class="material-icons" style="font-size: 40px;">my_library_add</i> 
			                                    <p>ტექსტური ველები</p>
			                                </a>
			                             </h4>
                                        </div>

                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">info_outline</i> სათაურები და ტექსტები
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-12">

                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header" data-background-color="red">
                                                <i class="material-icons">shopping_cart</i>
                                            </div>
                                            <div class="card-content">
                                                <p class="category">შეკვეთები</p>
                                            </div>
                                            <div class="card-footer">
                                                <div class="stats"><a href="#" class="redi"> შეკვეთილი პროდუქტები </a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end statistic block-->

                              
	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">


	                    <div class="col-md-12">
	                        <div class="card" style="min-height:457px;">
	                            <div class="card-header" data-background-color="purple">
	                                <a href="add_product.php">
	                                	<i class="material-icons" style="float: right; font-size: 50px; padding-right: 95px;">add_box</i>
	                                </a>
	                                <h4 class="title">შეკვეთები</h4>
	                                <p class="category">ჩვენი ყველა შეკვეთა</p>
	                            </div>
	                            <div class="card-content table-responsive">
	                                <table class="table">
	                                    <thead class="text-primary">
											<th>მეილი</th>
	                                    	<th>სახელი</th>
	                                    	<th>გვარი</th>
											<th>შეკვეთის თარიღი</th>
											<th>გადახდის თარიღი</th>
											<th>თანხა</th>
											<th>მენიუ</th>
                                            <th></th><!---->
	                                    </thead>
	                                    <tbody>




                                        
										<?php
										error_reporting(E_ALL);
										ini_set("display_error", 1);
										$data = $invoice->get_invoices();
											
										foreach($data as $news_row) {
										//display the records here

                                        ?>

	                                        <tr>
	                                        	<td><?php echo $news_row["email"]; ?></td>
	                                        	<td><?php echo $news_row["first_name"]; ?></td>
	                                        	<td><?php echo $news_row["last_name"]; ?></td>
												<td><?php echo $news_row["inv_date"]; ?></td>
												<td><?php echo $news_row["pay_date"]; ?></td>
												<td><?php echo $news_row["Price"]; ?></td>
												<td><a href="menu_system_pdf.php?menu_id=<?php echo $news_row["header_id"]; ?>&facebook_id=<?php echo $news_row["facebook_id"]; ?>" target="_blank">მენიუს ნახვა</a></td>
												<!--<td><?php echo $news_row["header_id"]; ?></td>
												<td><?php echo $news_row["facebook_id"]; ?></td>-->
	                                        	
											</tr>

										<?php
                                        }
                                        ?>

	                                    </tbody>
	                                </table>

	                            </div>
	                        </div>

							<ul class="pagination" style="float: right;">
							</ul>

	                    </div>
	                    <!--left side-->

	                    </div>
	                </div>
	            </div>
                                <!--end service blck-->

                            </div>
                            <!--end row-->

                        </div>
                    </div>

                    
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
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            demo.initDashboardPageCharts();
        });
    </script>

    </html>
    <!--by Webmania-->