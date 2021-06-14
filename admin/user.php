<?php
session_start();
if($_SESSION){
  if($_SESSION['role'] == 'Admin'){
  } else {
    header('location:../login.php');
  }
} else {
  header('location:../login.php');
}

include("../config/Library.php");
$pdo = new Library();
$table = "dt_user";
$a = @$_GET["a"];
$id = @$_GET["id"];
$sql = @$_POST["sql"];

switch($sql) {
  case "create":
    create_user();
    header("location:../admin/user.php");
    break;
  case "update":
    update_user();
    header("location:../admin/user.php");
    break;
  case "delete":
    delete_user();
    header("location:../admin/user.php");
    break;
}

switch($a) {
  case "list":
    read_data();
    break;
  case "input":
    input_data();
    break;
  case "edit":
    edit_data($id);
    break;
  case "hapus":
    hapus_data($id);
    break;
  case "logout":
    logout();
    break;
  default:
    read_data();
    break;
}

?>

<?php
function read_data() {
  global $pdo;
  global $table;
  $result = $pdo->getAll($table);

  echo "<!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='UTF-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
        <link rel='stylesheet' href='../public/style.css'>
        <link rel='stylesheet' href='../public/fontawesome/css/all.css'/>
        <title>Topik 2 - PBD CRUD 2 TIER</title>
      </head>
      <body>
        <div class='container'>
          <div class='title'>
            <h2>Data User</h2>
            <p class='muted'>".$_SESSION['username']."@".$_SESSION['role']."</p>
          </div>
          <ul class='responsive-table'>
            <li class='button-input'><a href='user.php?a=input'><button class='btn blue'><i class='fas fa-plus'></i> TAMBAH</button></a></li>
            <li class='table-header green'>
              <div class='col col-1'>ID</div>
              <div class='col col-2'>USERNAME</div>
              <div class='col col-3'>PASSWORD</div>
              <div class='col col-4'>ROLE</div>
              <div class='col col-5'>AKSI</div>
            </li>";
  
  foreach($result as $row) {
    echo "<li class='table-row'>
              <div class='col col-1' data-label='ID'>".$row["id"]."</div>
              <div class='col col-2' data-label='KODE'>".$row["username"]."</div>
              <div class='col col-3' data-label='PRODI'>..........</div>
              <div class='col col-4' data-label='AKREDITASI'>".$row["role"]."</div>
              <div class='col col-5 aksi'>
                <a href='user.php?a=edit&id=".$row["id"]."'><button class='btn yellow edit'><i class='fas fa-edit'></i></button></a>
                <a href='user.php?a=hapus&id=".$row["id"]."'><button class='btn red'><i class='fas fa-trash'></i></button></a>
              </div>
            </li>";
  }

  echo "<li class='button-input btn-bot'>
              <a href='index.php'><button class='btn blue'><i class='fas fa-list'></i> List</button></a>
              <a href='index.php?a=logout'><button class='btn red'><i class='fas fa-sign-out-alt'></i> Logout</button></a>
            </li>
          </ul>
        </div>
      </body>
    </html>";
}

function input_data() {
  $row = array(
    "username" => "",
    "password" => "",
    "role" => ""
  );

  $cekAdmin = ($row["role"] == "Admin") ? "checked='checked'" : "";
  $cekUser = ($row["role"] == "User") ? "checked='checked'" : "";
 
  echo "<!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='UTF-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
        <link rel='stylesheet' href='../public/style.css'>
        <link rel='stylesheet' href='../public/fontawesome/css/all.css'/>
        <title>Topik 2 - PBD CRUD 2 TIER</title>
      </head>
      <body>
        <div class='container'>
          <div class='title-a'>
            <h2>Input Data User</h2>
          </div>
          <div class='form'>
            <form action='user.php?a=input' method='post'>
              <input type='hidden' name='sql' value='create'>
              <input type='text' name='username' value='".trim($row["username"])."' placeholder='Username'/>
              <input type='password' class='password' name='password' value='".trim($row["password"])."' placeholder='Password'/>
              <i class='fas fa-eye fa-sm field-icon toggle-password'></i>
              <group class='inline-radio'>
                <div class='akre'>Role</div>
                <div><input type='radio' name='role' value='Admin' $cekAdmin><label>Admin</label></div>
                <div><input type='radio' name='role' value='User' $cekUser><label>User</label></div>
              </group>
              <input type='submit' class='btn blue' name='action' value='TAMBAH'>
            </form>
            <a href='user.php'><button class='btn red'>BATAL</button></a>
          </div>
        </div>
        <script src='../public/jquery-3.6.0.min.js'></script>
        <script src='../public/script.js'></script>
      </body>
    </html>";
}

function edit_data($id) {
  global $pdo;
  global $table;
  $row = $pdo->getOne($table, $id);

  $cekAdmin= ($row["role"] == "Admin") ? "checked='checked'" : "";
  $cekUser = ($row["role"] == "User") ? "checked='checked'" : "";

  echo "<!DOCTYPE html>
  <html lang='en'>
    <head>
      <meta charset='UTF-8'/>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
      <link rel='stylesheet' href='../public/style.css'>
      <link rel='stylesheet' href='../public/fontawesome/css/all.css'/>
      <title>Topik 2 - PBD CRUD 2 TIER</title>
    </head>
    <body>
      <div class='container'>
        <div class='title-a'>
          <h2>Edit Data User</h2>
        </div>
        <div class='form'>
          <form action='user.php?a=edit' method='post'>
            <input type='hidden' name='sql' value='update'>
            <input type='hidden' name='id' value='".trim($id)."'/>
            <input type='text' name='username' value='".trim($row["username"])."' placeholder='Username'/>
            <input type='password' class='password' name='password' placeholder='Password Baru'/>
            <i class='fas fa-eye fa-sm field-icon toggle-password'></i>
            <group class='inline-radio'>
              <div class='akre'>Role</div>
              <div><input type='radio' name='role' value='Admin' $cekAdmin><label>Admin</label></div>
              <div><input type='radio' name='role' value='User' $cekUser><label>User</label></div>
            </group>
            <input type='submit' class='btn blue' name='action' value='PERBARUI'>
          </form>
          <a href='user.php'><button class='btn red'>BATAL</button></a>
        </div>
      </div>
      <script src='../public/jquery-3.6.0.min.js'></script>
      <script src='../public/script.js'></script>
    </body>
  </html>";
}

function hapus_data($id) {
  global $pdo;
  global $table;
  $row = $pdo->getOne($table, $id);

  $cekAdmin= ($row["role"] == "Admin") ? "checked='checked'" : "";
  $cekUser = ($row["role"] == "User") ? "checked='checked'" : "";

  echo "<!DOCTYPE html>
  <html lang='en'>
    <head>
      <meta charset='UTF-8'/>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
      <link rel='stylesheet' href='../public/style.css'>
      <link rel='stylesheet' href='../public/fontawesome/css/all.css'/>
      <title>Topik 2 - PBD CRUD 2 TIER</title>
    </head>
    <body>
      <div class='container'>
        <div class='title-a'>
          <h2>Hapus Data User</h2>
        </div>
        <div class='form'>
          <form action='user.php?a=list' method='post'>
            <input type='hidden' name='sql' value='delete'>
            <input type='hidden' name='id' value='".trim($id)."'/>
            <input type='text' name='username' value='".trim($row["username"])."' placeholder='Username' disabled/>
            <input type='password' name='password' value='..........' disabled/>
            <group class='inline-radio'>
              <div class='akre'>Role</div>
              <div><input type='radio' name='role' value='A' $cekAdmin disabled><label>Admin</label></div>
              <div><input type='radio' name='role' value='B' $cekUser disabled><label>User</label></div>
            </group>
            <input type='submit' class='btn blue' name='action' value='HAPUS'>
          </form>
          <a href='user.php'><button class='btn red'>BATAL</button></a>
        </div>
      </div>
    </body>
  </html>";
}

function create_user() {
  global $pdo;
  global $table;
  global $_POST;
  $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
  $pdo->add($table, [
    "username" => $_POST["username"],
    "password" => $password,
    "role" => $_POST["role"],
  ]);
}

function update_user() {
  global $pdo;
  global $table;
  global $_POST;
  $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
  $pdo->update($table, [
    "id" => $_POST["id"],
    "username" => $_POST["username"],
    "password" => $password,
    "role" => $_POST["role"],
  ]);
}

function delete_user() {
  global $pdo;
  global $table;
  global $_POST;
  $pdo->delete($table, $_POST["id"]);
}

function logout() {
  session_start();
  session_destroy();
  header("location:../index.php");
}
?>