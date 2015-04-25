<?php
$orderArray;
session_start();
?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Список заказов</title>
  <script type="text/javascript">
  </script>
</head>
<body>
	<?php
	if(!empty($_SESSION['auth'])&&$_SESSION['auth']['role']=='admin'){
		$orderArray;
		$f = fopen('users.csv', 'r');
		for($i=0; $data = fgetcsv ($f, 300, ";"); $i++) {
			list($mail, $pass, $name, $gender ,$role) = $data;
			$temp = array('mail' => $mail, 'name' => $name, 'role' => $role);
			$orderArray[] = $temp;
		}
		?>
		<a href="index.php">На главную</a>
		<table>
		<caption>Список пользователей</caption>
		<tr>
			<th>E-mail</th>
		    <th>Имя</th>
		    <th>Права доступа</th>
		    <th></th>
		</tr>
		<?php
		$iterator=0;
		foreach ($orderArray as $key => $value) {
			echo "<tr>";
			echo "<td>".$value['mail']."</td>";
			echo "<td>".$value['name']."</td>";
			echo "<td>".$value['role']."</td>";
			echo "<td>".'<input type="button" name="del" value="изменить" onclick=""/>'."</td>";
			echo "</tr>";
			$iterator+=1;
		}
		?>
		</table>
		<form>
			<input type='submit' name='submit' value='сохранить'>
		</form>
		<?php
	}
	else{
		?>
		<h1>Вы не имеете прав доступа</h1>
		<a href="index.php">На главную</a>
		<?php
	}
	?>
</body>
</html>