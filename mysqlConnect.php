<?php
$host = 'localhost'; // адрес сервера
$db = 'jons_food'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль
$dsn = 'mysql:host=' . $host . ';dbname=' . $db;
$pdo = new PDO($dsn, $user, $password);
?>