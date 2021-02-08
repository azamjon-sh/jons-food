<?php
$foodcategory = intval($_POST['category']);
$foodname = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
$foodprice = trim(filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT));
$fooddescr = trim(filter_var($_POST['descr'], FILTER_SANITIZE_STRING));

var_dump($foodname);
$error = '';
if ($foodcategory == '') {
    $error = 'Выберите категорию блюда';
} else if (strlen($foodname) < 3) {
    $error = 'Имя слишком короткое';

} else if ($foodprice <= 0 || $foodprice == '') {
    $error = 'Укажите цену (не ниже 0)';
}
if ($error != '') {
    echo $error;
    exit();
}
require_once '../mysqlConnect.php';

$sql = 'INSERT INTO menu(name, price, descr, category) VALUES(?, ?, ?, ?)';
$query = $pdo->prepare($sql);
$query->execute([$foodname, $foodprice, $fooddescr, $foodcategory]);
echo 'Готово';
?>