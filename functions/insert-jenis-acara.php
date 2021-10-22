<?php
require_once '../db/connect.php';

// check akun
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != 'admin') {
        header("Location:../CariAktivitas.php");
    }
} else {
    header("Location: ../login.php");
};

if (isset($_POST['nama_jenis_acara'])) {
    $namaJenisAcara = $_POST['nama_jenis_acara'];
    $result = $pdo->query("INSERT INTO jenis_acara(nama_jenis_acara) VALUES ('$namaJenisAcara')");
    $result
        ? header('Location: ../admin/jenis-acara.php?addnewjenisacara=success')
        : header('Location: ../admin/jenis-acara.php?addnewjenisacara=failed');
}
