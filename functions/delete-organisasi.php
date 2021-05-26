<?php
    require_once '../db/connect.php';
    require_once '../includes/auth_check.php';
    if(isset($_GET['id'])){
        // Get ID values
        $id = $_GET['id'];

        //Call Delete function
        $result = $crud->deleteOrganisasi($id);
        //Redirect to list
        $result
        ? header('Location: ../admin-Organisasi.php?deleteorganisasi=success')
        : header('Location: ../admin-Organisasi.php?deleteorganisasi=failed');
    }else{
        header("Location: ../admin-Organisasi.php");
    }

?>