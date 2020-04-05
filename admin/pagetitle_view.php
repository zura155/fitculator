<?php session_start(); 


$currentPagee = 'title';

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
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href='css/roboto.css' rel='stylesheet' type='text/css'>
	<script src="tinymce/tinymce.min.js"></script>
	<script>tinymce.init({selector:'textarea'});</script>
	<!--image-->
	<link rel="stylesheet" type="text/css" href="css/image_upload.css">
	<style>
		#text-list-table tr input, #text-list-table tr .btn-group {
    	display: none;
		}
	</style>
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
						<a class="navbar-brand" href="company.php">სათაურები</a>
					</div>


					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">notifications_active</i>
									<span class="notification">5</span>
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
									<li style="padding-top: 5px;"> <a href="user.php"><i class="material-icons" style="font-size: 18px; padding-right: 10px; padding-bottom: 1px;">settings</i>პროფილი</a></li>
									<li style="padding-top: 5px;"><a href="?action=logout"><i class="material-icons" style="font-size: 18px; padding-right: 10px; padding-bottom: 1px;">delete_forever</i>	გამოსვლა ( <b><?php echo $_SESSION['username']; ?></b> )</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>


			<!--start full content-->
	       <div class="content">
<!--	       <div class="container-fluid">
	                <div class="row">

	                   <div class="col-md-12">
							<div class="card card-nav-tabs">

								
								<div class="card-header" data-background-color="purple">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
											<span class="nav-tabs-title">ტექსტები</span>
											<ul class="nav nav-tabs" data-tabs="tabs">
												
											</ul>
										</div>
									</div>
								</div>-->

								
<div class="container-fluid">

    <div class="panel panel-dark table-wrapper">

        <div class="panel-heading">

            <form id="search-form">

                <div class="input-group">

                    <input type="text" class="form-control" id="search-input" placeholder="Search Text">

                    <span class="input-group-btn">

                        <button class="btn btn-default" type="submit">Search</button>

                    </span>

                </div>

            </form>

        </div>

        <div class="panel-body">

            <div class="progress hidden" style="height: 5px">

                <div class="progress-bar progress-bar-striped active" role="progressbar" style="width: 100%"></div>

            </div>

            <table class="table table-responsive hidden" id="text-list-table">

                <tr>

                    <td class="key">

                        <input class="form-control" readonly type="text" name="Dictionary_Key">

                        <span></span>

                    </td>

                    <td class="val_ge">

                        <input class="form-control" type="text" name="Dictionary_value_ge">

                        <span></span>

                    </td>

                    <td class="val_en">

                        <input class="form-control" type="text" name="Dictionary_value_eng">

                        <span></span>

                    </td>
					
					<td class="val_rus">

                        <input class="form-control" type="text" name="Dictionary_value_rus">

                        <span></span>

                    </td>
					

                    <td class="button" style="width: 200px">

                        <button type="button" class="edit-button btn btn-primary">

                            <i class="glyphicon glyphicon-pencil"></i>

                        </button>

                        <div class="btn-group">

                            <button type="button" class="save-button btn btn-success">

                                <i class="glyphicon glyphicon-ok"></i>

                            </button>

                            <button type="button" class="cancel-button btn btn-danger">

                                <i class="glyphicon glyphicon-remove"></i>

                            </button>

                        </div>

                    </td>

                </tr>

            </table>

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
    	 $(document).ready(function () {

        var $table = $('#text-list-table');

        var $tr = $table.children(":first").clone();
        $table.html('').removeClass('hidden');

        $('#search-form').on('submit', function (e) {

            e.preventDefault();
            var datalist_value = $('#search-input').val();

            if(datalist_value.length >= 3){

                $('.progress').removeClass('hidden');

                $table.html('');

                $.ajax({

                    type: 'POST',

                    url: "dictionary_find.php",

                    data: {

                        datalist_value : datalist_value

                    }

                }).done(function (data) {

                    $('.progress').addClass('hidden');

                    obj1 = JSON.parse(data);

                    if(obj1[0].status_code === 200){

                        var textList = obj1[0].response_text;

                        if (textList.length) {

                            for (var i in textList) {

                                var textData = textList[i];

                                var newRow = $tr.clone();

                                newRow.find('.key .form-group span').html(textData.Dictionary_Key);

                                newRow.find('.key .form-group').find('input[name=Dictionary_Key]').val(textData.Dictionary_Key);

                                newRow.find('.val_ge .form-group span').html(textData.Dictionary_value_ge);

                                newRow.find('.val_ge .form-group').find('input[name=Dictionary_value_ge]').val(textData.Dictionary_value_ge);

                                newRow.find('.val_en .form-group span').html(textData.Dictionary_value_eng);

                                newRow.find('.val_en .form-group').find('input[name=Dictionary_value_eng]').val(textData.Dictionary_value_eng);
								
								 newRow.find('.val_rus .form-group span').html(textData.Dictionary_value_rus);

                                newRow.find('.val_rus .form-group').find('input[name=Dictionary_value_rus]').val(textData.Dictionary_value_rus);

                                $table.append(newRow)

                            }

                        } else {

                            $table.html('No Result');

                        }

                    }

                });

            }



        })



        $(document).on('click', '.edit-button', function(e) {

            var $parentTr = $(this).closest('tr');

            $parentTr.addClass('changing');

        });



        $(document).on('click', '.cancel-button', function(e) {

            var $parentTr = $(this).closest('tr');

            $parentTr.removeClass('changing');

        });



        $(document).on('click', '.save-button', function(e) {

            var $parentTr = $(this).closest('tr');

            var key = $parentTr.find('input[name=Dictionary_Key]').val();

            var geValue = $parentTr.find('input[name=Dictionary_value_ge]').val();

            var enValue = $parentTr.find('input[name=Dictionary_value_eng]').val();
			var rusValue = $parentTr.find('input[name=Dictionary_value_rus]').val();

            if (key && geValue && enValue) {

                $.ajax({

                    type: 'POST',

                    url: "dictionary_change.php",

                    data: {

                        dictionary_key : key,

                        Dictionary_value_ge : geValue,

                        Dictionary_value_eng : enValue,
						Dictionary_value_rus : rusValue

                    }

                }).done(function (data) {

                    obj1 = JSON.parse(data);

                    len=obj1.length;

                    //alert (len);

                    //bootbox.alert(obj1[len-2].response_text);
					alert(obj1[len-2].response_text);
					location.reload();
                    $parentTr.find('.val_ge span').html(geValue);

                    $parentTr.find('.val_en span').html(enValue);

                    $parentTr.removeClass('changing');

                });

            }

        });

    })
	</script>
	

<style>

    #text-list-table tr input, #text-list-table tr .btn-group {

        display: none;

    }

    #text-list-table tr.changing input, #text-list-table tr.changing .btn-group {

        display: initial;

    }

    #text-list-table tr.changing span, #text-list-table tr.changing .edit-button {

        display: none;

    }

</style>

</html>
<!--by Webmania-->
