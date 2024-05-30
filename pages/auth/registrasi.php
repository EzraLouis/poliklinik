<?php
session_start();
include_once("../../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //mendapatkan nilai dari form -- atribut name di input
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $no_ktp = $_POST['no_ktp'];
  $no_hp = $_POST['no_hp'];

  // Situasi 1
  //cek apakah pasien sudah terdaftar berdasarkan nomor KTP
  $query_check_pasien = "SELECT id, nama, no_rm FROM pasien WHERE no_ktp = '$no_ktp'";
  $result_check_pasien = mysqli_query($conn, $query_check_pasien);

  if(mysqli_num_rows($result_check_pasien) > 0) {
    $row = mysqli_fetch_assoc($result_check_pasien);

    if($row['nama'] != $nama){
      //ketika nama tidak sesuai dengan no_ktp
      echo "<script>alert(`Nama pasien tidak sesuai dengan nomor KTP yang terdaftar.`);</script>";
      echo "<meta http-equiv='refresh' content='0; url=registrasi.php'>";
      die();
    }
    $_SESSION['signup'] = true;
    $_SESSION['id'] = $row['id'];
    $_SESSION['username'] = $nama;
    $_SESSION['no_rm'] = $row['no_rm'];
    $_SESSION['akses'] = 'pasien';

    echo "<meta http-equiv='refresh' content='0; url=../pasien'>";
    die();
  }

  //Situasi 2
  //Query untuk mendapatkan nomor antrian terakhir --YYYYMM-XXX - 202405-004
  $queryGetRm = "SELECT MAX(SUBSTRING(no_rm, 8)) as last_queue_number FROM pasien";
  $resultRm = mysqli_query($conn, $queryGetRm);

  //periksa hasil query
  if(!$resultRm) {
    die("Query gagal:" . mysqli_error($conn));
  }

  //ambil nomor antrian terakhir dari hasil query
  $rowRM = mysqli_fetch_assoc($resultRm);
  $lastQueueNumber = $rowRM['last_queue_number'];

  //jika tabel kosong, atur nomor antrian menjadi 0
  $lastQueueNumber = $lastQueueNumber ? $lastQueueNumber : 0;

  // mendapatkan tahun saat ini (misal : 202405)
  $tahun_bulan = date("Ym");
  $newQueueNumber = $lastQueueNumber + 1;

  //menyusun nomor rekam medis dengan format YYYYMM-XXX
  $no_rm = $tahun_bulan . "-" . str_pad($newQueueNumber, 3, '0', STR_PAD_LEFT);

  //lakukan operasi insert
  $query = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm')";

  //Eksekusi query
  if(mysqli_query($conn, $query)) {
    //set session variables
    $_SESSION['signup'] = true; //menandakan langsung ke dashboard
    $_SESSION['id'] = mysqli_insert_id($conn); //mengambil id terakhir
    $_SESSION['username'] = $nama;
    $_SESSION['no_rm'] = $no_rm;
    $_SESSION['akses'] = 'pasien';

    //redirect ke halaman dashboard
    echo "<meta http-equiv='refresh' content='0; url=../pasien'>";
    die();
  } else {
    echo "Error: " . $query . "</br>" . mysqli_error($conn);
  }

  //tutup koneksi database
  mysqli_close($conn);
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
        <p class="login-box-msg">Register</p>
        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="nama" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Alamat" name="alamat" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="number" class="form-control" placeholder="No KTP" name="no_ktp" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="number" class="form-control" placeholder="No HP" name="no_hp" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
    <div class="row">
      <!-- /.col -->
      <div class="col-4">
        <button type="submit" class="btn btn-primary btn-block">Register</button>
      </div>
      <!-- /.col -->
    </div>
    </form>
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
