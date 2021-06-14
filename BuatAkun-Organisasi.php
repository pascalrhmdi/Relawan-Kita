<?php
require_once './db/connect.php';
include_once 'includes/session.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = md5($password . $email);
    $role = $_POST['role'];
    $nama = $_POST['nama'];
    $deskripsi_organisasi = $_POST['deskripsi_organisasi'];
    $tahun_berdiri = $_POST['tahun_berdiri'];

    $results = $crud->insertOrganisasi($email, $hashedPassword, $role, $nama, $deskripsi_organisasi, $tahun_berdiri);
    if (!$results) {
        $errorRegister = true;
    } else {
        // ambil akun lalu masukin di session
        $result = $crud->getAccountOrganisasi($email, $hashedPassword);
        $_SESSION['id_organisasi'] = $result['id_organisasi'];
        $_SESSION['nama'] = $result['nama'];
        $_SESSION['role'] = $result['role'];
        header("Location: CariAktivitas.php?login=success");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register Organisasi - Relawan Kita</title>

    <link rel="icon" type="favicon" sizes="16x16" href="./assets/favicon/favicon-16x16.ico" />
    <link rel="icon" type="favicon" sizes="48x48" href="./assets/favicon/favicon-48-48.ico" />

    <!-- Custom fonts for this template-->
    <link href="./assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-info">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-12">
                        <div class="p-4 p-lg-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-5">Registrasi Akun Organisasi</h1>
                            </div>
                            <?php if (isset($errorRegister)) {
                                $message = "Email Sudah digunakan, Silahkan masukkan email yang lain.";
                                include_once 'includes/errormessage.php';
                            }; ?>
                            <form class="user" method="post" action="#">
                                <input type="hidden" value="organisasi" name="role">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="font-weight-bold">Akun Organisasi</h6>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <input type="email" class="form-control form-control-user" placeholder="Email" name="email" required>
                                            <small id="emailHelp" class="form-text text-muted ml-1">*Digunakan untuk login, pastikan email
                                                anda valid.</small>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" placeholder="Password" name="password" required>
                                            <small id="emailHelp" class="form-text text-muted ml-1">*Digunakan untuk login, pastikan password
                                                anda mudah diingat.</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="font-weight-bold">Data Organisasi</h6>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" placeholder="Nama Organisasi" required name="nama">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" placeholder="Deskripsi Organisasi" required name="deskripsi_organisasi">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control form-control-user" placeholder="Tanggal Berdiri" required name="tahun_berdiri">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-info btn-user btn-block">
                                    Daftar Akun
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="./login.php">Sudah memiliki akun? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="./assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./assets/js/sb-admin-2.min.js"></script>

</body>

</html>