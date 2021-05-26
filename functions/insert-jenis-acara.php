<?php
    require_once '../db/connect.php';
    require_once '../includes/auth_check.php';

    if(isset($_POST['nama_jenis_acara'])){
        $namaJenisAcara = $_POST['nama_jenis_acara'];
        $result = $pdo->query("INSERT INTO jenis_acara(nama_jenis_acara) VALUES ('$namaJenisAcara')");
        !$result
        ?  header('Location: ../admin-JenisAcara.php?addnewjenisacara=failed')
        : header('Location: ../admin-JenisAcara.php?addnewjenisacara=success');
     }
?>