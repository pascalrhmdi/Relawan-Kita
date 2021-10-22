<?php

// Fungsi ini dipakai oleh Admin dan Organisasi (EditProfil-Organisasi.php)
require_once '../includes/session.php';
require_once '../db/connect.php';

//If data was submitted via a form POST request, then...
if (isset($_POST['submit'])) {
    // jika update dilakukan di admin panel
    if($_SESSION['role']=='admin'){
        $id_pengguna = $_POST['id_pengguna'];
    }else{
        $id_pengguna = $_SESSION['id_pengguna'];
    }

    $nama = $_POST['nama'];
    $deskripsi_organisasi = $_POST['deskripsi_organisasi'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];
    $tahun_berdiri = $_POST['tahun_berdiri'];

    $result = $crud->updateOrganisasi($id_pengguna, $deskripsi_organisasi, $tahun_berdiri, $nama, $alamat, $nomor_telepon);
    if (!$result) {
        if($_SESSION['role'] == 'organisasi') {
            header("Location: ../organisasi/editprofil.php?successedit=failed");die;
        } 
        else{
            header("Location:../admin/organisasi/organisasi.php?EditOrganisasi=failed");die;
        }
        
    } else {
        if($_SESSION['role']=='admin'){
            header("Location: ../admin/organisasi.php?EditOrganisasi=success");die;
        }else{
            // kalau berhasil ganti sesion nama untuk organisasi.
            $_SESSION['nama'] = $nama;

            header("Location: ../organisasi/editprofil.php?successedit=success");die;
        }
    }
} else {
    header("Location: ../CariAktivitas.php");
}
