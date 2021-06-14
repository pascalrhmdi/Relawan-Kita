<?php
include_once '../includes/session.php';
require_once '../db/connect.php';

// check akun
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'volunteer') header("Location:CariAktivitas.php");
    elseif ($_SESSION['role'] == 'organisasi') $id_organisasi = $_SESSION['id_organisasi'];
} else {
    header("Location: ../login.php");
};

// untuk ambil jumlah row apakah lebih dari 0
$_SESSION['role'] == 'admin'
    ? $query = $pdo->query('SELECT COUNT(id_acara) as id FROM acara')
    : $query = $pdo->query("SELECT COUNT(id_acara) as id FROM acara WHERE id_organisasi = $id_organisasi");
$row = $query->fetch();
// total row
$total = $row['id'];

$menampilkanDataPerHalaman = $total;
$awalData = 0;

// semua data diambil
if ($_SESSION['role'] == 'admin') {
    // kalau admin
    $results = $crud->getAcaraLimit($awalData, $menampilkanDataPerHalaman);
} else {
    // kalau organisasi
    $results = $crud->getAcaraLimitByOrganisasi($awalData, $menampilkanDataPerHalaman, $id_organisasi);
}

if (isset($_GET["deleteorganisasi"])) {
    switch ($_GET['deleteorganisasi']) {
        case 'failed':
            $message = 'Gagal menghapus data, terdapat kesalahan.';
            include_once '../includes/errormessage.php';
            break;
        case 'success':
            $message = 'Berhasil menghapus Organisasi';
            include_once '../includes/successmessage.php';
            break;
    }
}

// TAMBAH ACARA

// ambil data jenis acara
$fetch_jenis_acara = $pdo->query("SELECT * FROM jenis_acara");

//If data was submitted via a form POST request, then...
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_acara = $_POST['judul_acara'];
    $deskripsi_acara = $_POST['deskripsi_acara'];
    $jumlah_kebutuhan = $_POST['jumlah_kebutuhan'];
    $tanggal_batas_registrasi = $_POST['tanggal_batas_registrasi'];
    $tanggal_acara = $_POST['tanggal_acara'];
    $lokasi = $_POST['lokasi'];
    $id_jenis_acara = $_POST['id_jenis_acara'];

    $queryResult = $crud->insertAcara($judul_acara, $deskripsi_acara, $jumlah_kebutuhan, $tanggal_batas_registrasi, $tanggal_acara, $lokasi, $id_jenis_acara, $id_organisasi);
    if (!$queryResult) {
        header("Location:listacara.php?tambahacara=failed");
    } else {
        header("Location:listacara.php?tambahacara=successfull");
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

    <link rel="icon" type="favicon" sizes="16x16" href="../assets/favicon/favicon-16x16.ico" />
    <link rel="icon" type="favicon" sizes="48x48" href="../assets/favicon/favicon-48-48.ico" />

    <title>List Acara | Relawan Kita</title>

    <!-- Custom fonts for this template -->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("../includes/admin/sidebar.php"); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("../includes/admin/topbar.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                    if (isset($_GET['deleteacara'])) {
                        $message = "Delete Acara Berhasil";
                        include_once '../includes/successmessage.php';
                    } elseif (isset($_GET['tambahacara'])) {
                        if ($_GET['tambahacara'] == 'failed') {
                            $message = "Gagal Menambah Acara";
                            include_once '../includes/errormessage.php';
                        } else {
                            $message = "Berhasil Menambah Acara";
                            include_once '../includes/successmessage.php';
                        }
                    } ?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Kelola Acara</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">List Acara</h6>
                            <?php if ($_SESSION['role'] == 'organisasi') : ?>
                                <button class="btn btn-sm btn-primary" data-target="#tambahAcaraModal" data-toggle="modal">Tambah Acara</button>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table " id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <?php if ($_SESSION['role'] == 'admin') : ?>
                                                <th>Organisasi</th>
                                            <?php endif; ?>
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
                                        <?php $i = 1; ?>
                                        <?php while ($r = $results->fetch()) : ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?= $i; ?></th>
                                                <!-- Data -->
                                                <?php if ($_SESSION['role'] == 'admin') : ?>
                                                    <td style="max-width:150px;"><?= $r['nama']; ?></td>
                                                <?php endif; ?>
                                                <td style="max-width:150px;"><?= $r["judul_acara"]; ?></td>
                                                <td style="max-width:150px;"><?= $r["nama_jenis_acara"]; ?></td>
                                                <td><?= $r["jumlah_kebutuhan"]; ?></td>
                                                <td><?= $r["tanggal_acara"]; ?></td>
                                                <td style="max-width:150px;"><?= $r["lokasi"]; ?></td>
                                                <td><?= $r["tanggal_batas_registrasi"]; ?></td>

                                                <td>
                                                    <!-- admin hanya mendelete acara -->
                                                    <?php if ($_SESSION['role'] == 'admin') : ?>
                                                        <a class="btn btn-sm btn-danger" onclick=" return confirm('Are you sure you want to delete this Acara\'s record?');" href="../functions/delete-acara.php?id=<?= $r['id_acara'] ?>">Delete</a>
                                                    <?php else : ?>
                                                        <a class="btn btn-sm btn-info" href="detailacara.php?id=<?= $r['id_acara'] ?>">Detail</a>
                                                        <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this Acara\'s record?');" href="../functions/delete-acara.php?id=<?= $r['id_acara'] ?>">Delete</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
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

    <?php if ($_SESSION['role'] == 'organisasi') : ?>
        <!-- tambah acara modal -->
        <div class="modal fade" id="tambahAcaraModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Acara</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" placeholder="Masukan Nama Acara" name="judul_acara" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Acara</label>
                                <textarea type="text" class="form-control" placeholder="Masukan Deskripsi Acara" name="deskripsi_acara" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kategori Acara</label>
                                <select class="form-control" name="id_jenis_acara" required>
                                    <option value="" hidden>-- Pilih Kategori --</option>
                                    <?php while ($jenis_acara = $fetch_jenis_acara->fetch()) : ?>
                                        <option class="text-capitalize" value="<?= $jenis_acara['id_jenis_acara'] ?>"><?= $jenis_acara['nama_jenis_acara']; ?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kuota Relawan</label>
                                <input type="number" class="form-control" placeholder="Masukan Batas Kuota Relawan" name="jumlah_kebutuhan" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Pelaksanaan Acara</label>
                                <input type="date" class="form-control" name="tanggal_acara" required>
                            </div>
                            <div class="form-group">
                                <label>Lokasi Acara</label>
                                <input type="text" class="form-control" placeholder="Masukan Lokasi Acara Diselenggarakan" name="lokasi" required>
                            </div>
                            <div class="form-group">
                                <label>Deadline Pendaftaran Acara</label>
                                <input type="date" class="form-control" name="tanggal_batas_registrasi" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary btn-sm" type="submit">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>


</body>

</html>