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
  <title>HW2</title>
</head>
<body>
  <h1>Здраствуйте, <?php echo !empty($_SESSION['auth'])?$_SESSION['auth']['name']:"гость"  ?>!</h1>
  <?php
    $check = !empty($_SESSION['auth']);
    if (!empty($_SESSION['auth'])){
      ?>
      <a href="profile.php">Профиль</a><br>
      <?php
        if ($_SESSION['auth']['role']=='admin'){
          echo '<a href="user_list.php">Список пользователей</a><br>';
          echo '<a href="order_list.php">Список заказов</a><br>';
        }
      ?>
      <a href="order.php">Оформить заказ</a><br>
      <a href="exit.php">Выйти</a><br>
      <?php }
    else{
      ?>
      <a href="registration.php">Зарегистрироваться</a> |
      <a href="login.php">Войти</a><br>
      <?php
    }
  ?>
  
</body>
</html>