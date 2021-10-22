<?php
include_once '../includes/session.php';
require_once '../db/connect.php';
require_once '../functions/convert-date.php';

// check akun
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != 'admin') {
        header("Location:../CariAktivitas.php");
    }
} else {
    header("Location: ../login.php");
};

// untuk ambil jumlah row apakah lebih dari 0
$query = $pdo->query('SELECT COUNT(id_acara) as id FROM acara');
$row = $query->fetch();
// total row
$total = $row['id'];

$menampilkanDataPerHalaman = 5;
$jumlahHalaman = ceil($total / $menampilkanDataPerHalaman);
$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
$awalData = ($menampilkanDataPerHalaman * $halamanAktif) - $menampilkanDataPerHalaman;

// semua data diambil
$results = $crud->getAcaraLimit($awalData, $menampilkanDataPerHalaman);

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

    <title>List Acara | Relawan Kita</title>

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
                    <?php
                    if (isset($_GET['deleteacara'])) {
                        if ($_GET['deleteacara'] == 'failed') {
                            $message = "Gagal Menghapus Acara!";
                            include_once '../includes/errormessage.php';
                        } else {
                            $message = "Acara Berhasil Dihapus";
                            include_once '../includes/successmessage.php';
                        }
                    } ?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Kelola Acara</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary py-2">List Acara</h6>
                        </div>
                        <div class="card-body">
                            <h6>Total Acara : <?= $total; ?></h6>

                            <div class="table-responsive">
                                <table class="table " id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Organisasi</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Kuota</th>
                                            <th>Tgl Acara</th>
                                            <th>Lokasi</th>
                                            <th>Deadline</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = ($menampilkanDataPerHalaman * $halamanAktif) - ($menampilkanDataPerHalaman - 1); ?>
                                        <?php while ($r = $results->fetch()) : ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?= $i; ?></th>
                                                <!-- Data -->
                                                <td style="max-width:150px;"><?= $r['nama']; ?></td>
                                                <td style="max-width:150px;"><?= $r["judul_acara"]; ?></td>
                                                <td style="max-width:150px;"><?= $r["nama_jenis_acara"]; ?></td>
                                                <td><?= $r["jumlah_kebutuhan"]; ?></td>
                                                <td><?= tgl_indo($r["tanggal_acara"]); ?></td>
                                                <td style="max-width:150px;"><?= $r["lokasi"]; ?></td>
                                                <td><?= tgl_indo($r["tanggal_batas_registrasi"]); ?></td>

                                                <td>
                                                    <a class="btn btn-sm btn-danger" onclick=" return confirm('Are you sure you want to delete this Acara\'s record?');" href="../functions/delete-acara.php?id=<?= $r['id_acara'] ?>">Delete</a>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php if ($halamanAktif == 1) echo 'disabled'; ?>">
                                        <a class="page-link" href="halaman=<?= $halamanAktif - 1 ?>" tabindex="-1" aria-disabled=<?= $halamanAktif == 1 ? "true" : "false"; ?>>Previous</a>
                                    </li>
                                    <?php
                                    $i = $halamanAktif < 4 ? 1 : $halamanAktif - 3;
                                    for ($i; $i <= $jumlahHalaman; $i++) :
                                    ?>
                                        <li class="page-item <?php if ($halamanAktif == $i) echo 'active'; ?>" <?php if ($halamanAktif == $i) echo 'aria-current="page"'; ?>>
                                            <a class="page-link" href="?halaman=<?= $i ?>"><?= $i; ?></a>
                                        </li>
                                    <?php endfor ?>
                                    <li class="page-item <?php if ($halamanAktif == $jumlahHalaman) echo 'disabled'; ?>">
                                        <a class="page-link" href="halaman=<?= $halamanAktif + 1 ?>">Next</a>
                                    </li>
                                </ul>
                            </nav>
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