<?php
    $title = 'Edit JenisAcara';

    require_once 'includes/header.php';
    require_once 'db/connect.php';
    require_once './includes/auth_check.php';

    if(isset($_GET['id'])){
        $id_jenis_acara = $_GET['id'];

        // Fetch Data user
        $result = $pdo->query("SELECT * FROM jenis_acara WHERE id_jenis_acara = $id_jenis_acara")->fetch();
    } else {
        header("Location: Admin-JenisAcara.php");
    }

    if(isset($_GET['EditJenisAcara'])){
        if ($_GET['EditJenisAcara'] == 'failed') {
            $message = 'Gagal untuk merubah profil Jenis Acara, Cek kembali form anda';
            include_once './includes/errormessage.php';
        }
    }
?>

<!-- Main Code -->
<div class="row justify-content-center ">
    <div class="col-5">
        <h1 class="text-center mb-4"><?= $title ?> </h1>
        <form action="functions/edit-JenisAcara.php" method="post">
            <!-- id Jenis ACara -->
            <input type="hidden" name="id_jenis_acara" value="<?= $id_jenis_acara;?>">

            <!-- Email -->
            <div class="form-group mb-3  d-flex flex-column">
                <label for="nama_jenis_acara" class="mb-1">Nama Jenis Acara: *</label>
                <input required type="text" class="form-control" id="nama_jenis_acara" name="nama_jenis_acara"  value = "<?= $result['nama_jenis_acara'] ?>" >
            </div>

            <!-- Button Login -->
            <div class="d-grid mb-3">
                <button type="submit" name="submit" class="btn btn-primary btn-block fw-bold">Update Jenis Acara</button>
            </div>

            <!-- Garis -->
            <hr class="my-4">

            <!-- Kalimat Kembali -->
            <h5 class="text-center">Kembali ke <a style="font-size: 18px;" href="Admin-JenisAcara.php">List Jenis Acara</a></h5>
        </form>
    </div>
</div>

<?php include_once 'includes/footer.php' ?>