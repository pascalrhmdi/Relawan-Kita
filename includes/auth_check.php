<?php
    if(isset($_SESSION['role'])){
        if($_SESSION['role'] == 'admin'){
            header("Location: ../admin/relawan.php");
        }elseif($_SESSION['role'] == 'organisasi'){
            header("Location:../organisasi/listacara.php");
        }else{
            header("Location:../CariAktivitas.php");
        };
    };
