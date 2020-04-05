<?php
// მონაცემების რაოდენობა 
function countResult($tablename) 
{
	$countResult = mysql_query("SELECT COUNT(*) AS `count` FROM `".$tablename."`");
	$countrow = mysql_fetch_assoc($countResult);
	echo $count = $countrow['count'];

}

// bazis gamopdzaxeba
// require_once ("database.php");


// languages

//	mysql_query("set character set utf8");
	
	if(isset($_POST['lang'])){
			$GLOBALS['lang']  = $_POST['lang'];
			$_SESSION['lang'] = $_POST['lang'];
		}elseif(isset($_SESSION['lang'])){
			$GLOBALS['lang'] = $_SESSION['lang'];
		}else{ 
		$GLOBALS['lang'] = 'geo'; 
		$_SESSION['lang'] = $lang;
		}

	include("lang/".$lang.".php");

?>	
<form method="post" id="testlang">
    <input type="hidden" name="lang" id="lang" />
</form>
    
<script type="text/javascript">     
	function changelang(lang){
		document.getElementById("lang").value=lang;
		document.getElementById("testlang").submit();
	}
</script>