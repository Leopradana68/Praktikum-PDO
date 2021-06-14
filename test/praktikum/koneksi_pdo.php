<?php
$host = "localhost";
$user = "root";
$password = "";
$database_name = "test";
$pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
])
?>