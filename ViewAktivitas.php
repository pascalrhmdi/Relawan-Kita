<?php
$title = "Cari Aktivitas";

require_once './db/connect.php';
require_once './includes/header.php';
require_once './functions/convert-date.php';

if (isset($_GET['id_acara'])) {
    $id_acara = $_GET['id_acara'];
    $results = $crud->getAcaraById($id_acara);
    $r = $results->fetch(PDO::FETCH_ASSOC);

    // pentotalan jumlah yang daftar
    $total_daftar = $r['total_pendaftar'];
} else {
    header("Location: CariAktivitas.php");
}

if (isset($_POST['submit'])) {
    // kalo udah pencet submit menjadi calon relawan
    if (isset($_SESSION['id_pengguna'])) {
        $id_pengguna = $_SESSION['id_pengguna'];
        $tanggal_batas_registrasi = $r['tanggal_batas_registrasi'];
        // klo udah login masukin ke tabel status
        // pakai try catch
        // Kalau berhasil berarti belum ada di tabel, masukin
        // kalau gagal, berarti dia udah menjadi calon relawan. kasih error message
        try {
            if($tanggal_batas_registrasi < date('Y-m-d')) throw new Exception('Gagal mendaftar! Melebihi batas tanggal pendaftaran');
            $status = $crud->insertStatus($id_pengguna, $id_acara);
            $message = "Anda berhasil menjadi calon Relawan di acara ini";
            include_once './includes/successmessage.php';
        } catch (PDOException $e) {
            $message = "Anda Sudah menjadi calon Relawan di acara ini";
            include_once './includes/errormessage.php';
        } catch (Exception $e) {
            $message = $e->getMessage();
            include_once './includes/errormessage.php';
        }
    } else {
        // Kalau belum login arahkan ke login
        $message = "Silahkan Login terlebih dahulu untuk mengajukan status menjadi calon relawan, <a href='login.php'>Klik disini untuk login</a>";
        include_once './includes/errormessage.php';
        // header("Location: login.php");
    }
}

?>
<div class="row d-flex flex-row">
    <div class="col-md-8">
        <img src="./assets/images/<?= $r['cover'] == '' ? 'default.jpg' : 'cover/' . $r['cover']; ?>" alt="Foto Acara" class="img-fluid" style="width: 100%;max-height: 500px; object-fit: cover;">
        <div class="d-flex flex-row align-items-center justify-content-between my-4">
            <div class="col-6 d-flex flex-row align-items-center">
                <img src="assets/images/default.jpg" style="width: 60px; height: 60px; margin-right: 10px" class="rounded-circle" alt="Logo Organisasi">
                <div>
                    <small class="text-muted m-0 d-block">Bersama</small>
                    <p class="fw-bold m-0"><?= $r['nama']; ?></p>
                    <small class="text-muted m-0 d-block">Berdiri Sejak <?= $r['tahun_berdiri']; ?></small>
                </div>
            </div>
            <small>Total ada <b><?= $total_daftar; ?> Relawan</b> yang bergabung</small>
        </div>
        <div class="py-2" style="background-color: #E0E0E0;">
            <div class="container">
                <p class="fw-bold">Deskripsi Acara</p>
                <p style="white-space: pre-wrap;"><?= $r['deskripsi_acara']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-capitalize"><?= $r['judul_acara']; ?></h5>
                <span class="text-uppercase p-1" style="border: 2px solid #DF202E; color:#DF202E; font-size: 10px; border-radius: 3px"><?= $r['nama_jenis_acara']; ?></span>
                <div class="mt-4">
                    <div class="d-flex flex-row align-items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16">
                            <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                        </svg>
                        <p class="ms-2 mb-0"><?= tgl_indo($r['tanggal_acara']); ?></p>
                    </div>
                    <div class="d-flex flex-row align-items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                        </svg>
                        <p class="ms-2 mb-0"><?= $r['lokasi']; ?></p>
                    </div>
                    <div class="d-flex flex-row align-items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill text-danger" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                        <p class="ms-2 mb-0 text-danger">Batas Registrasi <?= tgl_indo($r['tanggal_batas_registrasi']); ?></p>
                    </div>
                    <div class=" mt-4">
                        <?php if (date("Y-m-d") > $r['tanggal_batas_registrasi']) : ?>
                            <div class="d-grid">
                                <button class="btn text-white p-1 btn-block bg-color-red fw-bold not-allowed" style="box-shadow: 1px 3px 5px -1px rgba(0, 0, 0, 0.8);" disabled>Daftar</button>
                            </div>
                        <?php else : ?>
                            <form method="POST" action="" class="d-grid">
                                <button type="submit" name="submit" class="btn text-white p-1 btn-block bg-color-red fw-bold" style="box-shadow: 1px 3px 5px -1px rgba(0, 0, 0, 0.8);">Daftar</button>
                            </form>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './includes/footer.php'; ?>