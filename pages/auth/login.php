<?php
session_start();
include_once("../../config/conn.php");

if (isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PoliKlinik | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../.." class="h1"><b>Poli</b>Klinik</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in</p>
        <form action="#" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="nama">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="alamat">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
    <?php if(isset($_SESSION['error'])) : ?>
      <p style="color: red; font-style: italic; margin-bottom: 1rem;"><?php echo $_SESSION['error'];
                                                                            unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    <div class="row">
      <div class="col-8">
        <div class="icheck-primary">
          <input type="checkbox" id="remember">
          <label for="remember">
            Remember Me
          </label>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-4">
        <button type="submit" class="btn btn-primary btn-block" name="submit">Sign In</button>
      </div>
      <!-- /.col -->
    </div>
    </form>
    <p class="mb-0">
      <a href="register.php">Register a new account</a>
    </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.js"></script>
</body>
</html>

<?php
if(isset($_POST['submit'])){
  $username = stripcslashes($_POST['nama']);
  $password = $_POST['alamat'];
  if($username == 'admin'){
    if($password == 'admin'){
      $_SESSION['login'] = true;
      $_SESSION['id'] = null;
      $_SESSION['username'] = 'admin';
      $_SESSION['akses'] = 'admin';
      echo "<meta http-equiv='refresh' content='0; url=../admin'>";
      die();
  }
} else {
  $cek_username = $pdo->prepare("SELECT * FROM dokter WHERE nama = '$username';");
  try{
    $cek_username->execute();
    if($cek_username->rowCount()==1){
      $baris = $cek_username->fetchAll(PDO::FETCH_ASSOC);
      if($password == $baris[0]['alamat']){
        $_SESSION['login'] = true;
        $_SESSION['id'] = $baris[0]['id'];
        $_SESSION['username'] = $baris[0]['nama'];
        $_SESSION['no_rm'] = $baris[0]['no_rm'];
        $_SESSION['akses'] = 'dokter';
        echo "<meta http-equiv='refresh' content='0; url=../dokter'>";
        die();
      }
    }
  } catch(PDOException $e){
    $_SESSION['error'] = $e->getMessage();
    echo "<meta http-equiv='refresh' content='0;'>";
    die();
  }
}
$_SESSION['error'] = 'Username dan Password Tidak Cocok';
echo "<meta http-equiv='refresh' content='0;'>";
die();
}
?>
