<?php
	//Turn on all errors
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');

  // Initialize session for this request.
  session_start();
?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Authentication example</title>
</head>
<body>
  <?php
  	if(!empty($_SESSION['auth'])){
  		?>
		  <h1><?php echo $_SESSION['auth']['name'] ?></h1>
      <h3>Права:  <?php
                  if ($_SESSION['auth']['role']=='admin') {
                    echo "Администратор";
                  } else{
                    echo "Пользователь";
                  }
                  ?></h3>
	  	<a href="index.php">Index page</a><br>
		  <a href="exit.php">Exit</a><br>
  		<?php
  	}
  	else{
  		?>
  		<h1>Authentication is needed</h1>
	  	<a href="index.php">Index page</a><br>
	  	<a href="login.php">Login page</a><br>
	  	<a href="exit.php">Exit page</a><br>
  		<?php
  	}
  ?>
</body>
</html>