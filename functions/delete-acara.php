<?php
session_start();
require_once '../db/connect.php';
require_once '../includes/auth_check.php';

if (isset($_GET['id'])) {
    // Get ID values
    $id = $_GET['id'];

    $namaCover = $pdo->query("SELECT cover FROM acara WHERE id_acara = $id")->fetch()['cover'];

    //Call Delete function
    $result = $crud->deleteAcara($id);

    if ($result) {
        unlink("../assets/images/cover/" . $namaCover);
        header('Location: ../organisasi/listacara.php?deleteacara=success');
    } else {
        header('Location: ../organisasi/listacara.php?deleteacara=failed');
    }
} else {
    header("Location: ../organisasi/listacara.php");
}
