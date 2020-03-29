<?php 
@session_start();
include('config/database.php');


if (isset($_SESSION['admin_user']) && $_SESSION['admin_user'] != ''){
  header("location: index.php");
  exit(0);
}
// ------------------- session ----------------------------

if (isset($_GET['login']) && $_GET['login'] == 'true'){
  $username = isset($_POST['user']) ? $_POST['user'] : '';
  $password = isset($_POST['pass']) ? $_POST['pass'] : '';
  
  
  $q = mysql_query("SELECT id, username, userpass FROM `admin` WHERE username = '{$username}' AND userpass = '{$password}' LIMIT 1") or die (mysql_error());
  $r = mysql_fetch_assoc($q);
  
  if (!empty($r)){
    $_SESSION['id'] = $r['id'];
    $_SESSION['username'] = $r['username'];
    $_SESSION['userstatus'] = $r['userstatus'];
    header("location: index.php");
  } else {
    echo '';

  }
}

?>




<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>GreenAdmin</title>
  <link rel="shortcut icon" type="image/x-icon" href="img/logo.png"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="css/login_styles.css">
</head>


<body>
  <div class="container row login-box">
  <div class="col login-title">

    <strong class="error">
      <?php


      if (isset($_GET['login']) && $_GET['login'] == 'true'){
        $username = isset($_POST['user']) ? $_POST['user'] : '';
        $password = isset($_POST['pass']) ? $_POST['pass'] : '';
        
        
        $q = mysql_query("SELECT id, username, userpass FROM `admin` WHERE username = '{$username}' AND userpass = '{$password}' LIMIT 1") or die (mysql_error());
        $r = mysql_fetch_assoc($q);
        
        if (!empty($r)){
          $_SESSION['id'] = $r['id'];
          $_SESSION['username'] = $r['username'];
          $_SESSION['userstatus'] = $r['userstatus'];
          header("location: index.php");
        } else {

          echo 'შეიყვანე სწორი მონაცემები';
        }
      }

      ?>
    </strong>
    <h1> გამარჯობა  </h1>
    <span class="small-text" style="color: #FFF;">GreenAdmin!</span>
  </div>

  <div class="col login-form">
    <div class="avatar">

    <p class="fa fa-user" aria-hidden="true" style="font-size: 50px; color: #FFF; margin-top: 25px;"></p>
      
    </div>

    <form method="POST" action="?login=true">
      <label for="login" class="login">
        <input id="login" type="text" placeholder="მომხმარებელი" name="user" required />
      </label>

      <label for="passwd" class="passwd">
        <input id="passwd" type="password" placeholder="პაროლი" name="pass" required />
      </label>

      <button class="button" type="submit">შესვლა</button>
      <input type="hidden" style="border:none;" name="login" value="true" />
      <input type="hidden" name="dalogineba"  />
      </form>

    <div class="lost-passwd">
      <a href="#">პაროლის აღდგენა</a>
    </div>

  </div>
</div>
  

<script src="js/index.js"></script>
</body>
</html>
