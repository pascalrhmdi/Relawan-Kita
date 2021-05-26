<?php
    $title = "Manajemen Jenis Acara";

    require_once './includes/header.php';
    require_once './db/connect.php';
    require_once './includes/auth_check.php';

    // untuk ambil jumlah row apakah lebih dari 0
    $query = $pdo->query("SELECT COUNT(id_jenis_acara) AS id FROM jenis_acara");
    $row = $query->fetch();
    // total row
    $total = $row['id'];

    $menampilkanDataPerHalaman = 10;
    $jumlahHalaman = ceil($total / $menampilkanDataPerHalaman);
    $halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
    $awalData = ($menampilkanDataPerHalaman * $halamanAktif) - $menampilkanDataPerHalaman;

    // semua data diambil
    $results = $crud->getJenisAcaraLimit($awalData, $menampilkanDataPerHalaman);


    if (isset($_GET['addnewjenisacara'])) {
        switch ($_GET['addnewjenisacara']) {
            case 'failed':
                $message = 'Gagal untuk menambahkan Jenis Acara ';
                include_once './includes/errormessage.php';
                break;
            case 'success':
                $message = 'Berhasil Menambahkan Jenis Acara';
                include_once './includes/successmessage.php';
                break;
        }
    }

    if (isset($_GET["deletejenisacara"])) {
        switch ($_GET['deletejenisacara']) {
            case 'failed':
                $message = 'Gagal menghapus data, terdapat kesalahan.';
                include_once 'includes/errormessage.php';
                break;
            case 'success':
                $message = 'Berhasil menghapus data Jenis Acara';
                include_once './includes/successmessage.php';
                break;
        }
    }

    if(isset($_GET['EditJenisAcara'])){
        if ($_GET['EditJenisAcara'] == 'success') {
            $message = 'Berhasil merubah Nama Jenis Acara';
            include_once './includes/successmessage.php';
        }
    }
?>

<!-- Judul -->
<h1 class="text-center mb-4"><?= $title; ?></h1>

<h6>Total Jenis Acara Relawan Kita : <?= $total; ?></h6>

<!-- Insert Jenis Acara Baru-->
<div class="d-flex justify-content-end mb-2">
    <div class="col-3">
        <form action="insert-jenis-acara.php" method="POST">
            <input type="text" class="form-control" id="nama_jenis_acara" placeholder="Tambah Jenis Acara"
                name="nama_jenis_acara" maxlength='50' required>
    </div>
    <div class="col-1">
        <div class="d-grid ">
            <button type="submit" name="submit" class="btn btn-primary">Add</button>
        </div>
        </form>
    </div>
</div>

<!-- Table Jenis Acara -->
<?php if ($total > 0) : ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-primary align-middle">
            <tr>
                <th scope="col" class="text-center">No.</th>
                <th scope="col" class="text-center">Jenis Acara Organisasi</th>
                <th scope="col" class="text-center" style="width: 250px;">Aksi</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            <?php
                    $i = ($menampilkanDataPerHalaman * $halamanAktif) - ($menampilkanDataPerHalaman - 1);
                    while ($r = $results->fetch(PDO::FETCH_ASSOC)) :
                    ?>
            <tr>
                <th scope="row" class="text-center"><?= $i; ?></th>
                <td><?= is_null($r['nama_jenis_acara']) ? '-' : $r["nama_jenis_acara"]; ?></td>
                <td class="d-flex justify-content-around">
                    <!-- Edit -->
                    <a href="functions/Edit-JenisAcara.php?id=<?= $r['id_jenis_acara'] ?>" class="btn btn-warning btn-sm"
                        style="width:100%; max-width: 100px">Edit</a>
                    <!-- Delete -->
                    <a onclick="return confirm('Are you sure you want to delete this record?');"
                        href="functions/delete-jenis-acara.php?id=<?= $r['id_jenis_acara'] ?>" class="btn btn-danger btn-sm"
                        style="width:100%; max-width: 100px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path
                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                        </svg>
                        Delete
                    </a>
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
            <a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?>">Next</a>
        </li>
    </ul>
</nav>
<?php else : ?>
<h3 style="text-align: center;">Belum ada data Jenis Acara!</h3>
<?php endif ?>

<?php
require './includes/footer.php'
?>