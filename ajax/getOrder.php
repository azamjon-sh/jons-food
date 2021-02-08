<?php
$foods = implode(",", $_POST['foods']);
$newPrice = intval($_POST['newPrice']);
$oldPrice = intval($_POST['oldPrice']);
$operator = trim(filter_var($_POST['operator'], FILTER_SANITIZE_STRING));
$client = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
$number = trim(filter_var($_POST['number'], FILTER_SANITIZE_STRING));
$address = trim(filter_var($_POST['address'], FILTER_SANITIZE_STRING));
$descr = trim(filter_var($_POST['descr'], FILTER_SANITIZE_STRING));
$orderDate = date('d.m.Y H:i');
require_once '../mysqlConnect.php';

$sql = 'INSERT INTO orders(client, number, address, foods, operator,oldPrice, newPrice, descr, orderDate) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
$query = $pdo->prepare($sql);
$query->execute([$client, $number, $address, $foods, $operator, $oldPrice, $newPrice, $descr, $orderDate]);
echo 'Готово';
?>