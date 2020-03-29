<?php session_start(); 
// bazis gamopdzaxeba
require_once ("config/functions.php");
require_once __DIR__ . '../../database/database.php'; 
require_once __DIR__ . '../../Models/products.php'; 
$database=new data();
$product=new products($database);
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
	<script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
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
						<a class="navbar-brand" href="products_view.php">პროდუქცია</a>
					</div>


					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">

							
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
	                        <div class="card" style="min-height:457px;">
	                            <div class="card-header" data-background-color="purple">
	                                <a href="add_product.php">
	                                	<i class="material-icons" style="float: right; font-size: 50px; padding-right: 95px;">add_box</i>
	                                </a>
	                                <h4 class="title">პროდუქტები</h4>
	                                <p class="category">ჩვენი ყველა პროდუქტი</p>
	                            </div>
	                            <div class="card-content table-responsive">
	                                <table class="table">
	                                    <thead class="text-primary">
											<th>პროდუქტის კატეგორია</th>
	                                    	<th>პროდუქტის სახელი</th>
	                                    	<th>წყალი</th>
											<th>ცილები</th>
											<th>ცხიმები</th>
											<th>ნახშირწყლები</th>
											<th>კკალ (100 გ)</th>
											<th>სტატუსი</th>
                                            <th></th>
	                                    </thead>
	                                    <tbody>




                                        
										<?php
										error_reporting(E_ALL);
										ini_set("display_error", 1);
										$data = $product->get_products();
											
										foreach($data as $news_row) {
										//display the records here

                                        ?>

	                                        <tr>
	                                        	<td><?php echo $news_row["Name_Geo"]; ?></td>
	                                        	<td><?php echo $news_row["Value"]; ?></td>
	                                        	<td><?php echo $news_row["water"]; ?></td>
												<td><?php echo $news_row["protein"]; ?></td>
												<td><?php echo $news_row["fat"]; ?></td>
												<td><?php echo $news_row["Carbohydrates"]; ?></td>
												<td><?php echo $news_row["total_kcal"]; ?></td>
												<td><?php if($news_row["Status"]=='A')
																echo 'აქტიური';
														  else echo 'გაუქმებული';?>
												</td>
	                                        	
												<td class="td-actions text-right">
													<form   method="post" action="edit_product.php">
                                                	<input type="hidden" name="productId" value="<?php echo $news_row["ID"]; ?>">
                                                    <button type="submit" rel="tooltip" title=""  class="btn btn-primary btn-simple btn-xs" data-original-title="რედაქტირება">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    </form>
                                                    
                                                    <form method="post" id="submit-form">
                                                        <button type="button" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs submitBtn" data-id="<?php echo $news_row["ID"]; ?>"  data-original-title="წაშლა">
                                                            <i class="material-icons">delete_forever</i>
                                                        </button>
                                                    </form>
												</td>
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
		</div>
	</div>

<!-- popup -->
<div class="modal" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                დადასტურება
            </div>
            <div class="modal-body">
                ნამდვილად გსურთ წაშლა?
            </div>

  <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">არა</button>
            <a href="#" id="submit" class="btn btn-success success" style="margin-top: 0;">წაშლა</a>
        </div>
    </div>
</div>
<!-- end popup-->


</body>

		
	<!--image upload-->
	<script src="js/image_upload.js"></script>
	<!--   Core JS Files   -->

    <script>
		$(document).ready(function() {
	
			$('#submit').click(function(){
				 /* when the submit button in the modal is clicked, submit the form */
				$('#formfield').submit();
			});
			var currentId;
			
			$(".submitBtn").click(function() {
				$('#confirm-submit').modal();
				currentId = $(this).data("id");
			});
			
			$("#confirm-submit .btn-success.success").click(function(){
				$('#confirm-submit').modal('hide');
				$.post('block/edit_product.php', {Status: 'C', data_id: currentId});
				location.reload();	
			});
		
		});
		
    </script>

    
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

</html>
<!--by Webmania-->
