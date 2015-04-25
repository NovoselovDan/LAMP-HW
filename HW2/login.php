<?php
	//Turn on all errors
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');

  // Initialize session for this request.
  session_start();

  // List of all users - no DB =(
$data = fopen ( 'users.csv', 'r' );
for($i=0; $info = fgetcsv ($data, 300, ";"); $i++){
    list($mail, $pass, $name, $gender ,$role) = $info;
}
  // Forward user to main page in case he is authorized already.
  if(!empty($_SESSION['auth'])){
  	header("Location:index.php");
  exit();
  }
  //if(isset($_POST['submitButton'])){ // Here we have to check 2 fields - no submit check
  if(isset($_POST['login']) && isset($_POST['password'])){
  	$notice = 'Wrong login-password.';
  	
  // Find our user.
  $data = fopen ( 'users.csv', 'r' );
  for($i=0; $info = fgetcsv ($data, 300, ";"); $i++){
    list($mail, $pass, $name, $gender ,$role) = $info;
    if($mail == $_POST['login'] && $pass == md5($_POST['password'])){
      $_SESSION['auth'] = array(
        'email'   => $mail,
        'name'    => $name,
        'role'    => $role,
      );     
      header('Location:index.php');
      exit();
    }
  }
  	// foreach($users as $user){
  	// 	// Right user? Save data to session and send response with information about forwarding to profile script.
  	// 	if($user['email'] == $_POST['login'] && $user['password'] == md5($_POST['password'])){
  			// $_SESSION['auth'] = array(
  			// 		'email'		=> $user['email'],
  			// 		'name'		=> $user['name'],
  			// 		'role'		=> $user['role'],
  			// 	);
  	// 		header('Location:profile.php');
  	// 		exit();
  	// 	}
  	// }
  }
?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Authentication example</title>
  <style>
  	/* One width value for all labels - nice form view */
  	.form-line label{
  		display:inline-block;
  		width:150px;
  	}
  	.notice{
  		font-size:1.2em;
  		font-style:italic;
  	}
  </style>
</head>
<body>
	<form action="" method="POST">
		<?php
			// Some general notice(error) about form? Display it.
			if(!empty($notice)){
				echo '<div class="notice">'.$notice.'</div>';
			}
		?>
		<div class="form-line">
			<label for="login">E-mail</label>
			<?php /* Function htmlspecialchars is needed below for security reasons. Check out its description at php.net. */ ?>
			<input name="login" id="login" type="email" placeholder="email@example.com"<?php echo empty($_POST['login'])?'':' value="'.htmlspecialchars($_POST['login']).'"' ?>>
		</div>
		<div class="form-line">
			<label for="password">Password</label>
			<input name="password" id="password" type="password">
		</div>
		<input type="submit" name="submitButton" value="Login">
	</form>
</body>
</html>