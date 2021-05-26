<?php
    $title = "Manajemen Organisasi";

    require_once './includes/header.php';
    require_once './db/connect.php';
    require_once './includes/auth_check.php';

    // untuk ambil jumlah row apakah lebih dari 0
    $query = $pdo->query('SELECT COUNT(id_organisasi) as id FROM organisasi');
    $row = $query->fetch(PDO::FETCH_ASSOC);
    // total row
    $total = $row['id'];

    $menampilkanDataPerHalaman = 5;
    $jumlahHalaman = ceil($total / $menampilkanDataPerHalaman);
    $halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
    $awalData = ($menampilkanDataPerHalaman * $halamanAktif) - $menampilkanDataPerHalaman;

    // semua data diambil
    $results = $crud->getOrganisasiLimit($awalData, $menampilkanDataPerHalaman);

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

    if(isset($_GET['EditOrganisasi'])){
        if ($_GET['EditOrganisasi'] == 'success') {
            $message = 'Berhasil merubah profil Organisasi';
            include_once './includes/successmessage.php';
        }
    }
?>



<h1 class="text-center mb-4"><?= $title; ?></h1>

<h6>Total User Organisasi Relawan Kita : <?= $total; ?></h6>

<?php if ($total > 0) : ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-primary align-middle">
            <tr>
                <th scope="col" class="text-center">No.</th>
                <th scope="col" class="text-center">Nama Organisasi</th>
                <th scope="col" class="text-center">Deskripsi Organisasi</th>
                <th scope="col" class="text-center">Tahun Berdiri</th>
                <th scope="col" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            <?php
                    $i = ($menampilkanDataPerHalaman * $halamanAktif) - ($menampilkanDataPerHalaman - 1);
                    while ($r = $results->fetch(PDO::FETCH_ASSOC)) :
                    ?>
            <tr>
                <th scope="row" class="text-center"><?= $i; ?></th>
                <td style="max-width: 210px;"><?= is_null($r['nama']) ? '-' : $r["nama"]; ?></td>
                <td style="max-width: 600px;">
                    <?= is_null($r['deskripsi_organisasi']) ? '-' : $r["deskripsi_organisasi"]; ?></td>
                <td><?= is_null($r['tahun_berdiri']) ? '-' : $r["tahun_berdiri"]; ?></td>
                <td class="d-grid gap-2">
                    <a href="Edit-Organisasi.php?id=<?= $r['id_organisasi'] ?>" class="btn btn-warning btn-block"
                        style="width:100%">Edit</a>
                    <a onclick="return confirm('Are you sure you want to delete this record?');"
                        href="delete-organisasi.php?id=<?= $r['id_organisasi'] ?>" class="btn btn-danger"
                        style="width:100%">Delete</a>
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
<h3 style="text-align: center;">Belum ada data yang masuk!</h3>
<?php endif ?>

<?php
require './includes/footer.php'
?>