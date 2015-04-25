<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style>
	  .form-line{
	    clear:both;
	  }
	  .form-line input, .form-line select{
	    display:block;
	    float:left;
	  }
	  .form-line label{
	    display: block;
	    float:left;
	    width:200px;
	  }
	</style>
</head>
<body>
  <?php
  function save2csv(array &$array){
    $f=fopen('users.csv','a+');
    fputcsv($f,$array,';'); 
    fclose($f);
  }
  //Errors for submitted form
  $emailPattern = "/^\w[-._\w]*\w@\w[-._\w]*\w\.\w{2,3}$/";
  $notices = array();
  //Has user submit a form?
  if(isset($_POST['register'])){
    //Check submitted data
    if(($_POST['email'])=='' || ($_POST['password'])=='' || ($_POST['repassword'])=='' || ($_POST['realName'])==''){
      $notices[] = 'Заполните поля, помеченные *.';
    }
    else{
      if(!preg_match($emailPattern, $_POST['email'])){
        $notices[] = 'E-mail введен неправильно.';
      }
      //User has to repeat password
      if($_POST['password'] !== $_POST['repassword']){
        $notices[] = 'Пароли не соответствуют.';
      }
      //Unexpected value - just null it
      if($_POST['sex']!=='1' && $_POST['sex']!=='0'){
        $_POST['sex'] = -1;
      }
    }
    if(count($notices)){
      //Output form notices
      echo '<h4>Форма заполнена неправильно.</h4><ul>';
      foreach($notices as $notice){
        echo '<li>'.$notice.'</li>';
      }
      echo '</ul><br>';
    }
    else{
      //No notices? Register!
      $data = array(
        'email'    => $_POST['email'],
        'password' => md5($_POST['password']),
        'realName' => $_POST['realName'],
        'sex'      => (isset($_POST['sex'])?$_POST['sex']:'-1'),
        'role'     => 'user',
      );
      save2csv($data);
      // file_put_contents('data/users', implode(' ', $data)."\n", FILE_APPEND) !== FALSE
      //                or die('Error with writing to DB!');
      echo '<h3>Вы успешно зарегистрированы!</h3>';
    }
  }
  ?>
  <?php
  if( (isset($_POST['register']) && count($notices)) || !isset($_POST['register']) ){
    ?>
    <form action="" method="POST">
      <div class="form-line">
        <label for="email">E-mail *</label>
        <input type="email" name="email" id="email" placeholder="example@mail.com" required<?=(isset($_POST['email'])?' value="'.$_POST['email'].'"':'')?>>
      </div>
      <div class="form-line">
        <label for="password">Пароль *</label>
        <input type="password" name="password" id="password" required<?=(isset($_POST['password'])?' value="'.$_POST['password'].'"':'')?>>
      </div>
      <div class="form-line">
        <label for="repassword">Повторите пароль*</label>
        <input type="password" name="repassword" id="repassword" required<?=(isset($_POST['repassword'])?' value="'.$_POST['repassword'].'"':'')?>>
      </div>
      <div class="form-line">
        <label for="realName">Имя *</label>
        <input type="text" name="realName" id="realName" placeholder="Введите ваше имя" required<?=(isset($_POST['realName'])?' value="'.$_POST['realName'].'"':'')?>>
      </div>
      <div class="form-line">
        <label for="sex">Пол</label>
        <select name="sex" id="sex">
          <option value="-1">Please select</option>
          <option value="1"<?=(isset($_POST['sex'])?($_POST['sex']==="1"?' selected':''):'')?>>Муж.</option>
          <option value="0"<?=(isset($_POST['sex'])?($_POST['sex']==="0"?' selected':''):'')?>>Жен.</option>
        </select>
      </div>
<!--       <div class="form-line">
        <label for="subscription">News subscription</label>
        <input type="checkbox" name="subscription" id="subscription"<?=(isset($_POST['subscription'])?' checked':'')?>>
      </div> -->
      <div class="form-line">
        <input type="submit" name="register" value="Зарегистрироваться">
      </div>
    </form>
    <?php
  }
  ?>
</body>
</html>
