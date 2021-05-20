<?php
     $title = "Manajemen Acara";

     require_once './includes/header.php'; 
     require_once './db/connect.php';
     require_once './includes/auth_check.php';
 
     // untuk ambil jumlah row apakah lebih dari 0
     $query= $pdo->query('SELECT COUNT(id_acara) as id FROM acara');
     $row = $query->fetch(PDO::FETCH_ASSOC);
     // total row
     $total = $row['id'];
     
     $menampilkanDataPerHalaman = 10;
     $jumlahHalaman = ceil($total/$menampilkanDataPerHalaman);
     $halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1 ;
     $awalData = ($menampilkanDataPerHalaman * $halamanAktif) - $menampilkanDataPerHalaman;
     
     // semua data diambil
     $results = $crud->getAcara($awalData, $menampilkanDataPerHalaman);

     if(isset($_GET["deleteorganisasi"])){
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



<h1 class="text-center mb-4"><?= $title; ?></h1>

<?php if($total > 0) : ?>
     <div class="table-responsive">
          <table class="table table-striped table-bordered">
               <thead class="table-primary">
                    <tr>
                         <th scope="col" class="text-center">No.</th>
                         <th scope="col" class="text-center">Judul Acara</th>
                         <th scope="col" class="text-center">Jenis Acara</th>
                         <th scope="col" class="text-center">Diadakan Oleh</th>
                         <th scope="col" class="text-center">Lokasi</th>
                         <th scope="col" class="text-center">Jumlah Kebutuhan</th>
                         <th scope="col" class="text-center">Batas Registrasi</th>
                         <th scope="col" class="text-center">Mulai Acara</th>
                         <th scope="col" class="text-center">Aksi</th>
                    </tr>
               </thead>
               <tbody >
                    <?php
                         $i = ($menampilkanDataPerHalaman * $halamanAktif) - ($menampilkanDataPerHalaman - 1) ;
                         while($r = $results->fetch(PDO::FETCH_ASSOC)): 
                    ?>
                    <tr>
                         <th scope="row" class="text-center"><?= $i; ?></th>
                         <!-- Data -->
                         <td style="max-width: 210px;"><?= is_null($r['judul_acara']) ? '-' : $r["judul_acara"] ; ?></td>
                         <td><?= is_null($r['nama_jenis_acara']) ? '-' : $r["nama_jenis_acara"] ; ?></td>
                         <td><?= is_null($r['nama_organisasi']) ? '-' : $r["nama_organisasi"] ; ?></td>
                         <td style="max-width: 600px;"><?= is_null($r['lokasi']) ? '-' : $r["lokasi"] ; ?></td>
                         <td><?= is_null($r['jumlah_kebutuhan']) ? '-' : $r["jumlah_kebutuhan"] ; ?></td>
                         <td><?= is_null($r['tanggal_batas_registrasi']) ? '-' : $r["tanggal_batas_registrasi"] ; ?></td>
                         <td><?= is_null($r['tanggal_acara']) ? '-' : $r["tanggal_acara"] ; ?></td>
                         <td>
                              <a onclick="return confirm('Are you sure you want to delete this Acara\'s record?');" href="delete-acara.php?id=<?= $r['id_acara'] ?>" class="btn btn-danger" style="width:100%">Delete</a>
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