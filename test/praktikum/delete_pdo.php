<?php
$host = "localhost";
$user = "root";
$password = "";
$database_name = "test";
$pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

try {
  $query = $pdo->prepare("DELETE FROM siswa WHERE nis=:nis");
  $query->execute([":nis" => "001"]);
  echo "Data siswa sudah dihapus";
} catch (PDOExeption $e) {
  echo "Gagal menghapus data siswa: ".$e->getMessage();
}
?>