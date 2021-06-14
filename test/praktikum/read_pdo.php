<?php
$host = "localhost";
$user = "root";
$password = "";
$database_name = "test";
$pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$query = $pdo->prepare("SELECT * FROM siswa");
$query->execute();
?>

<table>
  <tr>
    <td>NIS</td>
    <td>Nama</td>
    <td>Jenis Kelamin</td>
    <td>Tanggal Lahir</td>
  </tr>
  <?php while($siswa = $query->fetch()) { ?>
  <tr>
    <td><?= $siswa["nis"]; ?></td>
    <td><?= $siswa["nama"]; ?></td>
    <td><?= $siswa["jenis_kelamin"]; ?></td>
    <td><?= $siswa["tgl_lahir"]; ?></td>
  </tr>
  <?php } ?>
</table>