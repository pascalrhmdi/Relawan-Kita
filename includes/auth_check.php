<?php
    if(isset($_SESSION['role'])){
        if($_SESSION['role'] == 'volunteer') header("Location:CariAktivitas.php");
    } else header("Location: Login.php");
