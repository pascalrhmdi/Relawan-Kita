<?php
include_once '../includes/session.php';
require_once '../db/connect.php';

// check akun
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'volunteer') header("Location:CariAktivitas.php");
    elseif ($_SESSION['role'] == 'organisasi') $id_organisasi = $_SESSION['id_organisasi'];
    else header("Location:listacara.php");
} else {
    header("Location: ../login.php");
};

if (isset($_GET['id'])) {
    $id_acara = $_GET['id'];
}

$query = $pdo->query("SELECT COUNT(id_pengguna) as id FROM status WHERE id_acara = $id_acara");
$row = $query->fetch();
// total row
$total = $row['id'];

$menampilkanDataPerHalaman = $total;
$awalData = 0;

// semua data diambil
$results = $pdo->query("SELECT * FROM status s
                        LEFT JOIN pengguna p
                            USING(id_pengguna)
                        WHERE id_acara = $id_acara
                        LIMIT $awalData, $menampilkanDataPerHalaman");

$detailAcara = $pdo->query("SELECT acara.*,jenis_acara.nama_jenis_acara as kategori FROM acara JOIN jenis_acara USING(id_jenis_acara) WHERE acara.id_acara = $id_acara");
$detailAcara = $detailAcara->fetch();


// untuk update rincian acara
$fetch_jenis_acara = $pdo->query("SELECT * FROM jenis_acara");
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

    <title>Detail Acara | Relawan Kita</title>

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
                    <?php if (isset($_GET['UpdateStatus'])) {
                        $status = $_GET['UpdateStatus'];

                        if ($status == 'success') {
                            $message = "Update Status Berhasil";
                            include_once '../includes/successmessage.php';
                        } else {
                            $message = "Update Status gagal";
                            include_once '../includes/errormessage.php';
                        }
                    } ?>

                    <?php if (isset($_GET['successeditacara'])) {
                        if ($_GET['successeditacara'] == 'failed') {
                            $message = 'Gagal untuk merubah detail acara, Cek kembali form anda';
                            include_once '../includes/errormessage.php';
                        } else {
                            $message = 'Berhasil merubah detail acara';
                            include_once '../includes/successmessage.php';
                        }
                    } ?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-0 text-gray-800">Detail Acara</h1>
                    <a class="mb-2 mt-3 d-block" href="./listacara.php"><i class="fa fa-chevron-left mr-1"></i> Kembali</a>

                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="m-0 py-2 font-weight-bold text-primary">Rincian Acara </h6>
                        </div>
                        <div class="card-body py-1">
                            <form class="row" action="../functions/edit-acara.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_acara" value="<?= $detailAcara['id_acara']; ?>">
                                <div class="col-lg-7 border-bottom pb-2">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Nama Acara : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" value="<?= $detailAcara['judul_acara']; ?>" name="judul_acara" required>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Kategori : </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="id_jenis_acara" required>
                                                        <option value="" hidden>-- Pilih Kategori --</option>
                                                        <?php while ($jenis_acara = $fetch_jenis_acara->fetch()) : ?>
                                                            <option class="text-capitalize" <?= $detailAcara['id_jenis_acara'] == $jenis_acara['id_jenis_acara'] ? 'selected' : ''; ?> value="<?= $jenis_acara['id_jenis_acara'] ?>"><?= $jenis_acara['nama_jenis_acara']; ?></option>
                                                        <?php endwhile ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Kuota Relawan : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" value="<?= $detailAcara['jumlah_kebutuhan']; ?>" name="jumlah_kebutuhan" required>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Batas Registrasi : </label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" value="<?= $detailAcara['tanggal_batas_registrasi']; ?>" name="tanggal_batas_registrasi" required>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Tanggal Acara : </label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" value="<?= $detailAcara['tanggal_acara']; ?>" name="tanggal_acara" required>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Lokasi : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" value="<?= $detailAcara['lokasi']; ?>" name="lokasi" required>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-5 border-bottom">
                                    <h6 class="mt-3">Cover Acara</h6>
                                    <img class="img-fluid" src="../assets/images/<?= $detailAcara['cover'] == '' ? 'default.jpg' : 'cover/' . $detailAcara['cover']; ?>" style="max-height: 300px;object-fit:cover;width:100%;" alt="" id="preview-image">
                                    <input type="hidden" value="<?= $detailAcara['cover'] == '' ? '' :  $detailAcara['cover']; ?>" name="cover_lama">
                                    <div class="form-group mt-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="coverAcara" name="cover-acara" onchange="previewImg()">
                                            <label class="custom-file-label" for="coverAcara" id="labelInputCoverAcara"><?= $detailAcara['cover'] == '' ? 'Choose File' : $detailAcara['cover']; ?></label>
                                        </div>
                                        <small class="text-muted font-weight-italic">Ukuran gambar maksimal 1MB. Ekstensi file yang diperbolehkan : jpg, jpeg, png</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <label class="col-12 col-form-label">Deskripsi Acara : </label>
                                                <div class="col-12">
                                                    <textarea name="deskripsi_acara" class="form-control" style="min-height: 200px;" required><?= $detailAcara['deskripsi_acara']; ?></textarea>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-5 ml-auto py-3">
                                    <button class="btn btn-sm btn-primary w-100" type="submit" name="submit"><i class="fa fa-save"></i> Ubah</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="m-0 py-1 font-weight-bold text-primary">List Pendaftar</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table " id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Umur</th>
                                            <th>Gender</th>
                                            <th>Alamat</th>
                                            <th>No.Telp</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1 ?>
                                        <?php while ($r = $results->fetch()) : ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?= $i; ?></th>
                                                <td><?= $r["nama"]; ?></td>
                                                <td><?= floor(date_diff(date_create($r["tanggal_lahir"]), date_create('now'))->format("%a") / 365); ?> Tahun</td>
                                                <td><?= $r["jenis_kelamin"]; ?></td>
                                                <td style="max-width: 250px;"><?= $r["alamat"]; ?></td>
                                                <td><?= $r["nomor_telepon"]; ?></td>
                                                <!-- kalau status menunggu secondary,  lolos success, gagal danger -->
                                                <td>
                                                    <span class="font-weight-bold text-<?= $r['status'] == 'menunggu' ? 'secondary' : ($r['status'] == 'lolos' ? 'success' : 'danger'); ?>"><?= ucfirst($r['status']); ?></span>
                                                </td>
                                                <form method="POST" action="../functions/change-status.php">
                                                    <input type="hidden" name="id_pengguna" value="<?= $r['id_pengguna'] ?>">
                                                    <input type="hidden" name="id_acara" value="<?= $id_acara ?>">
                                                    <td>
                                                        <button type="submit" name="change_status" value="lolos" class="btn btn-success btn-sm text-capitalize">Terima</button>
                                                        <button type="submit" name="change_status" value="gagal" class="btn btn-danger btn-sm text-capitalize">Tolak</button>
                                                    </td>
                                                </form>
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
    <script>
        let previewImg = () => {
            const fileInput = document.querySelector("#coverAcara");
            const customLabel = document.querySelector("#labelInputCoverAcara");
            const imgPreview = document.querySelector("#preview-image");

            customLabel.innerText = fileInput.files[0].name;

            const fileCover = new FileReader();
            fileCover.readAsDataURL(fileInput.files[0]);

            fileCover.onload = (e) => {
                imgPreview.src = e.target.result;
            }

        };
    </script>

</body>

</html>