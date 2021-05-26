<?php
$title = "Manajemen Acara";

require_once './includes/header.php';
require_once './db/connect.php';

// check akun
if(isset($_SESSION['role'])){
    if($_SESSION['role'] == 'volunteer') header("Location:CariAktivitas.php");
    elseif($_SESSION['role'] == 'organisasi') $id_organisasi = $_SESSION['id_organisasi'];;
} else header("Location: Login.php");

if(isset($_GET['deleteacara'])){
    $message = "Delete Acara Berhasil";
    include_once './includes/successmessage.php';
}

// untuk ambil jumlah row apakah lebih dari 0
$_SESSION['role'] == 'admin'
? $query = $pdo->query('SELECT COUNT(id_acara) as id FROM acara')
: $query = $pdo->query("SELECT COUNT(id_acara) as id FROM acara WHERE id_organisasi = $id_organisasi");
$row = $query->fetch(); 
// total row
$total = $row['id'];

$menampilkanDataPerHalaman = 10;
$jumlahHalaman = ceil($total / $menampilkanDataPerHalaman);
$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
$awalData = ($menampilkanDataPerHalaman * $halamanAktif) - $menampilkanDataPerHalaman;

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
               include_once 'includes/errormessage.php';
               break;
          case 'success':
               $message = 'Berhasil menghapus Organisasi';
               include_once './includes/successmessage.php';
               break;
     }
}
?>

<h3 class="text-center mb-4"><?= $title; ?></h3>

<h6>Total Acara Relawan Kita : <?= $total; ?></h6>

<!-- Tambah acara hanya untuk organisasi -->
<?php if($_SESSION['role'] == 'organisasi') : ?>
    <a class="btn btn-primary mb-2" href="InsertAcara.php" role="button">Tambah Acara</a>
<?php else : ?>
    <small class="text-muted text-end d-block mb-2">Admin dapat membanned atau menghapus Organisasi saja, Tambah dan Edit Acara hanya diperbolehkan untuk organisasi saja. </small>
<?php endif ?>


<?php if ($total > 0) : ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-primary align-middle text-center">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama</th>
                <th scope="col">Jenis Acara</th>
                <th scope="col"></th>
                <th scope="col">Lokasi</th>
                <th scope="col" style="max-width: 90px;">Jumlah Kebutuhan</th>
                <th scope="col" style="max-width: 100px;">Batas Registrasi</th>
                <th scope="col">Mulai Acara</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            <?php
                    $i = ($menampilkanDataPerHalaman * $halamanAktif) - ($menampilkanDataPerHalaman - 1);
                    while ($r = $results->fetch()) :
                    ?>
            <tr>
                <th scope="row" class="text-center"><?= $i; ?></th>
                <!-- Data -->
                <td style="max-width: 210px;"><?= is_null($r['judul_acara']) ? '-' : $r["judul_acara"]; ?></td>
                <td><?= is_null($r['nama_jenis_acara']) ? '-' : $r["nama_jenis_acara"]; ?></td>
                <td><?= is_null($r['nama']) ? '-' : $r["nama"]; ?></td>
                <td style="max-width: 600px;"><?= is_null($r['lokasi']) ? '-' : $r["lokasi"]; ?></td>
                <td class="text-center"><?= is_null($r['jumlah_kebutuhan']) ? '-' : $r["jumlah_kebutuhan"]; ?></td>
                <td><?= is_null($r['tanggal_batas_registrasi']) ? '-' : $r["tanggal_batas_registrasi"]; ?></td>
                <td><?= is_null($r['tanggal_acara']) ? '-' : $r["tanggal_acara"]; ?></td>
                
                    <!-- admin hanya mendelete acara -->
                    <?php if($_SESSION['role'] == 'admin') : ?>
                    <td>
                        <a onclick="return confirm('Are you sure you want to delete this Acara\'s record?');"
                        href="delete-acara.php?id=<?= $r['id_acara'] ?>" class="btn btn-danger"
                        style="width:100%">Delete</a>
                    <?php else: ?>
                    <td class="d-grid gap-2">
                        <a href="Info-CalonRelawan.php?id=<?= $r['id_acara'] ?>" class="btn btn-info text-nowrap"
                        style="width:100%;">Info Relawan</a>
                        <a onclick="return confirm('Are you sure you want to delete this Acara\'s record?');"
                        href="functions/delete-acara.php?id=<?= $r['id_acara'] ?>" class="btn btn-danger"
                        style="width:100%;">Delete</a>
                    <?php endif ?>
                </td>
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
<h3 style="text-align: center;">Belum ada Jadwal Acara!</h3>
<?php endif ?>

<?php
require './includes/footer.php'
?>