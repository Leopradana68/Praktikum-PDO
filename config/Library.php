<?php
class Library {
  public function __construct() {
    $hostname = "localhost";
    $dbname = "akademik";
    $username = "root";
    $password = "";
    $this->db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password, array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
  }

  public function getAll($table) {
    try {
      $query = $this->db->prepare("SELECT * FROM $table");
      $query->execute();
      $data = $query->fetchAll();
      return $data;
    } catch (PDOExeption $err) {
      return "Gagal Mendapatkan Data ".$err->getMessage();
    }
  }

  public function getOne($table, $id) {
    try {
      $where_field = ($table == "dt_prodi") ? "idprodi=$id" : "id=$id";
      $query = $this->db->prepare("SELECT * FROM $table WHERE $where_field");
      $query->execute();
      $data = $query->fetch();
      return $data;
    } catch (PDOExeption $err) {
      return "Gagal Mendapatkan Data ".$err->getMessage();
    }
  }

  public function add($table, $input) {
    try {
      $fields = implode(", ", array_keys($input));
      $values = '"'.implode('", "', array_values($input)).'"';
      $query = $this->db->prepare("INSERT INTO $table ($fields) VALUES ($values)");
      $query->execute();
      return "Berhasil Menambahkan Data ".$query->rowCount();
    } catch (PDOExeption $err) {
      return "Gagal Menambahkan Data ".$err->getMessage();
    }
  }

  public function update($table, $input) {
    try {
      $f = array_keys($input);
      $v = array_values($input);
      $query = $this->db->prepare("UPDATE $table set $f[1]='$v[1]', $f[2]='$v[2]', $f[3]='$v[3]' WHERE $f[0]=$v[0]");
      $query->execute();
      return "Berhasil Memperbarui Data ".$query->rowCount();
    } catch (PDOExeption $err) {
      return "Gagal Memperbarui Data ".$err->getMessage();
    }
  }

  public function delete($table, $id) {
    try {
      $idfield = ($table == "dt_prodi") ? "idprodi" : "id";
      $query = $this->db->prepare("DELETE FROM $table where $idfield=$id");
      $query->execute();
      return "Berhasil Menghapus Data ".$query->rowCount();
    } catch (PDOExeption $err) {
      return "Gagal Menghapus Data ".$err->getMessage();
    }
  }

  public function login($table, $username) {
    try {
      $query = $this->db->prepare("SELECT * FROM $table WHERE username='$username'");
      $query->execute();
      $data = ["data" => $query->fetch(), "row" => $query->rowCount()];
      return $data;
    } catch (PDOExeption $err) {
      return "Gagal Mendapatkan Data ".$err->getMessage();
    }
  }

  public function register($table, $input) {
    try {
      $fields = implode(", ", array_keys($input));
      $values = '"'.implode('", "', array_values($input)).'"';
      $query = $this->db->prepare("INSERT INTO $table ($fields) VALUES ($values)");
      $query->execute();
      return "Berhasil Menambahkan Data ".$query->rowCount();
    } catch (PDOExeption $err) {
      return "Gagal Menambahkan Data ".$err->getMessage();
    }
  }
}
?>