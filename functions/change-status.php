<?php
    require_once '../db/connect.php';
    
    if(isset($_SESSION['role'])){
        // hanya organisasi saja yang boleh akses ini
        if($_SESSION['role'] == 'volunteer') header("Location:CariAktivitas.php");
        else header("Location:Admin-Acara.php");
    } else header("Location: Login.php");

    //If data was submitted via a form POST request, then...
    if (isset($_POST['change_status'])) {
        $value = $_POST['change_status'];
        $id_pengguna = $_POST['id_pengguna'];
        $id_acara = $_POST['id_acara'];

        $result = $crud->updateStatus($id_pengguna, $id_acara,$value);
        if (!$result) {
            header("Location: Info-CalonRelawan.php?id=$id_acara&UpdateStatus=failed");
        } else {
            header("Location: ../Info-CalonRelawan.php?id=$id_acara&UpdateStatus=success");
        }
    } else {
        header("Location: ../Admin-Acara.php");
    }
?>