<?php
    require_once '../db/connect.php';
    require_once '../includes/auth_check.php';
    if(isset($_GET['id'])){
        // Get ID values
        $id = $_GET['id'];

        //Call Delete function
        $result = $crud->deleteJenisAcara($id);
        //Redirect to list
        $result
        ? header('Location: ../admin-JenisAcara.php?deletejenisacara=success')
        : header('Location: ../admin-JenisAcara.php?deletejenisacara=failed');
    }else{
        header("Location: ../admin-JenisAcara.php");
    }

?>