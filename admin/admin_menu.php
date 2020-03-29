
<?php 
								$url=$_SERVER['REQUEST_URI'];;
								$page=substr($url, strrpos($url, '/') + 1);
								?>

<div class="sidebar" data-color="purple" data-image="img/sidebar-1.jpg">
			<div class="logo">
				<a href="index.php" class="simple-text"> GreenArea	</a>
			</div>

	    	<div class="sidebar-wrapper">
	            <ul class="nav">

	                <li>
	                    <a href="index.php" <?php if($page=="index.php") echo "style='background-color: #58b05c;'" ?> >
	                        <i class="material-icons">home</i>
	                        <p>მთავარი</p>
	                    </a>
	                </li>

	                <li>
	                    <a href="company.php" <?php if($page=="company.php") echo "style='background-color: #58b05c;'" ?>>
	                        <i class="material-icons">location_city</i>
	                        <p>კომპანია</p>
	                    </a>
	                </li>

	                <li class="active">
	                    <a href="products_view.php" <?php if($page=="products_view.php") echo "style='background-color: #58b05c;'" ?>>
	                        <i class="material-icons">store</i>
	                        <p>პროდუქცია</p>
	                    </a>
	                </li>

	            </ul>
	    	</div>
	    </div>