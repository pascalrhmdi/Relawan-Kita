<?php

// Fungsi ini dipakai oleh Admin dan Organisasi (EditProfil-Organisasi.php)
require_once '../db/connect.php';

//If data was submitted via a form POST request, then...
if (isset($_POST['submit'])) {
    $id_acara = $_POST['id_acara'];
    $judul_acara = $_POST['judul_acara'];
    $deskripsi_acara = $_POST['deskripsi_acara'];
    $jumlah_kebutuhan = $_POST['jumlah_kebutuhan'];
    $tanggal_batas_registrasi = $_POST['tanggal_batas_registrasi'];
    $tanggal_acara = $_POST['tanggal_acara'];
    $lokasi = $_POST['lokasi'];
    $id_jenis_acara = $_POST['id_jenis_acara'];

    $queryResult = $crud->updateAcara($id_acara, $judul_acara, $deskripsi_acara, $jumlah_kebutuhan, $tanggal_batas_registrasi, $tanggal_acara, $lokasi, $id_jenis_acara);

    if (!$queryResult) {
        header("Location:../organisasi/detailacara.php?id=$id_acara&successeditacara=failed");
    } else {
        header("Location:../organisasi/detailacara.php?id=$id_acara&successeditacara=successfull");
    }
} else {
    header("Location: ../CariAktivitas.php");
}
