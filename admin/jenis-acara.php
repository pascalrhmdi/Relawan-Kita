<?php
require_once '../includes/session.php';
require_once '../db/connect.php';

// check akun
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != 'admin') {
        header("Location:../CariAktivitas.php");
    }
} else {
    header("Location: ../login.php");
};

// untuk ambil jumlah row apakah lebih dari 0
$query = $pdo->query("SELECT COUNT(id_jenis_acara) AS id FROM jenis_acara");
$row = $query->fetch();
// total row
$total = $row['id'];

$menampilkanDataPerHalaman = 1000;
$jumlahHalaman = ceil($total / $menampilkanDataPerHalaman);
$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
$awalData = ($menampilkanDataPerHalaman * $halamanAktif) - $menampilkanDataPerHalaman;

// semua data diambil
$results = $crud->getJenisAcaraLimit($awalData, $menampilkanDataPerHalaman);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="favicon" sizes="16x16" href="../assets/favicon/favicon-16x16.ico" />
    <link rel="icon" type="favicon" sizes="48x48" href="../assets/favicon/favicon-48-48.ico" />

    <title>Kelola Jenis Acara | Relawan Kita</title>

    <!-- Custom fonts for this template -->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once("../includes/admin/sidebar.php"); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once("../includes/admin/topbar.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Kelola Jenis Acara</h1>

                    <?php
                    if (isset($_GET['addnewjenisacara'])) {
                        switch ($_GET['addnewjenisacara']) {
                            case 'failed':
                                $message = 'Gagal untuk menambahkan Jenis Acara ';
                                include_once '../includes/errormessage.php';
                                break;
                            case 'success':
                                $message = 'Berhasil Menambahkan Jenis Acara';
                                include_once '../includes/successmessage.php';
                                break;
                        }
                    }

                    if (isset($_GET["deletejenisacara"])) {
                        switch ($_GET['deletejenisacara']) {
                            case 'failed':
                                $message = 'Gagal menghapus data, terdapat kesalahan.';
                                include_once '../includes/errormessage.php';
                                break;
                            case 'success':
                                $message = 'Berhasil menghapus data Jenis Acara';
                                include_once '../includes/successmessage.php';
                                break;
                        }
                    }

                    if (isset($_GET['EditJenisAcara'])) {
                        if ($_GET['EditJenisAcara'] == 'success') {
                            $message = 'Berhasil merubah Nama Jenis Acara';
                            include_once '../includes/successmessage.php';
                        }
                    }

                    ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary py-2">List Jenis Acara</h6>
                        </div>
                        <div class="card-body">
                            <h6>Tambah Jenis Acara</h6>
                            <form class="row" action="../functions/insert-jenis-acara.php" method="POST">
                                <div class="col-lg-4 my-1">
                                    <input type="text" class="form-control mr-1" id="nama_jenis_acara" placeholder="Nama Jenis Acara" name="nama_jenis_acara" maxlength='50' required>
                                </div>
                                <div class="col-lg-4 my-1">
                                    <input type="text" class="form-control mr-1" id="icon_jenis_acara" placeholder="Icon Jenis Acara" name="icon_jenis_acara" maxlength='50' required>
                                    <small class="font-italic">Lihat Icon di <a href="https://icons.expo.fyi/" target="_blank">sini</a>. Tipe icon : MaterialIcon</small>
                                </div>
                                <div class="col-lg-4 my-1">
                                    <button type="submit" name="submit" class="btn btn-primary w-100">Add</button>
                                </div>
                            </form>
                            <hr class="mt-1">
                            <h6>Total Jenis Acara Relawan Kita : <?= $total; ?></h6>

                            <!-- Table Jenis Acara -->
                            <?php if ($total > 0) : ?>
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col" class="text-center">No.</th>
                                                <th scope="col" class="text-center">Jenis Acara Organisasi</th>
                                                <th scope="col" class="text-center">Icon</th>
                                                <th scope="col" class="text-center" style="width: 250px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = ($menampilkanDataPerHalaman * $halamanAktif) - ($menampilkanDataPerHalaman - 1);
                                            while ($r = $results->fetch(PDO::FETCH_ASSOC)) :
                                            ?>
                                                <tr>
                                                    <th scope="row" class="text-center"><?= $i; ?></th>
                                                    <td><?= is_null($r['nama_jenis_acara']) ? '-' : $r["nama_jenis_acara"]; ?></td>
                                                    <td><?= is_null($r['icon']) ? '-' : $r["icon"]; ?></td>
                                                    <td>
                                                        <!-- Edit -->
                                                        <a href="./edit-jenis-acara.php?id=<?= $r['id_jenis_acara'] ?>" class="btn btn-sm btn-warning btn-sm">Edit</a>
                                                        <!-- Delete -->
                                                        <a onclick="return confirm('Are you sure you want to delete this record?');" href="../functions/delete-jenis-acara.php?id=<?= $r['id_jenis_acara'] ?>" class="btn btn-sm btn-danger btn-sm">
                                                            Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php $i++;
                                            endwhile ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <h3 style="text-align: center;">Belum ada data Jenis Acara!</h3>
                            <?php endif ?>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include("../includes/admin/footer.php"); ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>
</body>

</html>