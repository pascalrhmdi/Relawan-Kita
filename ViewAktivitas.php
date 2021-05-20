<?php
     $title = "Cari Aktivitas";

     require_once './db/connect.php';
     require_once './includes/header.php'; 

    if(isset($_GET['id_acara'])){
        $id = $_GET['id_acara'];
        $results = $crud->getAcaraById($id);

    }else {
        header("Location: CariAktivitas.php");
    }

?>
<div class="row d-flex flex-row">
    <div class="col-md-8">
        <img src="./assets/images/image_2021-05-03_14-46-10.png" alt="Foto Acara" class="img-fluid"  >   
        <div class="d-flex flex-row align-items-center justify-content-between my-4">
            <div class="col-4 d-flex flex-row align-items-center">
                <img src="assets/images/Logo_UNSOED_Now.png" style="width: 60px; height: 60px; margin-right: 10px" class="rounded-circle" alt="Logo Organisasi">
                <div>
                    <small class="text-muted m-0 d-block">Bersama</small>
                    <p class="fw-bold m-0">Nama Organisasi</p>
                    <small class="text-muted m-0 d-block">Berdiri Sejak 1971</small>
                </div>
            </div>
            <small>Total ada <b>40 Relawan</b> yang bergabung</small>
        </div>
        <div class="py-2" style="background-color: #E0E0E0;">
            <div class="container">
                <p class="fw-bold">Deskripsi Acara</p>
                <p>Deskripsi</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a>
        </div>
    </div>
    </div>
</div>

<?php require_once './includes/footer.php'; ?>