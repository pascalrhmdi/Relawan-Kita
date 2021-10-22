<?php
    // Fungsi ini dipakai Admin dan User (EditProfil-User.php)
    require_once '../db/connect.php';
    require_once '../includes/session.php';


    //If data was submitted via a form POST request, then...
    if (isset($_POST['submit'])) {
        // jika update dilakukan di admin panel
        if($_SESSION['role']=='admin'){
            $id_pengguna = $_POST['id_pengguna'];
        }else{
            $id_pengguna = $_SESSION['id_pengguna'];
        }
        
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $nomor_telepon = $_POST['nomor_telepon'];
        $tanggal_lahir = $_POST['tanggal_lahir'];

        $result = $user->updateUserRelawan($id_pengguna, $nama, $jenis_kelamin, $alamat, $nomor_telepon, $tanggal_lahir);
        
        if (!$result) {
            if($_SESSION['role'] == 'volunteer') {
                header("Location:../EditProfil-Relawan.php?EditProfil=failed");die;
            } 
            else{
                header("Location:../admin/relawan.php?EditUser=failed");die;
            }
        } else {
            if($_SESSION['role'] == 'volunteer') {
                $_SESSION['nama'] = $nama;
                header("Location: ../EditProfil-Relawan.php?EditProfil=success");die;
            } 
            else{
                header("Location:../admin/relawan.php?EditUser=success");die;
            }
        }
    } else {
        // Kalau belum klik submit
        header("Location: ../Admin-User.php");
    }
