<?php
$title = 'Edit Profil';

require_once './includes/header.php';
require_once './db/connect.php';

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != 'volunteer') {
        header("Location: ./CariAktivitas.php");
    };
} else {
    header("Location: ./login.php");
}

$id_pengguna = $_SESSION['id_pengguna'];

// Fetch Data
$result = $user->getUserRelawanbyId($id_pengguna);
?>

<!-- Main Code -->
<div class="row justify-content-center ">
    <div class="col-5">
        <h1 class="text-center mb-4"><?= $title ?> </h1>
        <?php
        if (isset($_GET['EditProfil'])) {
            if ($_GET['EditProfil'] == 'failed') {
                $message = 'Gagal untuk merubah profil akun, Cek kembali form anda';
                include_once './includes/errormessage.php';
            } else {
                $message = 'Berhasil merubah profil akun';
                include_once './includes/successmessage.php';
            }
        }
        ?>
        <form action="./functions/edit-user.php" method="post">
            <div class="form-group mb-3  d-flex flex-column">
                <label for="nama" class="mb-1">Nama Lengkap *</label>
                <input required type="text" class="form-control" id="nama" name="nama" value="<?= $result['nama'] ?>">
            </div>
            <div class="form-group  mb-3 d-flex flex-column">
                <label for="nomor_telepon" class="mb-1">Nomor Telepon</label>
                <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?= $result['nomor_telepon'] ?>">
            </div>
            <div class="form-group  mb-3 d-flex flex-column">
                <label for="tanggal_lahir" class="mb-1">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $result['tanggal_lahir'] ?>" max="<?= date("Y-m-d"); ?>">
            </div>
            <div class="formgroup  mb-3">
                <label class="mb-1">Jenis Kelamin *</label>
                <div class="container">
                    <div class="form-check">
                        <input required class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="Laki-laki" <?php if ($result['jenis_kelamin'] == 'Laki-laki') echo 'checked'; ?>>
                        <label class="form-check-label" for="jenis_kelamin1">
                            Laki-laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="Perempuan" <?php if ($result['jenis_kelamin'] == 'Perempuan') echo 'checked'; ?>>
                        <label class="form-check-label" for="jenis_kelamin2">
                            Perempuan
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group mb-3  d-flex flex-column">
                <label for="alamat" class="mb-1">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $result['alamat']; ?></textarea>
            </div>

            <!-- Button Login -->
            <div class="d-grid mb-3">
                <button type="submit" name="submit" class="btn btn-primary btn-block fw-bold">Update User</button>
            </div>

            <!-- Garis -->
            <hr class="my-4">

            <!-- Kalimat Kembali -->
            <h5 class="text-center">Kembali ke <a style="font-size: 18px;" href="CariAktivitas.php">Cari Aktivitas</a></h5>
        </form>
    </div>
</div>

<?php include_once './includes/footer.php' ?>