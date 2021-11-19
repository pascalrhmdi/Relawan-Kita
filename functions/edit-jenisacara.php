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

//If data was submitted via a form POST request, then...
if (isset($_POST['submit'])) {
    $id_jenis_acara = $_POST['id_jenis_acara'];
    $nama_jenis_acara = $_POST['nama_jenis_acara'];
    $icon_jenis_acara = $_POST['icon_jenis_acara'];

    $result = $crud->updateJenisAcara($id_jenis_acara, $nama_jenis_acara, $icon_jenis_acara);
    if (!$result) {
        header("Location: ../admin/edit-jenis-acara.php?id=$id_jenis_acara&EditJenisAcara=failed");
    } else {
        header("Location: ../admin/jenis-acara.php?EditJenisAcara=success");
    }
} else {
    header("Location: ../admin/jenis-acara.php");
}
