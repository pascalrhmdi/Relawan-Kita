<?php
    require_once 'db/connect.php';
    require_once 'includes/auth_check.php';

    if(isset($_GET['id'])){
        // Get ID values
        $id = $_GET['id'];

        //Call Delete function
        $result = $crud->deleteAcara($id);
        
        //Redirect to list
        $result
        ? header('Location: admin-Acara.php?deleteacara=success')
        : header('Location: admin-Acara.php?deleteacara=failed');
    }else{
        header("Location: admin-Acara.php");
    }

?>