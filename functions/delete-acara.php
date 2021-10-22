<?php
require_once '../includes/session.php';
require_once '../db/connect.php';

$role = $_SESSION['role'];

if (isset($role)) {
    if ($role == 'organisasi' || $role == 'admin') {
        if (isset($_GET['id']) && trim($_GET['id']) != "") {

            // Get ID values
            $id = $_GET['id'];

            if ($role == 'organisasi') {
                $organisasiHasEvent = $crud->getDetailAcaraByIdAcaraDanIdPemilik($id, $_SESSION['id_pengguna'])->fetch();
                
                if (!$organisasiHasEvent) {
                    header('Location:../organisasi/listacara.php?deleteacara=failed');die;
                }
            }

            $namaCover = $pdo->query("SELECT cover FROM acara WHERE id_acara = $id")->fetch()['cover'];

            //Call Delete function
            $result = $crud->deleteAcara($id);

            if ($result) {
                unlink("../assets/images/cover/" . $namaCover);

                if($role=='admin'){
                    header('Location: ../admin/acara.php?deleteacara=success');die;
                }else{
                    header('Location: ../organisasi/listacara.php?deleteacara=success');die;
                }
            } else {
                if($role=='admin'){
                    header('Location: ../admin/acara.php?deleteacara=failed');die;
                }else{
                    header('Location: ../organisasi/listacara.php?deleteacara=failed');die;
                }
            }
        } else {
            if($role=='admin'){
                header("Location: ../admin/acara.php");die;
            }else{
                header("Location: ../organisasi/listacara.php");die;
            }
            
        }
    } else {
        header("Location: ../CariAktivitas.php");
    }
}else{
    header("Location: ../CariAktivitas.php");
}
