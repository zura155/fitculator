<?php session_start(); 

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
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href='css/roboto.css' rel='stylesheet' type='text/css'>
	<script src="tinymce/tinymce.min.js"></script>
    <link href='css/fileinput.min.css' rel='stylesheet' type='text/css'>
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


			<!--start full content-->
	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">

	                   <div class="col-md-12">
							<div class="card card-nav-tabs">

								<!--satauri-->
								<div class="card-header" data-background-color="red">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
											<span class="nav-tabs-title">პროდუქტის დამატება:</span>
											<ul class="nav nav-tabs" data-tabs="tabs">
												<li class="active">
													<a href="#profile" data-toggle="tab">ქართულად<div class="ripple-container"></div></a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								
<form enctype="multipart/form-data"  id="submit-form">
									<!--form contenti-->
									<div class="card-content">
										<div class="tab-content">
										<!-- georgian -->
													<div class="tab-pane active" id="profile">
						                                    <div class="row">

																<div class="col-md-12">
																	<div class="form-group label-floating">
																		<select class="option_form" name="catId">
																			
                                                                            <?php
																				$ders_sql =$product->get_producttypes();
																				foreach($ders_sql as $ders_row)
																				{
																					echo '<option value="'.$ders_row["ID"].'">'.$ders_row["Name_Geo"].'</option>';	
																				}
																			?>
																		</select>
																	</div>
						                                        </div>

						                                        <div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">პროდუქტის სახელი (GEO)</label>
																		<input type="text" class="form-control" name="name_geo">
																	</div>
						                                        </div>
																
																<div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">პროდუქტის სახელი (ENG)</label>
																		<input type="text" class="form-control" name="name_eng">
																	</div>
						                                        </div>
																
																<div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">პროდუქტის სახელი (RUS)</label>
																		<input type="text" class="form-control" name="name_rus">
																	</div>
						                                        </div>
																
																<div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">წყალი</label>
																		<input type="number" step="0.01" class="form-control" name="water">
																	</div>
						                                        </div>
																<div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">ცილები</label>
																		<input type="number" step="0.01" class="form-control" name="protein">
																	</div>
						                                        </div>
																<div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">ცხიმები</label>
																		<input type="number" step="0.01" class="form-control" name="fat">
																	</div>
						                                        </div>
																<div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">ნახშირწყლები</label>
																		<input type="number" step="0.01" class="form-control" name="Carbohydrates">
																	</div>
						                                        </div>
																<div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label">კალორია (100 გ)</label>
																		<input type="number" step="0.01" class="form-control" name="total_kcal">
																	</div>
						                                        </div>
																
																<div class="col-md-12">
																	<div class="form-group label-floating">
																		<label class="control-label" style="margin-top:36px; width: 250px;">აქტიური/გაუქმებული</label>
																		<input type="checkbox"  value="1" checked class="form-control" name="Status" style=" width: 30px; margin-left: 150px;">
																	</div>
						                                        </div>
						                                    </div>
													</div>




													<div style="clear: both; height: 10px;"></div>
												    <div class="col-lg-12" style=" border-style: dashed;  border-color: #66bb6a; border-width: 2px;">
												      
                                                    <input id="images-input" name="images[]" type="file" multiple class="file-loading" style="display: none">

												    </div>
													<div style="clear: both; height: 20px;"></div>



											<!--add button-->
		                                    <button type="submit" class="btn btn-primary pull-right" class="alert alert-info alert-with-icon" onclick="demo.showNotification('top','center')">დამატება</button>
		                                    <div class="clearfix"></div>


									 </div>
							   	</div>
							   	<!--end form content-->
</form>

							</div>



						</div>
					</div>
				</div>
			</div>
			<!--end full content-->






			
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
    <script src="js/fileinput.min.js"></script>
	<script type="text/javascript">
    	$(document).ready(function(){
			// Javascript method's body can be found in assets/js/demos.js
        	demo.initDashboardPageCharts();
    	});
	</script>
</html>
<!--by Webmania-->

<script type="text/javascript">
		
		$(document).ready(function() {
            $("#images-input").fileinput({
                uploadUrl: '/file-upload-batch/2',
                maxFilePreviewSize: 10240,
                maxFileSize: 10240,
                showCaption: false,
                showUpload: false,
                showCancel: false,
                showClose: false,
                showRemove: false,
                browseOnZoneClick: true,
                showBrowse: false,
                allowedFileTypes: ["image"],
                allowedFileExtensions: ['png', 'jpg'],
                allowedPreviewTypes: ["image"],
                removeFromPreviewOnError: true,
                msgInvalidFileType: '&quot;{name}&quot; არასწორი ფორმატის ფაილია. ნებადართულია მხოლოდ სურათები',
                msgInvalidFileExtension: '&quot;{name}&quot; არასწორი ფორმატის ფაილია. ნებადართულია მხოლოდ სურათები',
                layoutTemplates: {
                    actions: '<div class="file-actions">\n' +
                    '    <div class="file-footer-buttons">\n' +
                    '        {delete}' +
                    '    </div>\n' +
                    '    {drag}\n' +
                    '    <div class="file-upload-indicator" title="{indicatorTitle}">{indicator}</div>\n' +
                    '    <div class="clearfix"></div>\n' +
                    '</div>'
                },
                dropZoneTitle: 'ატვირთეთ სურათი',
                dropZoneClickTitle: ''
            });


$("#submit-form").submit(function(e) {
	
                		var formData = new FormData();
                            var $form = $(this);
                            var $imageInput = $("#images-input");
                            var model_data = $form.serializeArray();
                            var files = $imageInput.fileinput('getFileStack');

                            $.each(model_data,function(key,input){
                                formData.append(input.name,input.value);
                            });
                            $.each(files, function (key, value) {
                                if(value != null){
                                    formData.append("images[]", value, value.name);
                                }
                            });
                            $imageInput.val("");
                            $.ajax({
                                url: "block/add_products.php",
                                type: "POST",
                                datatype: "json",
                                data: formData,
                                processData: false,  // tell jQuery not to process the data
                                contentType: false,   // tell jQuery not to set contentType
                                success: function (response){
                                    window.location.replace('products_view.php');
                                },
                                error: function(error) {
                                	
                                }
                            });
                return false;
            });
        });
		
</script>