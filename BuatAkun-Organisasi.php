<?php
$title = "Daftar Akun Organisasi";

require_once './db/connect.php';
require_once './includes/header.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $nama = $_POST['nama'];
    $deskripsi_organisasi = $_POST['deskripsi_organisasi'];
    $tahun_berdiri = $_POST['tahun_berdiri'];

    $results = $crud->insertOrganisasi($email, $password, $role, $nama, $deskripsi_organisasi, $tahun_berdiri);
    if (!$results) {
        echo '<div class="alert alert-danger">Username Sudah digunakan, Silahkan gunakan yang lain.</div>';
    } else {
        $result = $user->getUser($email, md5($password . $email));
        $_SESSION['id_organisasi'] = $result['id_organisasi'];
        $_SESSION['nama'] = $result['nama'];
        $_SESSION['role'] = $result['role'];
        header("Location: CariAktivitas.php?login=success");
        include_once 'includes/successmessage.php';
    }
}
?>
<div class="row justify-content-center ">
    <div class="col-11 col-md-9 col-lg-6 p-5 pt-3 justify-content-center border border-dark">
        <h1 class="text-center mb-5"><?= $title; ?></h1>
        <form method="post" action="#" autocomplete="on">
            <!-- Bagian Akun Organisasi -->
            <h4 class="mb-3">Akun Organisasi</h4>
            <div class="ms-5">
                <div class="form-group mb-3 d-flex flex-column">
                    <label for="email" class="mb-1">Email address</label>
                    <input required type="email" class="form-control" id="email" name="email"
                        aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted text-end">Digunakan untuk login, pastikan email
                        anda valid.</small>
                </div>
                <!-- <label for="password" class="mb-1">Password *</label>
                <div class="input-group mb-3">
                    <label class="input-group-text" id="basic-addon2" for="password">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                    </label>
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" data-bs-toggle="tooltip" data-bs-placement="right" title="Masukkan Password" aria-describedby="basic-addon2" required>
                </div> -->
                <div class="form-group mb-3 d-flex flex-column">
                    <label for="password" class="mb-1">Password</label>
                    <input required type="password" class="form-control" id="password" name="password">
                    <small id="emailHelp" class="form-text text-muted text-end">Digunakan untuk login, pastikan password
                        anda mudah diingat.</small>
                </div>
                <input type="hidden" value="organisasi" name="role">
            </div>
            <h4 class="mb-3">Data Organisasi</h4>
            <div class="ms-5">
                <div class="form-group mb-3  d-flex flex-column">
                    <label for="nama" class="mb-1">Nama Organisasi</label>
                    <input required type="text" class="form-control" id="nama" name="nama">
                </div>
                <div class="form-group  mb-3 d-flex flex-column">
                    <label for="tahun_berdiri" class="mb-1">Tahun Berdiri</label>
                    <input type="number" class="form-control" min="1900" max="<?= date('Y') ?>" step="1"
                        value="<?= date('Y') ?>" name="tahun_berdiri" id="tahun_berdiri" required />
                </div>
                <div class="form-group mb-3  d-flex flex-column">
                    <label for="deskripsi_organisasi" class="mb-1">Deskripsi Organisasi</label>
                    <textarea class="form-control" id="deskripsi_organisasi" name="deskripsi_organisasi" rows="3"
                        required></textarea>
                </div>
            </div>
            <div class="container my-4">
                <p class="text-center mb-0">Pastikan bahwa informasi yang anda masukkan sudah benar.</p>
                <p class="text-center">Dengan mendaftar, Anda telah menyetujui <a href="#">syarat</a> dan <a
                        href="#">ketentuan</a> dari Relawan Kita</p>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" name="submit" class="btn btn-primary btn-block fw-bold">Daftar</button>
            </div>
        </form>
    </div>
</div>
<?php require_once './includes/footer.php'; ?>