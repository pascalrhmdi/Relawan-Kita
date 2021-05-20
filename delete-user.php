<?php
    require_once 'db/connect.php';
    require_once 'includes/auth_check.php';
    if(isset($_GET['id'])){
        // Get ID values
        $id = $_GET['id'];

        //Call Delete function
        $result = $crud->deleteUser($id);
        // chek hasil result then Redirect to list with send data
        $result
        ? header('Location: admin-User.php?deleteuser=success')
        : header('Location: admin-User.php?deleteuser=failed');
    }else{
        header("Location: admin-User.php");
    }

?>