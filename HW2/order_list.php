<?php
$orderArray;
function save2csv(array &$array){
  	$f=fopen('order.csv','w');
	fputcsv($f,$array,';'); 
	fclose($f);
}

function arrDelAtIndex($index){
	unset($$_GLOBALS['arr'][$index]);
	// save2csv($arr);
}
session_start();
?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Список заказов</title>
  <script type="text/javascript">
  function delAtIndex(index){
  	alert("Заказ удален<?php arrDelAtIndex(index); ?>");
  }
  </script>
</head>
<body>
	<?php
	if (isset($_POST['submit'])){
		save2csv($_GLOBALS['arr']);
	}

	if(!empty($_SESSION['auth'])&&$_SESSION['auth']['role']=='admin'){
		$orderArray;
		$f = fopen('order.csv', 'r');
		for($i=0; $data = fgetcsv ($f, 300, ";"); $i++) {
			list($name, $item, $price, $count ,$totalPrice, $description) = $data;
			$temp = array('name' => $name, 'item' => $item, 'price' => $price, 'count' => $count, 'totalPrice' => $totalPrice, 'description' => $description);
			$orderArray[] = $temp;
		}
		$_GLOBALS['arr']=$orderArray;

		?>
		<a href="index.php">На главную</a>
		<table>
		<caption>Текущие заказы</caption>
		<tr>
			<th>Имя заказчика</th>
		    <th>Товар</th>
		    <th>Цена</th>
		    <th>Кол-во</th>
		    <th>Итого</th>
		    <th>Описание</th>
		    <th></th>
		</tr>
		<?php
		$iterator=0;
		foreach ($orderArray as $key => $value) {
			echo "<tr>";
			echo "<td>".$value['name']."</td>";
			echo "<td>".$value['item']."</td>";
			echo "<td>".$value['price']."</td>";
			echo "<td>".$value['count']."</td>";
			echo "<td>".$value['totalPrice']."</td>";
			echo "<td>".$value['description']."</td>";
			echo "<td>".'<input type="button" name="del" value="удалить" onclick="delAtIndex('.$iterator.')"/>'."</td>";
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