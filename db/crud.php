<?php
class crud
{
    // private database object
    private $db;

    //constructor to initialize private variable to the database connection
    function __construct($conn)
    {
        $this->db = $conn;
    }

    // Insert untuk menjadikan volunteer di sebuah acara (statusnya auto 'menunggu')
    public function insertStatus($id_pengguna, $id_acara)
    {
        try {
            // define sql statement to be executed
            $sql = "INSERT INTO status(id_pengguna,id_acara) VALUES (:id_pengguna, :id_acara);";
            //prepare the sql statement for execution
            $stmt = $this->db->prepare($sql);
            // bind all placeholders to the actual values
            $stmt->bindparam(':id_pengguna', $id_pengguna);
            $stmt->bindparam(':id_acara', $id_acara);

            // execute statement
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // throw karena disana pakai try catch
            throw $e;
        }
    }

    public function insertAcara($judul_acara, $deskripsi_acara, $jumlah_kebutuhan, $tanggal_batas_registrasi, $tanggal_acara, $lokasi, $id_jenis_acara, $id_organisasi)
    {
        try {
            // define sql statement to be executed
            $sql = "INSERT INTO acara(judul_acara,deskripsi_acara, jumlah_kebutuhan, tanggal_batas_registrasi, tanggal_acara, lokasi, id_jenis_acara, id_organisasi) VALUES (:judul_acara, :deskripsi_acara, :jumlah_kebutuhan, :tanggal_batas_registrasi, :tanggal_acara, :lokasi, :id_jenis_acara, :id_organisasi);";
            //prepare the sql statement for execution
            $stmt = $this->db->prepare($sql);
            // bind all placeholders to the actual values
            $stmt->bindparam(':judul_acara', $judul_acara);
            $stmt->bindparam(':deskripsi_acara', $deskripsi_acara);
            $stmt->bindparam(':jumlah_kebutuhan', $jumlah_kebutuhan);
            $stmt->bindparam(':tanggal_batas_registrasi', $tanggal_batas_registrasi);
            $stmt->bindparam(':tanggal_acara', $tanggal_acara);
            $stmt->bindparam(':lokasi', $lokasi);
            $stmt->bindparam(':id_jenis_acara', $id_jenis_acara);
            $stmt->bindparam(':id_organisasi', $id_organisasi);

            // execute statement
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // throw karena disana pakai try catch
            throw $e;
        }
    }

    public function insertOrganisasi($email, $password, $role, $nama, $deskripsi_organisasi, $tahun_berdiri)
    {
        try {
            $result = $this->getTotalOrganisasibyEmail($email);
            if ($result > 0) {
                return false;
            } else {
                // define sql statement to be executed
                $sql = "INSERT INTO organisasi (`email`, `password`, `role`, `nama`, `deskripsi_organisasi`, `tahun_berdiri`) VALUES (:email, :password, :role, :nama, :deskripsi_organisasi, :tahun_berdiri)";
                //prepare the sql statement for execution
                $stmt = $this->db->prepare($sql);
                // bind all placeholders to the actual values
                $stmt->bindparam(':email', $email);
                $stmt->bindparam(':password', $password);
                $stmt->bindparam(':role', $role);
                $stmt->bindparam(':nama', $nama);
                $stmt->bindparam(':deskripsi_organisasi', $deskripsi_organisasi);
                $stmt->bindparam(':tahun_berdiri', $tahun_berdiri);

                // execute statement
                $stmt->execute();
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // digunakan di bagian admin : list Organisasi
    public function getOrganisasiLimit($awalData, $menampilkanDataPerHalaman)
    {
        try {
            $sql = "SELECT * FROM organisasi LIMIT $awalData, $menampilkanDataPerHalaman";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // digunakan di bagian cariAktivias : List Acara
    public function getAcaraLimit($awalData, $menampilkanDataPerHalaman)
    {
        try {
            $sql = "SELECT * FROM acara LEFT JOIN organisasi USING(id_organisasi) LEFT JOIN jenis_acara USING(id_jenis_acara) LIMIT $awalData, $menampilkanDataPerHalaman";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    // digunakan di bagian admin : List Acara
    public function getAcaraLimitByOrganisasi($awalData, $menampilkanDataPerHalaman, $id_organisasi)
    {
        try {
            $sql = "SELECT * FROM acara LEFT JOIN organisasi USING(id_organisasi) LEFT JOIN jenis_acara USING(id_jenis_acara) WHERE id_organisasi = $id_organisasi LIMIT $awalData, $menampilkanDataPerHalaman";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // digunakan di bagian admin : list Jenis Acara
    public function getJenisAcaraLimit($awalData, $menampilkanDataPerHalaman)
    {
        try {
            // Call Procedure MYSQL
            $sql = "CALL getJenisAcara($awalData, $menampilkanDataPerHalaman)";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // digunakan di bagian admin : list User
    public function getUsersLimit($awalData, $menampilkanDataPerHalaman)
    {
        try {
            $sql = "SELECT * FROM pengguna WHERE role != 'admin' LIMIT $awalData, $menampilkanDataPerHalaman";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getAcaraFiltered($awalData, $menampilkanDataPerHalaman, $judul_acara, $nama, $lokasi, $nama_jenis_acara)
    {
        try {
            $sql = "SELECT * FROM acara a
            LEFT JOIN organisasi o
                USING (id_organisasi) 
            LEFT JOIN jenis_acara j
                USING(id_jenis_acara) 
            WHERE 
            a.judul_acara LIKE '%$judul_acara%' AND
            a.lokasi LIKE '%$lokasi%' AND
            o.nama LIKE '%$nama%' AND
            j.nama_jenis_acara LIKE '%$nama_jenis_acara%'
                LIMIT $awalData, $menampilkanDataPerHalaman";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // digunakan untuk melihat acara dengan id.
    // sekaligus mengambil data apakah terdapat 
    public function getAcaraById($id)
    {
        try {
            $sql = "SELECT * FROM acara 
                    LEFT JOIN organisasi 
                        USING(id_organisasi) 
                    LEFT JOIN jenis_acara 
                        USING(id_jenis_acara)
                    WHERE id_acara = $id";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getTotalOrganisasibyEmail($email)
    {
        try {
            $sql = "SELECT COUNT(*) AS num FROM organisasi WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':email', $email);

            $stmt->execute();
            $result = $stmt->fetch();
            return $result['num'];
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getAccountOrganisasi($email, $password)
    {
        try {
            $sql = "SELECT * FROM organisasi WHERE email = :email AND password = :password ";
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

    public function deleteJenisAcara($id)
    {
        try {
            $sql = "DELETE FROM jenis_acara where id_jenis_acara = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateOrganisasi($id_organisasi, $nama, $deskripsi_organisasi, $tahun_berdiri){
        try {
            $sql = "UPDATE `organisasi` SET `nama`= :nama, `deskripsi_organisasi`= :deskripsi_organisasi, `tahun_berdiri`= :tahun_berdiri WHERE id_organisasi = :id_organisasi";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id_organisasi', $id_organisasi);
            $stmt->bindparam(':nama', $nama);
            $stmt->bindparam(':deskripsi_organisasi', $deskripsi_organisasi);
            $stmt->bindparam(':tahun_berdiri', $tahun_berdiri);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
   
    public function updateJenisAcara($id_jenis_acara, $nama_jenis_acara){
        try {
            $sql = "UPDATE `jenis_acara` SET `nama_jenis_acara`= :nama_jenis_acara WHERE id_jenis_acara = :id_jenis_acara";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id_jenis_acara', $id_jenis_acara);
            $stmt->bindparam(':nama_jenis_acara', $nama_jenis_acara);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateStatus($id_pengguna, $id_acara, $status){
        try {
            $sql = "UPDATE `status` SET `status`= :status WHERE id_pengguna = :id_pengguna AND id_acara = :id_acara";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id_pengguna', $id_pengguna);
            $stmt->bindparam(':id_acara', $id_acara);
            $stmt->bindparam(':status', $status);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function deleteUser($id)
    {
        try {
            $sql = "DELETE FROM Pengguna where id_pengguna = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function deleteOrganisasi($id)
    {
        try {
            $sql = "DELETE FROM organisasi where id_organisasi = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function deleteAcara($id)
    {
        try {
            $sql = "CALL deleteAcara(:id)";
            // 
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}