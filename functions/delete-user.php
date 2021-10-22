<?php
    require_once '../db/connect.php';
  
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] != 'admin') {
            header("Location:../CariAktivitas.php");
        }
    } else {
        header("Location: ../login.php");
    };

    if(isset($_GET['id'])){
        // Get ID values
        $id = $_GET['id'];

        //Call Delete function
        $result = $crud->deleteUser($id);
        // chek hasil result then Redirect to list with send data
        $result
        ? header('Location: ../admin/relawan.php?deleteuser=success')
        : header('Location: ../admin/relawan.php?deleteuser=failed');
    }else{
        header("Location: ../admin/relawan.php");
    }

?>