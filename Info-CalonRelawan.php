<?php
    $title = "Penerimaan Calon Relawan";

    require_once './includes/header.php';
    require_once './db/connect.php';

    // check akun
    if(isset($_SESSION['role'])){
        // hanya organisasi saja yang boleh akses ini
        if($_SESSION['role'] == 'organisasi') $id_organisasi = $_SESSION['id_organisasi'];

        elseif($_SESSION['role'] == 'volunteer') header("Location:CariAktivitas.php");
        else header("Location:Admin-Acara.php");
    } else header("Location: Login.php");
    
    // untuk ambil jumlah row apakah lebih dari 0
    if (isset($_GET['id'])) {
        $id_acara = $_GET['id'];
    }

    // untuk ambil data setelah update status
    if (isset($_GET['UpdateStatus'])) {
        $status= $_GET['UpdateStatus'];
        
        if($status == 'success') {
            $message = "Update Status Berhasil";
            include_once './includes/successmessage.php';
        } else {
            $message = "Update Status gagal";
            include_once './includes/errormessage.php';
        }
        
    }

    $query = $pdo->query("SELECT COUNT(id_pengguna) as id FROM status WHERE id_acara = $id_acara");
    $row = $query->fetch();
    // total row
    $total = $row['id'];

    $menampilkanDataPerHalaman = 5;
    $jumlahHalaman = ceil($total / $menampilkanDataPerHalaman);
    $halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
    $awalData = ($menampilkanDataPerHalaman * $halamanAktif) - $menampilkanDataPerHalaman;

    // semua data diambil
    $results = $pdo->query("SELECT * FROM status s
                            LEFT JOIN pengguna p
                                USING(id_pengguna)
                            WHERE id_acara = $id_acara
                            LIMIT $awalData, $menampilkanDataPerHalaman");


    if (isset($_GET["deleteuser"])) {
        switch ($_GET['deleteuser']) {
            case 'failed':
                $message = 'Gagal menghapus data, terdapat kesalahan.';
                include_once 'includes/errormessage.php';
                break;
            case 'success':
                $message = 'Berhasil menghapus User';
                include_once './includes/successmessage.php';
                break;
        }
    }

    if(isset($_GET['EditUser'])){
        if ($_GET['EditUser'] == 'success') {
            $message = 'Berhasil merubah profil akun';
            include_once './includes/successmessage.php';
        }
    }
?>

<!-- Judul -->
<h3 class="text-center mb-4"><?= $title; ?></h3>

<!-- Tombol Kembali -->
<a class="btn btn-primary mb-2" href="Admin-Acara.php" role="button">Kembali</a>

<!-- Tabel -->
<?php if ($total > 0) : ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-primary align-middle text-center">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Nomor Telepon</th>
                <th scope="col">Tanggal Lahir</th>
                <th scope="col">Status</th>
                <th scope="col">Jadikan</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            <?php
                    $i = ($menampilkanDataPerHalaman * $halamanAktif) - ($menampilkanDataPerHalaman - 1);
                    while ($r = $results->fetch()) :
                        $status = $r['status'];
                    ?>
            <tr>
                <th scope="row" class="text-center"><?= $i; ?></th>
                <td><?= is_null($r['nama']) ? '-' : $r["nama"]; ?></td>
                <td><?= is_null($r['jenis_kelamin']) ? '-' : $r["jenis_kelamin"]; ?></td>
                <td><?= is_null($r['nomor_telepon']) ? '-' : $r["nomor_telepon"]; ?></td>
                <td><?= is_null($r['tanggal_lahir']) ? '-' : $r["tanggal_lahir"]; ?></td>
                <!-- kalau status menunggu secondary,  lolos success, gagal danger -->
                <td class="text-center"><button class="btn <?php if($status == 'menunggu') echo 'btn-secondary'; elseif ($status == 'lolos') echo 'btn-success'; else echo 'btn-danger' ?> btn-sm pe-none text-capitalize"><?= $status; ?></bu></td>
                <form method="POST" action="functions/change-status.php">
                <input type="hidden" name="id_pengguna" value="<?= $r['id_pengguna'] ?>">
                <input type="hidden" name="id_acara" value="<?= $id_acara ?>">
                    <td class="d-grid gap-2">
                        <button type="submit" name="change_status" value="lolos" class="btn btn-success btn-sm text-capitalize">Lolos</button>
                        <button type="submit" name="change_status" value="gagal" class="btn btn-danger btn-sm text-capitalize">Gagal</button>
                    </td>
                </form>
            </tr>
            <?php $i++;
                    endwhile ?>
        </tbody>
    </table>
</div>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if ($halamanAktif == 1) echo 'disabled'; ?>">
            <a class="page-link" href="halaman=<?= $halamanAktif - 1 ?>" tabindex="-1"
                aria-disabled=<?= $halamanAktif == 1 ? "true" : "false"; ?>>Previous</a>
        </li>
        <?php
               $i = $halamanAktif < 4 ? 1 : $halamanAktif - 3;
               for ($i; $i <= $jumlahHalaman; $i++) :
               ?>
        <li class="page-item <?php if ($halamanAktif == $i) echo 'active'; ?>"
            <?php if ($halamanAktif == $i) echo 'aria-current="page"'; ?>>
            <a class="page-link" href="?halaman=<?= $i ?>"><?= $i; ?></a>
        </li>
        <?php endfor ?>
        <li class="page-item <?php if ($halamanAktif == $jumlahHalaman) echo 'disabled'; ?>">
            <a class="page-link" href="halaman=<?= $halamanAktif + 1 ?>">Next</a>
        </li>
    </ul>
</nav>
<?php else : ?>
<h6  class="mt-5" style="text-align: center;">Belum ada Relawan yang mendaftar!</h6>
<?php endif ?>

<?php
require './includes/footer.php'
?>