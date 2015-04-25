<?php
	session_start();
?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Заказ</title>
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
		    width:160px;
	  	}
	</style>
	<script type="text/javascript">
		function backToIndex(){
			window.location.href = "index.php";
		}
	</script>
</head>
<?php
if(empty($_SESSION['auth']))
{
	?>
	<h1>Требуется аутентификация!</h1>
	<?php
}
else{
	?>

	<body>
	<?php
	function printSelect($names, $item){
		$selectedItem = ($item!=='0') ? $item : '';
		$prices2 = array('ПК'=>'500','Ноутбук'=>'800','Планшет'=>'1000','Смартфон'=>'400');
		echo "<select name=\"selectedType\" id=\"selectionBoxID\">\n";
		echo "\t<option value=\"0\" selected disabled>Выберите товар</option>\n";
		foreach ($names as $k => $v) {
			$str = $v.' '.$prices2[$v].'USD';
		    echo "\t<option value=\"$k\"";
	    	if ($k == $selectedItem) 
	        	echo " selected";
		    echo ">$str</option>\n";
		}
		echo "</select>\n";

	function save2csv(array &$array){
	  	$f=fopen('order.csv','a+');
		fputcsv($f,$array,';'); 
		fclose($f);
	}

	}
		$prices = array('1'=>'500','2'=>'800','3'=>'1000','4'=>'400');
		$names = array('1'=>'ПК','2'=>'Ноутбук','3'=>'Планшет','4'=>'Смартфон');
	   	$name = isset($_POST['name']) ? $_POST['name'] : '';
	   	$itemCount = isset($_POST['count']) ? $_POST['count'] : 0;
		$item = ($_POST['selectedType']!=='') ? $_POST['selectedType'] : '0';
		$discr = ($_POST['description']!=='') ? $_POST['description'] : ''
	?>

	<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
		<div class="form-line">
			<label for="text">ФИО:</label>
			<input type="text" name="name" id="nameFieldID" value="<?=$_SESSION['auth']['name'] ?>">
		</div>
		<div class="form-line">
			<label>Выберите товар:</label>
			<?printSelect($names, $item);?>
		</div>
		<div class="form-line">
			<label for="number">Количество:</label>
			<input type="number" name="count" min="0" value="<?=$itemCount?>">
		</div>
		<div class="form-line">
			<label for="text">Примечание:</label>
			<input type="text" name="description" value="<?=$discr?>">
		</div>
		<div class="form-line">
			<input type="submit" name="submit" value="Рассчитать"> <input type="reset" name="reset" value="Сбросить"> 
		</div>
	</form>
	<div class="form-line">
		<!-- <a href="index.php">Отмена заказа</a> -->
		<input type="button" name="Cancel" value="Отменить" onclick="backToIndex()">
	</div>
	<?php
		if (isset($_POST['submit'])) {
			echo '<div class="form-line"><br>';
			if ($_POST['name']=='') {
				?>
				Введите имя!<br>
				<div class="form-line">
				<?php
			} else if ($_POST['selectedType']=='') {
				echo "Выберите товар!<br></div>";
			} else {
				?>
				<div class="form-line">
					<label for="textt">Имя:</label>
					<?=$_POST['name']?>
				</div>
				<div class="form-line">
					<label>Выбранный товар:</label>
					<?=$names[$item].'('.$prices[$item].'/шт.)'?>
				</div>
				<div class="form-line">
					<label>В количестве:</label>
					<?=$itemCount?> шт.
				</div>
				<div class="form-line">
					<label>Итого:</label>
					<?=$prices[$item]*$itemCount?> USD
				</div>
				<?php
				// echo "Имя: <b>" .$_POST['name'] ."</b><br>";
				//echo "Выбранный товар: <b>" .$names[$item] ."</b> (" .$prices[$item] ."\$/шт.)" ."в количестве: <b>" .$itemCount ."</b> шт.<br>";
				//echo "Итого: <i><b>" .$prices[$item]*$itemCount ."</b> USD</i><br>";
				if ($_POST['description']!=='')
					echo "Дополнительная информация: <b>" .$discr ."</b><br>";

				$order = array($_POST['name'], "$names[$item]", "$prices[$item]", "$itemCount", $prices[$item]*$itemCount, "$discr");
				save2csv($order);
			}	
		}

	?>
	<?php
}
?>
</body>
</html>
