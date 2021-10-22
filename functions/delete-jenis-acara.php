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

if (isset($_GET['id'])) {
    // Get ID values
    $id = $_GET['id'];

    //Call Delete function
    $result = $crud->deleteJenisAcara($id);
    //Redirect to list
    $result
        ? header('Location: ../admin/jenis-acara.php?deletejenisacara=success')
        : header('Location: ../admin/jenis-acara.php?deletejenisacara=failed');
} else {
    header("Location: ../admin/jenis-acara.php");
}
