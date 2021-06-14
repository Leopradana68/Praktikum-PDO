<?php
$host = "localhost";
$user = "root";
$password = "";
$database_name = "test";
$pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

try {
  $query = $pdo->prepare("INSERT INTO siswa (nis, nama, jenis_kelamin, tgl_lahir) values (:nis, :nama, :jenis_kelamin, :tgl_lahir)");
  $dataSiswa = [
    ":nis" => "001",
    ":nama" => "Budi",
    ":jenis_kelamin" => "L",
    "tgl_lahir" => "1987-06-01"
  ];
  $query->execute($dataSiswa);
  echo "Data siswa telah disimpan";
} catch (PDOExeption $e) {
  echo "Error! gagal menyimpan data siswa: ".$e->getMessage();
}
?>