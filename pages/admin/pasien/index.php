<?php
session_start();
include_once("../../../config/conn.php");

if(isset($_SESSION['login'])){
  $_SESSION['login'] = true;
} else {
  echo "<meta http-equiv='refresh' content='0; url=../auth/login.php'>";
  die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if($akses != 'admin'){
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
  die();
}

if(isset($_POST['simpan'])){
  if(isset($_POST['id'])){
    $stmt = $pdo->prepare("UPDATE pasien SET nama = :nama, alamat = :alamat, no_ktp = :no_ktp, no_hp = :no_hp, no_rm = :no_rm WHERE id = :id");
    $stmt->bindParam(':nama', $_POST['nama'], PDO::PARAM_STR);
    $stmt->bindParam(':alamat', $_POST['alamat'], PDO::PARAM_STR);
    $stmt->bindParam(':no_ktp', $_POST['no_ktp'], PDO::PARAM_STR);
    $stmt->bindParam(':no_hp', $_POST['no_hp'], PDO::PARAM_STR);
    $stmt->bindParam(':no_rm', $_POST['no_rm'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
    $stmt->execute();

    header('Location:index.php');
  } else {
    $stmt = $pdo->prepare("INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES (:nama, :alamat, :no_ktp, :no_hp, :no_rm)");
    $stmt->bindParam(':nama', $_POST['nama'], PDO::PARAM_STR);
    $stmt->bindParam(':alamat', $_POST['alamat'], PDO::PARAM_STR);
    $stmt->bindParam(':no_ktp', $_POST['no_ktp'], PDO::PARAM_STR);
    $stmt->bindParam(':no_hp', $_POST['no_hp'], PDO::PARAM_STR);
    $stmt->bindParam(':no_rm', $_POST['no_rm'], PDO::PARAM_STR);
    $stmt->execute();
    header('Location:index.php');
  }
}
if(isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
  $stmt = $pdo->prepare("DELETE FROM pasien WHERE id = :id");
  $stmt->bindParam(':id', $_GET['id']);
  $stmt->execute();

  header('Location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../../plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../../../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/BK_Poliklinik/pages/auth/logout.php" class="nav-link">Logout</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
        </a>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">BK-Poliklinik</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/BK_Poliklinik/pages/admin/dokter" class="nav-link">
              <p>
                Dokter
                <span class="right badge badge-danger">Admin</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/BK_Poliklinik/pages/admin/pasien" class="nav-link">
              <p>
                Pasien
                <span class="right badge badge-danger">Admin</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/BK_Poliklinik/pages/admin/poli" class="nav-link">
              <p>
                Poli
                <span class="right badge badge-danger">Admin</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/BK_Poliklinik/pages/admin/obat" class="nav-link">
              <p>
                Obat
                <span class="right badge badge-danger">Admin</span>
              </p>
            </a>
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Obat</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">obat</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <form method="POST" action="#" class="form col" name="myform" onsubmit="return(validate());">
                    <?php
                      $nama = '';
                      $alamat = '';
                      $no_ktp = '';
                      $no_hp = '';
                      $no_rm = '';
                      if(isset($_GET['id'])){
                        try {
                          $stmt = $pdo->prepare("SELECT * FROM pasien WHERE id = :id");
                          $stmt->bindParam(':id', $_GET['id']);
                          $stmt->execute();

                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            $nama = $row['nama'];
                            $alamat = $row['alamat'];
                            $no_ktp = $row['no_ktp'];
                            $no_hp = $row['no_hp'];
                            $no_rm = $row['no_rm'];
                          }
                        } catch (PDOException $e){
                          echo "Error: " . $e->getMessage();
                        }
                    ?>
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <?php
                    }
                    ?>
                    <div class="row mt-3">
                      <label for="nama" class="form-label fw-bold">Nama</label>
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama ?>">
                    </div>
                    <div class="row mt-3">
                      <label for="alamat" class="form-label fw-bold">Alamat</label>
                      <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat ?>">
                    </div>
                    <div class="row mt-3">
                      <label for="no_ktp" class="form-label fw-bold">No KTP</label>
                      <input type="text" class="form-control" name="no_ktp" id="no_ktp" placeholder="No KTP" value="<?php echo $no_ktp ?>">
                    </div>
                    <div class="row mt-3">
                      <label for="no_hp" class="form-label fw-bold">No hp</label>
                      <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No HP" value="<?php echo $no_hp ?>">
                    </div>
                    <div class="row mt-3">
                      <label for="no_rm" class="form-label fw-bold">No rm</label>
                      <input type="text" class="form-control" name="no_rm" id="no_rm" placeholder="no rm" value="<?php echo $no_rm ?>">
                    </div>
                    <div class="row d-flex mt-3 mb-3">
                      <button type="submit" class="btn btn-primary rounded-pill" style="width: 3cm;" name="simpan">Simpan</button>
                    </div>
                </form>
            </div>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No ktp</th>
                        <th>No hp</th>
                        <th>No rm</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $pdo->query("SELECT * FROM pasien");
                    $no = 1;
                    while($data = $result->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <tr>
                      <td><?php echo $no++ ?></td>
                      <td><?php echo $data['nama'] ?></td>
                      <td><?php echo $data['alamat'] ?></td>
                      <td><?php echo $data['no_ktp'] ?></td>
                      <td><?php echo $data['no_hp'] ?></td>
                      <td><?php echo $data['no_rm'] ?></td>
                      <td>
                        <a href="index.php?page=obat.php&id=<?php echo $data['id'] ?>" class="btn btn-success rounded-pill px-3">Edit</a>
                        <a href="index.php?page=obat.php&id=<?php echo $data['id'] ?>&aksi=hapus" class="btn btn-danger rounded-pill px-3">Hapus</a>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
            ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../../plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../../../plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../../../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../../../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../../../plugins/moment/moment.min.js"></script>
<script src="../../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../../../plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../../dist/js/pages/dashboard.js"></script>
</body>
</html>
