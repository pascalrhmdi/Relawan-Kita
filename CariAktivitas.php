<?php
     $title = "Cari Aktivitas";

     require_once './db/connect.php';
     require_once './includes/header.php'; 

      if(isset($_GET['login'])){
          $nama = $_SESSION['nama'];
          $message = "Selamat datang $nama, Anda Berhasil Login";
          include_once './includes/successmessage.php';
     }

     // untuk ambil jumlah row apakah lebih dari 0
     $query= $pdo->query('SELECT COUNT(id_acara) as id FROM acara');
     $row = $query->fetch(PDO::FETCH_ASSOC);
     // total row
     $total = $row['id'];
     
     $menampilkanDataPerHalaman = 8;
     $jumlahHalaman = ceil($total/$menampilkanDataPerHalaman);
     $halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1 ;
     $awalData = ($menampilkanDataPerHalaman * $halamanAktif) - $menampilkanDataPerHalaman;
     
     
     // apakah filter sudah di klik?
     if(isset($_GET['judul_acara'])){
          // ambil parameter
          $judul_acara = $_GET['judul_acara'];
          $lokasi = $_GET['lokasi'];
          $nama_jenis_acara = $_GET['nama_jenis_acara'];
          
          // ambil data yang difilter
          $results = $crud->getAcaraFiltered($awalData, $menampilkanDataPerHalaman,$judul_acara, $lokasi, $nama_jenis_acara);
     } else {
          // ambil data
          $results = $crud->getAcara($awalData, $menampilkanDataPerHalaman);
     }
     // echo($results->rowCount());
?>

     <!-- Judul diatas -->
     <div class="d-flex justify-content-between text-danger mb-2">
          <h3 class="align-self-start mb-0">Cari Aktivitas Baru,<span class="fs-4 fw-normal"> <?= $total; ?> Aktivitas Membutuhkan Bantuan Anda</span></h3>
          <a class="btn btn-danger text-white" data-bs-toggle="collapse" href="#filter" role="button" aria-expanded="false" aria-controls="filter">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
               </svg>
               Filter
          </a>
     </div>
     <hr class="my-1 text-danger">
     <!-- Kotak Filter -->
     <div class="collapse my-3" id="filter">
          <div class="card card-body shadow-sm p-3 bg-body rounded">
          <p class="fw-bolder">Filter Aktivitas</p>
               <form method="GET" action="" autocomplete="on" class="row g-2 ">
               <div class="col-3" style="max-height: 40px;">
                    <input type="text" class="form-control" name="judul_acara" placeholder="Judul Acara" maxlength='50'> 
               </div>
               <div class="col-2">
                    <input type="text" class="form-control" name="lokasi" placeholder="Lokasi Kota" maxlength='50'> 
               </div>
               <div class="col-2">
                    <input type="text" class="form-control" name="nama_jenis_acara" placeholder="Jenis Acara" maxlength='255'> 
               </div>
               <div class="col-2">
               <button type="submit" class="btn btn-primary" name="submit">Confirm</button>
               </div>
               </form>
          </div>
     </div>
     <!-- Kotak  -->
     <div class="row mt-3">
     <?php if($total > 0) : ?>
          <?php while ($r = $results->fetch(PDO::FETCH_ASSOC)): ?>
          <div class="col-3 mb-3 ">
               <div class="card shadow-sm" style="height: 100%;">
                         <a href="ViewAktivitas.php?id_acara=<?= $r['id_acara'] ?>"  rel="noopener noreferrer" class="no-effect-link">
                         <img src="assets/images/image_2021-05-03_14-46-10.png" class="card-img-top " alt="Foto Organisasi" >
                         <div class="card-body ">
                              <span class="text-uppercase p-1 rounded-pill" style="border: 1px solid #DF202E; color:#DF202E; font-size: 8px"><?= $r['nama_jenis_acara']; ?></span>
                              <h5 class="my-2 fw-bold text-capitalize" style="font-size: 18px;"><?= $r['judul_acara']; ?></h5>
                              <small class="mt-3 mb-1 text-muted"><?= $r['nama_organisasi']; ?></small>
                              <hr class="my-2 border  border-dark" >
                              <h5>Waktu & Lokasi</h5>
                              <div class="d-flex flex-row align-items-center mb-2">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16">
                                        <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                   </svg>
                                   <small class="text-muted offset-1"><?= $r['tanggal_acara']; ?></small>
                              </div>
                              <div class="d-flex flex-row align-items-center">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                   </svg>
                                   <small class="text-muted offset-1"><?= $r['lokasi']; ?></small>
                              </div>
                         </div>
                    </a>
               </div>
          </div>
     <?php endwhile ?>
     <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center my-5">
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
                    <a class="page-link" href="?halaman=<?= $halamanAktif+1 ?>">Next</a>
               </li>
          </ul>
     </nav>
     <?php else: ?>
          <h3 style="text-align: center;">Belum ada data yang masuk!</h3>
     <?php endif ?>
     </div>

<?php
     require './includes/footer.php'
?>