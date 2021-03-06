<?php
    require_once '../db/connect.php';
    require_once '../includes/session.php';
    
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] != 'admin') {
            header("Location:CariAktivitas.php");
        }
    } else {
        header("Location: ../login.php");
    };

    if(isset($_GET['id'])){
        // Get ID values
        $id = $_GET['id'];

        //Call Delete function
        $result = $crud->deleteOrganisasi($id);
        //Redirect to list
        $result
        ? header('Location: ../admin/organisasi.php?deleteorganisasi=success')
        : header('Location: ../admin/organisasi.php?deleteorganisasi=failed');
    }else{
        header("Location: ../admin/organisasi.php");
    }

?>