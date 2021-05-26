<?php
    require_once '../db/connect.php';
    require_once '../includes/auth_check.php';

    //If data was submitted via a form POST request, then...
    if (isset($_POST['submit'])) {
        $id_jenis_acara = $_POST['id_jenis_acara'];
        $nama_jenis_acara = $_POST['nama_jenis_acara'];

        $result = $crud->updateJenisAcara($id_jenis_acara, $nama_jenis_acara);
        if (!$result) {
            header("Location: Edit-JenisAcara.php?id=$id_jenis_acara&EditJenisAcara=failed");
        } else {
            header("Location: ../Admin-JenisAcara.php?EditJenisAcara=success");
        }
    } else {
        header("Location: ../Admin-JenisAcara.php");
    }
?>