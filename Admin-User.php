<?php
     $title = "Manajemen User";

     require_once './includes/header.php'; 
     require_once './db/connect.php';
     require_once './includes/auth_check.php';

     // untuk ambil jumlah row apakah lebih dari 0
     $query= $pdo->query('SELECT COUNT(id_pengguna) as id FROM pengguna WHERE role = "admin"');
     $row = $query->fetch(PDO::FETCH_ASSOC);
     // total row
     $total = $row['id'];
     
     $menampilkanDataPerHalaman = 5;
     $jumlahHalaman = ceil($total/$menampilkanDataPerHalaman);
     $halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1 ;
     $awalData = ($menampilkanDataPerHalaman * $halamanAktif) - $menampilkanDataPerHalaman;
     
     // semua data diambil
     $results = $crud->getUsers($awalData, $menampilkanDataPerHalaman);

     if(isset($_GET['login'])){
          $message = "Selamat datang Admin, Anda Berhasil Login";
          include_once './includes/successmessage.php';
     }

     if(isset($_GET["deleteuser"])){
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
?>

<!-- Judul -->
<h1 class="text-center mb-4"><?= $title; ?></h1>

<!-- Tabel -->
<?php if($total > 0) : ?>
     <div class="table-responsive">
          <table class="table table-striped table-bordered">
               <thead class="table-primary">
                    <tr>
                         <th scope="col" class="text-center">No.</th>
                         <th scope="col" class="text-center">Nama</th>
                         <th scope="col" class="text-center">Email</th>
                         <th scope="col" class="text-center">Jenis Kelamin</th>
                         <th scope="col" class="text-center">Alamat</th>
                         <th scope="col" class="text-center">Nomor Telepon</th>
                         <th scope="col" class="text-center">Tanggal Lahir</th>
                         <th scope="col" class="text-center">Aksi</th>
                    </tr>
               </thead>
               <tbody>
                    <?php
                         $i = ($menampilkanDataPerHalaman * $halamanAktif) - ($menampilkanDataPerHalaman - 1) ;
                         while($r = $results->fetch(PDO::FETCH_ASSOC)): 
                    ?>
                    <tr>
                         <th scope="row" class="text-center"><?= $i; ?></th>
                         <td><?= is_null($r['nama']) ? '-' : $r["nama"] ; ?></td>
                         <td><?= is_null($r['email']) ? '-' : $r["email"] ; ?></td>
                         <td><?= is_null($r['jenis_kelamin']) ? '-' : $r["jenis_kelamin"] ; ?></td>
                         <td style="max-width: 270px;"><?= is_null($r['alamat']) ? '-' : $r["alamat"] ; ?></td>
                         <td><?= is_null($r['nomor_telepon']) ? '-' : $r["nomor_telepon"] ; ?></td>
                         <td><?= is_null($r['tanggal_lahir']) ? '-' : $r["tanggal_lahir"] ; ?></td>
                         <td class="d-grid gap-2">
                              <a href="edit.php?id=<?= $r['id_pengguna'] ?>" class="btn btn-warning" style="width:100%; max-width: 80px" >Edit</a>
                              <a onclick="return confirm('Are you sure you want to delete this record?');" href="delete-user.php?id=<?= $r['id_pengguna'] ?>" class="btn btn-danger" style="width:100%; max-width: 80px">Delete</a>
                         </td>
                    </tr>
                    <?php $i++; endwhile ?>
               </tbody>
          </table>
     </div>
     <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
               <li class="page-item <?php if($halamanAktif == 1) echo 'disabled'; ?>" >
                    <a class="page-link" href="halaman=<?= $halamanAktif-1 ?>" tabindex="-1" aria-disabled=<?= $halamanAktif==1 ? "true" : "false"; ?>>Previous</a>
               </li>
               <?php
                    $i = $halamanAktif < 4 ? 1 : $halamanAktif-3;
                    for ($i; $i <= $jumlahHalaman; $i++) : 
               ?>
               <li class="page-item <?php if($halamanAktif == $i) echo 'active'; ?>"  <?php if($halamanAktif == $i) echo 'aria-current="page"'; ?> >
                    <a class="page-link" href="?halaman=<?=$i?>"><?= $i; ?></a>
               </li>
               <?php endfor ?>
               <li class="page-item <?php if($halamanAktif == $jumlahHalaman) echo 'disabled'; ?>">
                    <a class="page-link" href="halaman=<?= $halamanAktif+1 ?>">Next</a>
               </li>
          </ul>
     </nav>
<?php else: ?>
     <h3 style="text-align: center;">Belum ada data yang masuk!</h3>
<?php endif ?>

<?php
     require './includes/footer.php'
?>