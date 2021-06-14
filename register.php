<?php
session_start();
include("./config/Library.php");
$pdo = new Library();
$table = "dt_user";
if(isset($_POST["submit"])) {
  $username = $_POST["username"];
  $hasil = $pdo->login("dt_user", $username);
  if($hasil["row"] < 1) {
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $pdo->register($table, ["username" => $_POST["username"], "password" => $password, "role" => "User"]);
    header("location:login.php");
  } else {
    $_SESSION["msg"] = "Username tidak tersedia!";
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
    <title>Register- PBD CRUD 2 TIER</title>
  </head>
  <body>
    <div class='container'>
      <div class='title-a'>
        <h2>Register</h2>
      </div>
      <div class='form'>
        <form action='register.php' method='post'>
        <?php if(isset($_SESSION["msg"])) { echo "<p class='msg'>* ".$_SESSION['msg']."</p>"; unset($_SESSION["msg"]); } ?>
          <input type='text' name='username' placeholder='Username' required/>
          <input id="enterPass" class="password" type='password' name='password' placeholder='Password' required/>
          <i class="fas fa-eye fa-sm field-icon toggle-password"></i>
          <div class="requirements-list">
            <ul class="requirements">
              <li><i id="uppercase" class="far fa-check-circle"></i> Huruf Besar</li>
              <li><i id="number" class="far fa-check-circle"></i> Angka</li>
              <li>
                <i id="special" class="far fa-check-circle"></i> Karakter Spesial
              </li>
              <li>
                <i id="eight-chars" class="far fa-check-circle"></i> Karakter > 8
              </li>
            </ul>
          </div>
          <input id="confirmPass" class="password" type='password' name='confirmPassword' placeholder='Confirm Password'/>
          <div class="passSuccess">
            <i class="fas fa-check-circle fa-2x"></i><span>Password Cocok!</span>
          </div>
          <input type='submit' class='btn blue' name='submit' value='REGISTER'>
        </form>
        <a href="./login.php"><button class="btn" id="register">Login</button></a>
      </div>
    </div>
    <script src="./public/jquery-3.6.0.min.js"></script>
    <script src="./public/script.js"></script>
  </body>
</html>