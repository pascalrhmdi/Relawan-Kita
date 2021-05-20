<?php
    $title = "Daftar Akun Relawan";

    require_once './includes/header.php'; 
    require_once './db/connect.php'; 

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $nama = $_POST['nama'];
        $role = $_POST['role'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $nomor_telepon = $_POST['nomor_telepon'];
        $tanggal_lahir = $_POST['tanggal_lahir'];

        $results = $user->insertUser($email, $password, $nama, $role, $jenis_kelamin, $alamat, $nomor_telepon, $tanggal_lahir);
        if (!$results) {
            echo '<div class="alert alert-danger">Username Sudah digunakan, Silahkan gunakan yang lain.</div>';
        } else {
            $result = $user->getUser($email,md5($password.$email));
            $_SESSION['id_pengguna'] = $result['id_pengguna'];
            $_SESSION['role'] = $result['role'];
            header("Location: CariAktivitas.php?login=success");
            include_once 'includes/successmessage.php';
        }
    }
?>
<div class="row justify-content-center ">
    <div class="col-11 col-md-9 col-lg-6 p-5 pt-3 justify-content-center border border-dark">
        <h1 class="text-center mb-4"><?= $title; ?></h1>
        <form method="post" action="#">
            <!-- Bagian Akun Relawan -->
            <h4>Akun Relawan</h4>
            <div class="ms-5">
                <div class="form-group mb-3 d-flex flex-column">
                    <label for="email" class="mb-1">Email address *</label>
                    <input required type="email" class="form-control" id="email"  name="email" aria-describedby="emailHelp" >
                    <small id="emailHelp" class="form-text text-muted text-end">Digunakan untuk login, pastikan email anda valid.</small>
                </div>
                <!-- <label for="password" class="mb-1">Password *</label>
                <div class="input-group mb-3">
                    <label class="input-group-text" id="basic-addon2" for="password">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                    </label>
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" data-bs-toggle="tooltip" data-bs-placement="right" title="Masukkan Password" aria-describedby="basic-addon2" required>
                </div> -->
                <div class="form-group mb-3 d-flex flex-column">
                <label for="password" class="mb-1">Password *</label>
                    <input required type="password" class="form-control" id="password" name="password">
                    <small id="emailHelp" class="form-text text-muted text-end">Digunakan untuk login, pastikan password anda mudah diingat.</small>
                </div>
                <input type="hidden" value="volunteer" name="role">
                <div class="form-group mb-3  d-flex flex-column">
                    <label for="nama" class="mb-1">Nama Lengkap *</label>
                    <input required type="text" class="form-control" id="nama" name="nama">
                    <small id="emailHelp" class="form-text text-muted text-end">Sesuai KTP</small>
                </div>
            </div>
            <h4>Data Diri</h4>
            <div class="ms-5">
                <div class="form-group  mb-3 d-flex flex-column">
                    <label for="nomor_telepon" class="mb-1">Nomor Telepon</label>
                    <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon">
                    <small id="emailHelp" class="form-text text-muted text-end">Nomor Whatsapp lebih baik</small>
                </div>
                <div class="form-group  mb-3 d-flex flex-column">
                    <label for="tanggal_lahir" class="mb-1">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                    <small id="emailHelp" class="form-text text-muted text-end">Sesuai KTP</small>
                </div>
                <div class="formgroup  mb-3">
                    <label class="mb-1">Jenis Kelamin *</label>
                    <div class="container">
                        <div class="form-check">
                            <input required class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="Laki-laki">
                            <label class="form-check-label" for="jenis_kelamin1">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="Perempuan">
                            <label class="form-check-label" for="jenis_kelamin2">
                                Perempuan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3  d-flex flex-column">
                    <label for="alamat" class="mb-1">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                    <small id="emailHelp" class="form-text text-muted text-end">Sesuai KTP</small>
                </div>
            </div>
            <div class="container my-4">
                <p class="text-center mb-0">Pastikan bahwa informasi yang anda masukkan sudah benar.</p>
                <p class="text-center">Dengan mendaftar, Anda telah menyetujui <a href="#">syarat</a> dan <a href="#">ketentuan</a> dari Relawan Kita</p>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" name="submit" class="btn btn-primary btn-block fw-bold">Daftar</button>
            </div>
        </form>
    </div>
</div>
<?php require_once './includes/footer.php'; ?>