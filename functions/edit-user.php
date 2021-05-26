<?php
    // Fungsi ini dipakai Admin dan User (EditProfil-User.php)
    require_once '../db/connect.php';
    require_once '../includes/session.php';


    //If data was submitted via a form POST request, then...
    if (isset($_POST['submit'])) {
        $id_pengguna = $_POST['id_pengguna'];
        // $email = $_POST['email'];
        // $password = $_POST['password'];
        $nama = $_POST['nama'];
        $role = $_POST['role'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $nomor_telepon = $_POST['nomor_telepon'];
        $tanggal_lahir = $_POST['tanggal_lahir'];

        $result = $user->updateUser($id_pengguna, $nama, $jenis_kelamin, $alamat, $nomor_telepon, $tanggal_lahir);
        if (!$result) {
            header("Location: Edit-User.php?id=$id_pengguna&EditUser=failed");
        } else {
            if($_SESSION['role'] == $role) {
                $_SESSION['nama'] = $nama;
                header("Location: ../CariAktivitas.php?EditProfilUser=success");
            } 
            else header("Location: ../Admin-User.php?EditUser=success");
        }
    } else {
        // Kalau belum klik submit
        header("Location: ../Admin-User.php");
    }
?>