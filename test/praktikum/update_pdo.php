<?php
$host = "localhost";
$user = "root";
$password = "";
$database_name = "test";
$pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

try {
  $query = $pdo->prepare("UPDATE siswa SET nama=:nama, jenis_kelamin=:jenis_kelamin, tgl_lahir=:tgl_lahir WHERE nis=:nis");
  $data = [
    ":nama" => "Budi Setio",
    ":jenis_kelamin" => "L",
    ":tgl_lahir" => "1988-06-01",
    ":nis" => "001"
  ];
  $query->execute($data);
  echo "Data siswa telah diupdate";
} catch (PDOExeption $e) {
  echo "Error! gagal mengedit data siswa: ".$e->getMessage();
}
?>