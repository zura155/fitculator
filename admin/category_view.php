<?php session_start(); 
// bazis gamopdzaxeba
require_once ("config/functions.php");

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
	<script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script>tinymce.init({selector:'textarea'});</script>
	<!--image-->
	<link rel="stylesheet" type="text/css" href="css/image_upload.css">
	
    <style type="text/css">
		/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  margin-top: 20px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #66bb6a;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
	</style>
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



	                <li class="active">
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
						<a class="navbar-brand" href="category_view.php">კატეგორიები</a>
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


	                    <div class="col-md-8">
	                        <div class="card" style="min-height:457px;">
	                            <div class="card-header" data-background-color="purple">
	                                <a href="add_category.php">
	                                	<i class="material-icons" style="float: right; font-size: 50px; padding-right: 95px;">add_box</i>
	                                </a>
	                                <h4 class="title">კატეგორიები</h4>
	                                <p class="category">ყველა ჩვენი კატეგორია</p>
	                            </div>
	                            <div class="card-content table-responsive">
	                                <table class="table">
	                                    <thead class="text-primary">
	                                    	<th>ფოტო</th>
	                                    	<th>კატეგორიის სახელი</th>
	                                    	<th>კატეგორიის აღწერა</th>
																				<th>სტატუსი</th>
																				<th>რედაქტირება/წაშლა</th>
	                                    </thead>
	                                    <tbody>


										<?php
										error_reporting(E_ALL);
										ini_set("display_error", 1);

										$db = new PDO('mysql:host=localhost;dbname=greenare_1', 'greenare_1', 'Greenarea123');
										$db->exec("set names utf8");

										//include the class
										include('config/paginator.php');
										//create new object pass in number of pages and identifier
										$pages = new Paginator('10','p');
										
										//get number of total records
										$stmt = $db->query('SELECT count(id) FROM category');
										$row = $stmt->fetch(PDO::FETCH_NUM);
										$total = $row[0];
										
										//pass number of records to
										$pages->set_total($total); 
										
										$data = $db->query('SELECT * FROM category ORDER BY id DESC '.$pages->get_limit());
										foreach($data as $news_row) {
										//display the records here

                                        ?>

	                                        <tr>
	                                        	<td>
                                                	<img src="../upload/category/<?php echo $image = $news_row["photo"] != '' ? $news_row["photo"] : 'noimage.png'; ?>" style="width: 70px; min-height:50px; max-height:50px;">
                                                </td>
	                                        	<td><?php echo $news_row["category_name_geo"]; ?></td>
	                                        	<td><?php echo $news_row["description_geo"]; ?></td>
                                                <td>
                                                <!-- პოპაფ არეა -->
                                                
                                                <form   method="post" id="setStatus">
                                                    <label class="switch">
                                                      <input type="checkbox" class="setStatus" name="setStatus" data-id="<?php echo $news_row["id"]; ?>" <?php if($news_row["status"] == 1){ echo 'checked';} ?>>
                                                      <div class="slider round"></div>
                                                    </label>
                                                </form>
                                                
                                                </td>

												<td class="td-actions text-right" >
													<form  class="editDel" method="post" action="edit_category.php">
                                                	<input type="hidden" name="designerId" value="<?php echo $news_row["id"]; ?>">
                                                    <button type="submit" rel="tooltip" title=""  class="btn btn-primary btn-simple btn-xs" data-original-title="რედაქტირება">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    </form>
                                                    
                                                    <form method="post"  class="editDel"  id="submit-form">
                                                        <button type="button" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs submitBtn" data-id="<?php echo $news_row["id"]; ?>"  data-original-title="წაშლა">
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
									<?php
									
									//create the page links
									echo $pages->page_links();
									
									?>
							</ul>



	                    </div>
	                    <!--left side-->


					<div class="col-md-4">
						<div class="card">
								<div class="card-header card-chart" data-background-color="blue">
                                	<h4 class="title">	
                                        <a href="add_category.php" class="inlineAdd">
                                            <i class="material-icons" style="font-size: 50px;">add_box</i> 
                                            <p>მაღაზიის დამატება</p>
                                        </a>
                                	</h4>
								</div>
								<!--
								<div class="card-content" style="padding-top: 10px;">
									<p class="category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 5 </span>-დამატებული </p>
								</div>-->
								<div class="card-footer">
									<div class="stats"><a href="category_view.php" class="bluei">მაღაზიების რაოდენობა <h3 class="title right">0</h3> </a></div>
								</div>
						</div>
					</div>



					<div class="col-md-4">
						<div class="card">
                            <div class="card-header card-chart" data-background-color="red">
                                <h4 class="title">	
                                    <a href="add_product.php" class="inlineAdd">
                                        <i class="material-icons" style="font-size: 50px;">add_box</i> 
                                        <p>პროდუქტის დამატება</p>
                                    </a>
                                </h4>
                            </div>
                            <!--
                            <div class="card-content">
                                <p class="category"><span class="redi"><i class="fa fa-long-arrow-up"></i> 55%  </span>-იანი ზრდა </p>
                            </div>-->
                            <div class="card-footer">
                                <div class="stats"><a href="products_view.php" class="redi">პროდუქტების რაოდენობა <h3 class="title right"><?php countResult("product"); ?></h3> </a></div>
                            </div>
                        </div>
					</div>



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
					$.post('', {table_name: 'category', data_id: currentId});
				location.reload();	
			});
			
			$("#setStatus .setStatus").change(function(){
				var status;
				var statusId;
					if($(this).is(":checked")) {
						status = 1; 
					}else{
						status = 0;
					}
					statusId = $(this).data("id");

					$.post('', {table_name: 'category', setStatus: status, status_id: statusId});
			});
		
		});
		
    </script>


	<!--image upload-->
	<script src="js/image_upload.js"></script>
	<!--   Core JS Files   -->

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
