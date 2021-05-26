<?php 
    class user{
        // private database object\
        private $db;
        
        //constructor to initialize private variable to the database connection
        function __construct($conn){
            $this->db = $conn;
        }

        // Dipakai untuk 
        public function insertUser($email,$password, $nama, $role, $jenis_kelamin, $alamat, $nomor_telepon, $tanggal_lahir){
            try {
                $result = $this->getUserbyEmail($email);
                if($result['num'] > 0){
                    return false;
                } else{
                    $new_password = md5($password.$email);
                    // define sql statement to be executed
                    $sql = "INSERT INTO pengguna (`email`, `password`, `nama`, `role`, `jenis_kelamin`, `alamat`, `nomor_telepon`, `tanggal_lahir`) VALUES (:email, :password, :nama, :role, :jenis_kelamin, :alamat, :nomor_telepon, :tanggal_lahir)";
                    //prepare the sql statement for execution
                    $stmt = $this->db->prepare($sql);
                    // bind all placeholders to the actual values
                    $stmt->bindparam(':email',$email);
                    $stmt->bindparam(':password',$new_password);
                    $stmt->bindparam(':nama',$nama);
                    $stmt->bindparam(':role',$role);
                    $stmt->bindparam(':jenis_kelamin',$jenis_kelamin);
                    $stmt->bindparam(':alamat',$alamat);
                    $stmt->bindparam(':nomor_telepon',$nomor_telepon);
                    $stmt->bindparam(':tanggal_lahir',$tanggal_lahir);

                    // execute statement
                    $stmt->execute();
                    return true;
                }        
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // untuk mengecek apakah di 
        public function getUser($email,$password){
            try{
                $sql = "SELECT * FROM pengguna WHERE email = :email AND password = :password ";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':email', $email);
                $stmt->bindparam(':password', $password);

                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
           }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // Menghitung jumlah user yang terdaftar
        public function getUserbyEmail($email){
            try{
                $sql = "select count(*) as num from pengguna where email = :email";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':email',$email);
            
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
            }catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
            }
        }

        // Untuk Edit User
        public function getUserbyId($id_pengguna){
            try{
                $sql = "SELECT * FROM pengguna WHERE id_pengguna = :id_pengguna AND role = 'volunteer'";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':id_pengguna',$id_pengguna);
            
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
            }catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
            }
        }

        public function updateUser($id_pengguna, $nama, $jenis_kelamin, $alamat, $nomor_telepon, $tanggal_lahir){
            try {
                $sql = "UPDATE `pengguna` SET `nama`= :nama, `jenis_kelamin`= :jenis_kelamin, `alamat`= :alamat, `nomor_telepon`= :nomor_telepon, `tanggal_lahir`= :tanggal_lahir WHERE id_pengguna = :id_pengguna";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':id_pengguna', $id_pengguna);
                $stmt->bindparam(':nama', $nama);
                $stmt->bindparam(':jenis_kelamin', $jenis_kelamin);
                $stmt->bindparam(':alamat', $alamat);
                $stmt->bindparam(':nomor_telepon', $nomor_telepon);
                $stmt->bindparam(':tanggal_lahir', $tanggal_lahir);

                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }
    }
?>