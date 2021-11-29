<?php
class user
{
    // private database object\
    private $db;

    //constructor to initialize private variable to the database connection
    function __construct($conn)
    {
        $this->db = $conn;
    }

    // Dipakai untuk 
    public function insertUser($email, $password, $nama, $role, $alamat, $nomor_telepon)
    {
        try {
            $result = $this->getUserbyEmail($email);
            if ($result['num'] > 0) {
                return false;
            } else {
                $new_password = md5($password . $email);
                // define sql statement to be executed
                $sql = "INSERT INTO pengguna (`email`, `password`, `nama`, `alamat`, `nomor_telepon`, `role`) VALUES (:email, :password, :nama, :alamat, :nomor_telepon, :role)";
                //prepare the sql statement for execution
                $stmt = $this->db->prepare($sql);
                // bind all placeholders to the actual values
                $stmt->bindparam(':email', $email);
                $stmt->bindparam(':password', $new_password);
                $stmt->bindparam(':nama', $nama);
                $stmt->bindparam(':alamat', $alamat);
                $stmt->bindparam(':nomor_telepon', $nomor_telepon);
                $stmt->bindparam(':role', $role);

                // execute statement
                $stmt->execute();
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getUserRelawanbyEmailAndPassword($email, $password)
    {
        try {
            $sql = "SELECT pengguna.id_pengguna, pengguna.email, pengguna.role,pengguna.nama,pengguna.alamat,
            pengguna.nomor_telepon, relawan.*
            FROM pengguna JOIN relawan ON pengguna.id_pengguna = relawan.id_pengguna
            WHERE email = :email AND password = :password ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':email', $email);
            $stmt->bindparam(':password', $password);

            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // untuk mengecek apakah di 
    public function getUser($email, $password)
    {
        try {
            $sql = "SELECT * FROM pengguna WHERE email = :email AND password = :password ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':email', $email);
            $stmt->bindparam(':password', $password);

            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // Menghitung jumlah user yang terdaftar
    public function getUserbyEmail($email)
    {
        try {
            $sql = "select count(*) as num from pengguna where email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':email', $email);

            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // Untuk Edit User
    public function getUserRelawanbyId($id_pengguna)
    {
        try {
            $sql = "SELECT * FROM pengguna JOIN relawan USING(id_pengguna) WHERE pengguna.id_pengguna = :id_pengguna";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id_pengguna', $id_pengguna);

            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateUserRelawan($id_pengguna, $nama, $jenis_kelamin, $alamat, $nomor_telepon, $tanggal_lahir)
    {
        try {
            $sqlRelawan = "UPDATE `relawan` SET `jenis_kelamin`= :jenis_kelamin, `tanggal_lahir`= :tanggal_lahir WHERE id_pengguna= :id_pengguna";
            $stmtRelawan = $this->db->prepare($sqlRelawan);
            $stmtRelawan->bindparam(':jenis_kelamin', $jenis_kelamin);
            $stmtRelawan->bindparam(':tanggal_lahir', $tanggal_lahir);
            $stmtRelawan->bindparam(':id_pengguna', $id_pengguna);

            $sql = "UPDATE `pengguna` SET `nama`= :nama, `alamat`= :alamat, `nomor_telepon`= :nomor_telepon WHERE id_pengguna= :id_pengguna";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':nama', $nama);
            $stmt->bindparam(':alamat', $alamat);
            $stmt->bindparam(':nomor_telepon', $nomor_telepon);
            $stmt->bindparam(':id_pengguna', $id_pengguna);

            if ($stmtRelawan->execute() && $stmt->execute()) {
                return true;
            };

            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function ubahPassword($id_pengguna, $email, $password_baru)
    {
        $password_encrypt = md5($password_baru . $email);
        try {
            $sql = "UPDATE pengguna SET password = :password_encrypt WHERE id_pengguna = :id_pengguna";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':password_encrypt', $password_encrypt);
            $stmt->bindparam(':id_pengguna', $id_pengguna);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
