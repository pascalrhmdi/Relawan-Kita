<?php

// Fungsi ini dipakai oleh Admin dan Organisasi (EditProfil-Organisasi.php)
require_once '../includes/session.php';
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
    $coverLama = $_POST['cover_lama'];

    $namaFile = $_FILES['cover-acara']['name'];
    $ukuranFile = $_FILES['cover-acara']['size'];
    $error = $_FILES['cover-acara']['error'];
    $tmp = $_FILES['cover-acara']['tmp_name'];

    //cek apakah user sudah mengupload file belum
    if ($error === 4) {
        $namaCover = $coverLama;
    } else {
        //cek apakah file yang diupload sesuai
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiFileUploaded = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        if (!in_array($ekstensiFileUploaded, $ekstensiGambarValid)) {
            echo "<script>
            alert('Yang anda upload bukan gambar');
        </script>";
            return false;
        }

        //cek apakah ukuran file yang diupload sesuai
        if ($ukuranFile > 1000000) {
            echo "<script>
            alert('ukuran gambar terlalu besar');
        </script>";
            return false;
        }

        //generate nama baru 
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiFileUploaded;

        $namaCover = $namaFileBaru;
    }

    $id_pengguna = $_SESSION['id_pengguna'];

    $queryResult = $crud->updateAcara($id_acara, $judul_acara, $deskripsi_acara, $jumlah_kebutuhan, $tanggal_batas_registrasi, $tanggal_acara, $lokasi, $id_jenis_acara, $namaCover,$id_pengguna);

    if (!$queryResult) {
        header("Location:../organisasi/detailacara.php?id=$id_acara&successeditacara=failed");
    } else {
        // file uplaoded successfully
        if ($error === 0) {
            unlink("../assets/images/cover/" . $coverLama);
            move_uploaded_file($tmp, '../assets/images/cover/' . $namaFileBaru);
        }

        header("Location:../organisasi/detailacara.php?id=$id_acara&successeditacara=successfull");
    }
} else {
    header("Location: ../CariAktivitas.php");
}
