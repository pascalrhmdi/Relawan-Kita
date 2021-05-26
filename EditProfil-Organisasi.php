<?php
    $title = 'Edit Profil Organisasi';

    require_once 'includes/header.php';
    require_once 'db/connect.php';

    if(isset($_SESSION['role'])){
        if ($_SESSION['role'] != 'organisasi') header("Location: CariAktivitas.php");
    } else {
        header("Location: login.php");
    }

    $id_organisasi = $_SESSION['id_organisasi'];

    // Fetch Data Organisasi
    $result = $pdo->query("SELECT * FROM organisasi WHERE id_organisasi = $id_organisasi")->fetch();    
    

    if(isset($_GET['EditProfilOrganisasi'])){
        if ($_GET['EditProfilOrganisasi'] == 'failed') {
            $message = 'Gagal untuk merubah profil organisasi, Cek kembali form anda';
            include_once './includes/errormessage.php';
        }
    }
?>

<!-- Main Code -->
<div class="row justify-content-center ">
    <div class="col-5">
        <h1 class="text-center mb-4"><?= $title ?> </h1>
        <form action="functions/edit-organisasi.php" method="post">
            <input type="hidden" name="id_organisasi" value="<?= $id_organisasi;?>">
            

            <!-- Nama Organisasi -->
            <div class="form-group mb-3  d-flex flex-column">
                <label for="nama" class="mb-1">Nama Organisasi: *</label>
                <input required type="text" class="form-control" id="nama" name="nama"  value = "<?= $result['nama'] ?>" >
            </div>

            <!-- Deskripsi Organisasi -->
            <div class="form-group mb-3  d-flex flex-column">
                <label for="deskripsi_organisasi" class="mb-1">Deskripsi Organisasi:</label>
                <textarea class="form-control" id="deskripsi_organisasi" name="deskripsi_organisasi" rows="3" required><?= $result['deskripsi_organisasi'] ?></textarea>
            </div>
            
            <!-- Tahun Berdiri -->
            <div class="form-group mb-3  d-flex flex-column">
                <label for="tahun_berdiri" class="mb-1">Tahun Berdiri:</label>
                <input type="number" class="form-control" min="1900" max="<?= date('Y') ?>" step="1" value="<?= $result['tahun_berdiri'] ?>" name="tahun_berdiri" id="tahun_berdiri" required />
            </div>

            <!-- Button Login -->
            <div class="d-grid mb-3">
                <button type="submit" name="submit" class="btn btn-primary btn-block fw-bold">Update Organisasi</button>
            </div>

            <!-- Garis -->
            <hr class="my-4">

            <!-- Kalimat Kembali -->
            <h5 class="text-center">Kembali ke <a style="font-size: 18px;" href="Admin-Organisasi.php">List Organisasi</a></h5>
        </form>
    </div>
</div>

<?php include_once 'includes/footer.php' ?>