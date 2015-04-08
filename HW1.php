
<html>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?php
function printSelect($names, $item){
	$selectedItem = ($item!=='0') ? $item : '';
	echo "<select name=\"selectedType\" id=\"selectionBoxID\">\n";
	echo "\t<option value=\"0\" selected disabled>Выберите товар</option>\n";
	foreach ($names as $k => $v) {
	    echo "\t<option value=\"$k\"";
    	if ($k == $selectedItem) 
        	echo " selected";
	    echo ">$v</option>\n";
	}
	echo "</select>\n";
}

	$prices = array('1'=>'500','2'=>'800','3'=>'1000','4'=>'400');
	$names = array('1'=>'ПК','2'=>'Ноутбук','3'=>'Планшет','4'=>'Смартфон');
   	$name = isset($_POST['name']) ? $_POST['name'] : '';
   	$itemCount = isset($_POST['count']) ? $_POST['count'] : 0;
	$item = ($_POST['selectedType']!=='') ? $_POST['selectedType'] : '0';
	$discr = ($_POST['description']!=='') ? $_POST['description'] : ''
?>

<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
	Введите ФИО: <input type="text" name="name" id="nameFieldID" size="46" value="<?=($name!=='') ? $name : '' ?>">
	<p>
    <?printSelect($names, $item);?>
    Количество: <input type="number" name="count" min="0" value="<?=$itemCount?>">
	</p>
   	Примечание: <input type="text" name="description" size="48" value="<?=$discr?>"><br>
    <input type="submit" name="submit" value="Рассчитать"> <input type="reset" name="reset" value="Сбросить"> 
</form>

<?php
	if (isset($_POST['reset'])) {
	}

	if (isset($_POST['submit'])) {
		echo "<hr>";
		if ($_POST['name']=='') {
			echo "Введите имя!<br>";
		} else if ($_POST['selectedType']=='') {
			echo "Выберите товар!<br>";
		} else {
			echo "Имя: <b>" .$_POST['name'] ."</b><br>";
			echo "Выбранный товар: <b>" .$names[$item] ."</b> (" .$prices[$item] ."\$/шт.)" ."в количестве: <b>" .$itemCount ."</b> шт.<br>";
			echo "Итого: <i><b>" .$prices[$item]*$itemCount ."</b> USD</i><br>";
			if ($_POST['description']!=='')
				echo "Дополнительная информация: <b>" .$discr ."</b><br>";
		}	
	}
?>
</body>
</html>
