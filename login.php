<?php
session_start();
include("./config/Library.php");
$pdo = new Library();
if(isset($_POST["submit"])) {
  $username = $_POST["username"];
  $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
  $hasil = $pdo->login("dt_user", $username);
  if($username != "" && $password != "") {
    if($hasil["row"] == 1) {
      if(password_verify($_POST["password"], $hasil["data"]["password"])){
        if($hasil["data"]["role"] == "Admin") {
          $_SESSION["role"] = $hasil["data"]["role"];
          $_SESSION["username"] = $hasil["data"]["username"];
          header("location:admin/index.php");
        } else {
          $_SESSION["role"] = $hasil["data"]["role"];
          $_SESSION["username"] = $hasil["data"]["username"];
          header("location:user/index.php");
        }
      } else {
        $_SESSION["msg"] = "Password salah!";
      }
    } else {
      $_SESSION["msg"] = "Username salah!";
    }
  } else {
    $_SESSION["msg"] = "Jangan kosongkan form!";
  }
}

?>

<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='UTF-8'/>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
    <link rel='stylesheet' href='./public/style.css'>
    <link rel='stylesheet' href='./public/fontawesome/css/all.css'/>
    <title>Login - PBD CRUD 2 TIER</title>
  </head>
  <body>
    <div class='container'>
      <div class='title-a'>
        <h2>Login</h2>
      </div>
      <div class='form'>
        <form action='login.php' method='post'>
          <?php if(isset($_SESSION["msg"])) { echo "<p class='msg'>* ".$_SESSION['msg']."</p>"; unset($_SESSION["msg"]); } ?>
          <input type='text' name='username' placeholder='Username'/>
          <input class="password" type='password' name='password' placeholder='Password'/>
          <i class="fas fa-eye fa-sm field-icon toggle-password"></i>
          <input type='submit' class='btn blue' name='submit' value='LOGIN'>
        </form>
        <a href="./register.php"><button class="btn" id="register">Register</button></a>
      </div>
    </div>
    <script src="./public/jquery-3.6.0.min.js"></script>
    <script src="./public/script.js"></script>
  </body>
</html>