<?php
$title = "Riwayat Pendaftaran Relawan";
require_once './includes/header.php';
require_once './db/connect.php';

if (!isset($_SESSION['id_pengguna'])) {
    header('location:./login.php');
    die;
}

$id_pengguna = $_SESSION['id_pengguna'];
// untuk ambil jumlah row apakah lebih dari 0
$query = $pdo->query("SELECT COUNT(id_pengguna) as id FROM pengguna JOIN status USING(id_pengguna) WHERE pengguna.id_pengguna = $id_pengguna");
$row = $query->fetch();
// total row
$total = $row['id'];

$menampilkanDataPerHalaman = 5;
$jumlahHalaman = ceil($total / $menampilkanDataPerHalaman);
$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
$awalData = ($menampilkanDataPerHalaman * $halamanAktif) - $menampilkanDataPerHalaman;

// semua data diambil
$results = $crud->getRiwayatPendaftaranRelawan($id_pengguna, $awalData, $menampilkanDataPerHalaman);
?>

<!-- Judul -->
<h1 class="text-center mb-4"><?= $title; ?></h1>

<h6>Total Pendaftaran : <?= $total; ?> Acara</h6>

<!-- Tabel -->
<?php if ($total > 0) : ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark align-middle">
                <tr>
                    <th scope="col" class="text-center">No.</th>
                    <th scope="col" class="text-center">Acara</th>
                    <th scope="col" class="text-center">Jenis Acara</th>
                    <th scope="col" class="text-center">Penyelenggara</th>
                    <th scope="col" class="text-center">Lokasi</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                <?php $i = ($menampilkanDataPerHalaman * $halamanAktif) - ($menampilkanDataPerHalaman - 1); ?>
                <?php foreach ($results as $count => $r) : ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $count+1; ?></th>
                        <td><?= $r['judul_acara']; ?></td>
                        <td><?= $r['nama_jenis_acara']; ?></td>
                        <td><?= $r['nama_org']; ?></td>
                        <td><?= $r['lokasi']; ?></td>
                        <td class="fw-bold text-center text-<?= $r['status'] === 'lolos' ? 'success' : ($r['status'] === 'gagal' ? 'danger' : 'warning'); ?>"><?= ucfirst($r['status']); ?></td>
                        <td class="text-center">
                            <a href="./viewaktivitas.php?id_acara=<?= $r['id_acara']; ?>" class="btn btn-sm btn-danger">Lihat Acara</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($halamanAktif == 1) echo 'disabled'; ?>">
                <a class="page-link" href="halaman=<?= $halamanAktif - 1 ?>" tabindex="-1" aria-disabled=<?= $halamanAktif == 1 ? "true" : "false"; ?>>Previous</a>
            </li>
            <?php
            $i = $halamanAktif < 4 ? 1 : $halamanAktif - 3;
            for ($i; $i <= $jumlahHalaman; $i++) :
            ?>
                <li class="page-item <?php if ($halamanAktif == $i) echo 'active'; ?>" <?php if ($halamanAktif == $i) echo 'aria-current="page"'; ?>>
                    <a class="page-link" href="?halaman=<?= $i ?>"><?= $i; ?></a>
                </li>
            <?php endfor ?>
            <li class="page-item <?php if ($halamanAktif == $jumlahHalaman) echo 'disabled'; ?>">
                <a class="page-link" href="halaman=<?= $halamanAktif + 1 ?>">Next</a>
            </li>
        </ul>
    </nav>
<?php else : ?>
    <h3 style="text-align: center;">Belum ada data yang masuk!</h3>
<?php endif ?>

<?php
require './includes/footer.php'
?>