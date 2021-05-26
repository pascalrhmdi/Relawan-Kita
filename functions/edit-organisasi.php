<?php

    // Fungsi ini dipakai oleh Admin dan Organisasi (EditProfil-Organisasi.php)
    require_once '../db/connect.php';
    
    //If data was submitted via a form POST request, then...
    if (isset($_POST['submit'])) {
        $id_organisasi = $_POST['id_organisasi'];
        // $email = $_POST['email'];
        // $password = $_POST['password'];
        $nama = $_POST['nama'];
        $deskripsi_organisasi = $_POST['deskripsi_organisasi'];
        $tahun_berdiri = $_POST['tahun_berdiri'];

        $result = $crud->updateOrganisasi($id_organisasi, $nama, $deskripsi_organisasi, $tahun_berdiri);
        if (!$result) {
            header("Location: Edit-Organisasi.php?id=$id_organisasi&EditOrganisasi=failed");
        } else {
            // kalau berhasil ganti sesion nama untuk organisasi.
            if($_SESSION['role'] == 'organisasi') $_SESSION['nama'] = $nama;
            header("Location: ../Admin-Organisasi.php?EditOrganisasi=success");
        }
    } else {
        header("Location: ../Admin-Organisasi.php");
    }
?>