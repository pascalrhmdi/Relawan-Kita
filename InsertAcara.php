<?php
    $title = 'Tambah Acara';

    require_once 'includes/header.php';
    require_once 'db/connect.php';

    if(isset($_SESSION['role'])){
        if($_SESSION['role'] != 'organisasi') header("Location:CariAktivitas.php");
    } else header("Location: Login.php");

    // ambil data jenis acara
    $fetch_jenis_acara = $pdo->query("SELECT * FROM jenis_acara");

    // ambil id_organisasi user
    $id_organisasi = $_SESSION['id_organisasi'];

    //If data was submitted via a form POST request, then...
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $judul_acara = $_POST['judul_acara'];
        $deskripsi_acara = $_POST['deskripsi_acara'];
        $jumlah_kebutuhan = $_POST['jumlah_kebutuhan'];
        $tanggal_batas_registrasi = $_POST['tanggal_batas_registrasi'];
        $tanggal_acara = $_POST['tanggal_acara'];
        $lokasi = $_POST['lokasi'];
        $id_jenis_acara = $_POST['id_jenis_acara'];

        $result = $crud->insertAcara($judul_acara, $deskripsi_acara, $jumlah_kebutuhan, $tanggal_batas_registrasi, $tanggal_acara, $lokasi, $id_jenis_acara, $id_organisasi);
        if (!$result) {
            $message = 'Username or Password is incorrect! Please try again.';
            include_once './includes/errormessage.php';
        } else {
            header("Location: Admin-Acara.php?edit=successfull");
        }
    }
?>

<!-- Main Code -->

<div class="row justify-content-center ">
    <div class="col-4">
        <h1 class="text-center mb-4"><?php echo $title ?> </h1>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <!-- Judul Acara -->
            <input type="text" class="form-control mb-3" placeholder="Judul Acara" name="judul_acara"
                value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['judul_acara']; ?>" required
                autofocus>

            <!-- Deskripsi Acara -->
            <textarea class="form-control mb-3" placeholder="Deskripsi Acara" name="deskripsi_acara"
                required><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['deskripsi_acara']; ?></textarea>

            <!-- Jumlah Kebutuhan Volunteer -->
            <input type="number" class="form-control mb-2" placeholder="Jumlah Kebutuhan" name="jumlah_kebutuhan"
                max="999" min="1"
                value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['jumlah_kebutuhan']; ?>" required>

            <!-- Tanggal Acara -->
            <small class="text-muted">Tanggal Berlangsungnya Acara:</small>
            <input type="date" class="form-control mb-2" placeholder="Jumlah Kebutuhan" name="tanggal_acara"
                value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['tanggal_acara']; ?>" required>

            <!-- Tanggal Batas Regsitrasi -->
            <small class="text-muted">Batas Registrasi:</small>
            <input type="date" class="form-control mb-3" name="tanggal_batas_registrasi"
                value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['tanggal_batas_registrasi']; ?>"
                required>

            <!-- Lokasi -->
            <input type="text" class="form-control mb-2" placeholder="Lokasi Berlangsungnya Acara" name="lokasi"
                value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['lokasi']; ?>" required>

            <!-- Dropdown Jenis Acara -->
            <small class="text-muted">Jenis Acara:</small>
            <select class="form-select mb-3" aria-label="size 4 select" name="id_jenis_acara" required>
                <?php while($jenis_acara = $fetch_jenis_acara->fetch()) : ?>
                <option class="text-capitalize" value="<?= $jenis_acara['id_jenis_acara'] ?>"><?= $jenis_acara['nama_jenis_acara']; ?></option>
                <?php endwhile ?>
            </select>

            <!-- Button Login -->
            <div class="d-grid mb-3">
                <button type="submit" name="submit" class="btn btn-primary btn-block fw-bold">Tambah</button>
            </div>

            <!-- Garis -->
            <hr class="my-4">

            <!-- Kalimat Kembali -->
            <h5 class="text-center">Kembali ke <a href="Admin-Acara.php">List Acara</a></h5>
        </form>
    </div>
</div>

<?php include_once 'includes/footer.php' ?>