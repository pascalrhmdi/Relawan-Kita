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

    public function insertAcara($judul_acara, $deskripsi_acara, $jumlah_kebutuhan, $tanggal_batas_registrasi, $tanggal_acara, $lokasi, $id_jenis_acara, $id_pengguna, $namaCover)
    {
        try {
            // define sql statement to be executed
            $sql = "INSERT INTO acara(judul_acara,deskripsi_acara, jumlah_kebutuhan, tanggal_batas_registrasi, tanggal_acara, lokasi, cover, id_jenis_acara, id_pengguna) VALUES (:judul_acara, :deskripsi_acara, :jumlah_kebutuhan, :tanggal_batas_registrasi, :tanggal_acara, :lokasi, :cover, :id_jenis_acara, :id_pengguna);";
            //prepare the sql statement for execution
            $stmt = $this->db->prepare($sql);
            // bind all placeholders to the actual values
            $stmt->bindparam(':judul_acara', $judul_acara);
            $stmt->bindparam(':deskripsi_acara', $deskripsi_acara);
            $stmt->bindparam(':jumlah_kebutuhan', $jumlah_kebutuhan);
            $stmt->bindparam(':tanggal_batas_registrasi', $tanggal_batas_registrasi);
            $stmt->bindparam(':tanggal_acara', $tanggal_acara);
            $stmt->bindparam(':lokasi', $lokasi);
            $stmt->bindparam(':cover', $namaCover);
            $stmt->bindparam(':id_jenis_acara', $id_jenis_acara);
            $stmt->bindparam(':id_pengguna', $id_pengguna);

            // execute statement
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // throw karena disana pakai try catch
            throw $e;
        }
    }

    public function insertOrganisasi($id_pengguna, $deskripsi_organisasi, $tahun_berdiri)
    {
        try {

            // define sql statement to be executed
            $sql = "INSERT INTO organisasi (`id_pengguna`, `deskripsi_organisasi`, `tahun_berdiri`) VALUES (:id_pengguna, :deskripsi_organisasi, :tahun_berdiri)";
            //prepare the sql statement for execution
            $stmt = $this->db->prepare($sql);
            // bind all placeholders to the actual values
            $stmt->bindparam(':id_pengguna', $id_pengguna);
            $stmt->bindparam(':deskripsi_organisasi', $deskripsi_organisasi);
            $stmt->bindparam(':tahun_berdiri', $tahun_berdiri);

            // execute statement
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function insertRelawan($id_pengguna, $jenis_kelamin, $tanggal_lahir)
    {
        try {
            // define sql statement to be executed
            $sql = "INSERT INTO relawan (`id_pengguna`, `jenis_kelamin`, `tanggal_lahir`) VALUES (:id_pengguna, :jenis_kelamin, :tanggal_lahir)";
            //prepare the sql statement for execution
            $stmt = $this->db->prepare($sql);
            // bind all placeholders to the actual values
            $stmt->bindparam(':id_pengguna', $id_pengguna);
            $stmt->bindparam(':jenis_kelamin', $jenis_kelamin);
            $stmt->bindparam(':tanggal_lahir', $tanggal_lahir);

            // execute statement
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // digunakan di bagian admin : list Organisasi
    public function getOrganisasiLimit($awalData, $menampilkanDataPerHalaman)
    {
        try {
            $sql = "SELECT * FROM pengguna JOIN organisasi USING(id_pengguna) 
                    LIMIT $awalData, $menampilkanDataPerHalaman";
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
            $sql = "SELECT acara.*,pengguna.nama,jenis_acara.nama_jenis_acara 
                    FROM acara JOIN pengguna USING(id_pengguna) 
                    JOIN jenis_acara USING(id_jenis_acara) ORDER BY acara.id_acara 
                    DESC LIMIT $awalData, $menampilkanDataPerHalaman";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getAcaraLimitOrdered($awalData, $menampilkanDataPerHalaman, $orderType)
    {
        try {
            $sql = "SELECT * FROM acara JOIN pengguna USING(id_pengguna)
                    JOIN jenis_acara USING(id_jenis_acara) ORDER BY acara.id_acara $orderType 
                    LIMIT $awalData, $menampilkanDataPerHalaman";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // digunakan di bagian admin : List Acara
    public function getAcaraLimitByOrganisasi($awalData, $menampilkanDataPerHalaman, $id_pengguna)
    {
        try {
            $sql = "SELECT * FROM acara LEFT JOIN organisasi USING(id_pengguna) LEFT JOIN jenis_acara USING(id_jenis_acara) WHERE id_pengguna = $id_pengguna LIMIT $awalData, $menampilkanDataPerHalaman";
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
            $sql = "SELECT * FROM pengguna LEFT JOIN relawan USING(id_pengguna)
                    WHERE role = 'volunteer' LIMIT $awalData, $menampilkanDataPerHalaman";
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
            JOIN pengguna p
                USING (id_pengguna) 
            JOIN jenis_acara j
                USING(id_jenis_acara) 
            WHERE 
            a.judul_acara LIKE '%$judul_acara%' AND
            a.lokasi LIKE '%$lokasi%' AND
            p.nama LIKE '%$nama%' AND
            j.nama_jenis_acara LIKE '%$nama_jenis_acara%'
            ORDER BY id_acara DESC
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
                    JOIN pengguna 
                        USING(id_pengguna) 
                    JOIN organisasi
                        USING(id_pengguna)
                    JOIN jenis_acara 
                        USING(id_jenis_acara)
                    WHERE id_acara = $id";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getDetailAcaraByIdAcaraDanIdPemilik($id_acara, $id_pemilik)
    {
        try {
            $sql = "SELECT acara.*,jenis_acara.nama_jenis_acara as kategori 
                    FROM acara JOIN jenis_acara USING(id_jenis_acara) WHERE acara.id_acara = $id_acara 
                    AND acara.id_pengguna = $id_pemilik";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getAccountOrganisasi($id_pengguna)
    {
        try {
            $sql = "SELECT * FROM organisasi
                    JOIN pengguna USING(id_pengguna)
                    WHERE pengguna.id_pengguna = :id_pengguna";
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

    public function getRiwayatPendaftaranRelawan($id_pengguna, $awalData, $dataPerHalaman){
        try {
            $sql = "SELECT status.status, acara.judul_acara, acara.lokasi, acara.id_acara, jenis_acara.nama_jenis_acara,
                    pengguna.nama AS nama_org FROM status JOIN acara USING(id_acara) 
                    JOIN jenis_acara USING(id_jenis_acara) JOIN pengguna ON acara.id_pengguna = pengguna.id_pengguna 
                    WHERE status.id_pengguna = :id_pengguna
                    LIMIT :awalData, :dataPerHalaman";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id_pengguna', $id_pengguna);
            $stmt->bindValue(':awalData', (int) $awalData, PDO::PARAM_INT);
            $stmt->bindValue(':dataPerHalaman', (int) $dataPerHalaman, PDO::PARAM_INT);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Throwable $e) {
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

    public function updateOrganisasi($id_pengguna, $deskripsi_organisasi, $tahun_berdiri, $nama, $alamat, $nomor_telepon)
    {
        try {
            $sql = "UPDATE `organisasi` SET `deskripsi_organisasi`= :deskripsi_organisasi, `tahun_berdiri`= :tahun_berdiri WHERE id_pengguna = :id_pengguna";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id_pengguna', $id_pengguna);
            $stmt->bindparam(':deskripsi_organisasi', $deskripsi_organisasi);
            $stmt->bindparam(':tahun_berdiri', $tahun_berdiri);
            
            $stmt->execute();
            
            $sqlPengguna = "UPDATE `pengguna` SET `nama`= :nama, `alamat`= :alamat, `nomor_telepon`= :nomor_telepon WHERE id_pengguna = :id_pengguna";
            $stmtPengguna = $this->db->prepare($sqlPengguna);
            $stmtPengguna->bindparam(':nama', $nama);
            $stmtPengguna->bindparam(':alamat', $alamat);
            $stmtPengguna->bindparam(':nomor_telepon', $nomor_telepon);
            $stmtPengguna->bindparam(':id_pengguna', $id_pengguna);

            $stmtPengguna->execute();
            
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateAcara($id_acara, $judul_acara, $deskripsi_acara, $jumlah_kebutuhan, $tanggal_batas_registrasi, $tanggal_acara, $lokasi, $id_jenis_acara, $namaCover, $id_pengguna)
    {
        try {
            $sql = "UPDATE `acara` SET `judul_acara`= :judul_acara, `deskripsi_acara`= :deskripsi_acara, `jumlah_kebutuhan`= :jumlah_kebutuhan, 
            `tanggal_batas_registrasi`= :tanggal_batas_registrasi, `tanggal_acara`= :tanggal_acara, `lokasi`= :lokasi, `cover`= :cover, `id_jenis_acara`= :id_jenis_acara WHERE id_acara = :id_acara AND id_pengguna = :id_pengguna";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id_acara', $id_acara);
            $stmt->bindparam(':judul_acara', $judul_acara);
            $stmt->bindparam(':deskripsi_acara', $deskripsi_acara);
            $stmt->bindparam(':jumlah_kebutuhan', $jumlah_kebutuhan);
            $stmt->bindparam(':tanggal_batas_registrasi', $tanggal_batas_registrasi);
            $stmt->bindparam(':tanggal_acara', $tanggal_acara);
            $stmt->bindparam(':lokasi', $lokasi);
            $stmt->bindparam(':cover', $namaCover);
            $stmt->bindparam(':id_jenis_acara', $id_jenis_acara);
            $stmt->bindparam(':id_pengguna', $id_pengguna);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateJenisAcara($id_jenis_acara, $nama_jenis_acara)
    {
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

    public function updateStatus($id_pengguna, $id_acara, $status)
    {
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
            $sql = "CALL deleteRelawan(:id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // function for admin
    public function deleteOrganisasi($id)
    {
        try {
            $sql = "CALL deleteOrganisasi(:id)";
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
