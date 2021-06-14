<?php
require_once '../db/connect.php';

//If data was submitted via a form POST request, then...
if (isset($_POST['change_status'])) {
    $value = $_POST['change_status'];
    $id_pengguna = $_POST['id_pengguna'];
    $id_acara = $_POST['id_acara'];

    $result = $crud->updateStatus($id_pengguna, $id_acara, $value);
    if (!$result) {
        header("Location:../organisasi/detailacara.php?id=$id_acara&UpdateStatus=failed");
    } else {
        header("Location: ../organisasi/detailacara.php?id=$id_acara&UpdateStatus=success");
    }
} else {
    header("Location: ../organisasi/listacara.php");
}
