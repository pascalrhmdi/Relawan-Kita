<?php
    $title = 'Masuk'; 

    require_once 'includes/header.php'; 
    require_once 'db/connect.php'; 
    // require_once 'includes/auth_check.php'; 
    
    //If data was submitted via a form POST request, then...
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $new_password = md5($password.$email);
        
        $result = $user->getUser($email,$new_password);
        if(!$result){
            $message = 'Username or Password is incorrect! Please try again.';
            include_once './includes/errormessage.php';
        }else{
            $_SESSION['id_pengguna'] = $result['id_pengguna'];
            $_SESSION['nama'] = $result['nama'];
            $_SESSION['role'] = $result['role'];
            if($_SESSION['role'] == 'admin') header("Location: Admin-User.php?login=success");
            else header("Location: CariAktivitas.php?login=success");
            include_once 'includes/successmessage.php';
        }
    }
?>

<!-- Main Code -->

<div class="row justify-content-center ">
    <div class="col-4">
        <h1 class="text-center mb-3"><?php echo $title ?> </h1>
        
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <!-- Email -->
            <div class="input-group mb-4">
                <label class="input-group-text" id="basic-addon1" for="email">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                    </svg>
                </label>
                <input type="text" class="form-control" placeholder="Email" id="email" name="email" aria-describedby="basic-addon1" data-bs-toggle="tooltip" data-bs-placement="right" title="Email harus valid" value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['email']; ?>" required autofocus>
            </div>
            <!-- Password -->
            <div class="input-group mb-3">
                <label class="input-group-text" id="basic-addon2" for="password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    </svg>
                </label>
                <input type="password" class="form-control" placeholder="Password" id="password" name="password" data-bs-toggle="tooltip" data-bs-placement="right" title="Masukkan Password" aria-describedby="basic-addon2" required>
            </div>
            <!-- Button Login -->
            <div class="d-grid mb-3">
                <button type="submit" name="submit" class="btn btn-primary btn-block fw-bold">Log in</button>
            </div>
            <!-- Belum dikasih link -->
            <a href="#" class="text-end">Lupa Password?</a>
            <hr class="my-4">
            <h5 class="text-center">Belum Punya Akun? <a href="BuatAkun-Relawan.php">Yuk Daftar!</a></h5>
        </form>
    </div>
</div>

<?php include_once 'includes/footer.php'?>