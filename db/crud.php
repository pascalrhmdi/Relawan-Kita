<?php 
    class crud{
        // private database object
        private $db;
        
        //constructor to initialize private variable to the database connection
        function __construct($conn){
            $this->db = $conn;
        }
        
        // function to insert a new record into the attendee database
        // public function insertAttendees($fname, $lname, $dob, $email,$contact,$specialty,$avatar_path){
        //     try {
        //         // define sql statement to be executed
        //         $sql = "INSERT INTO attendee (firstname,lastname,dateofbirth,emailaddress,contactnumber,specialty_id,avatar_path) VALUES (:fname,:lname,:dob,:email,:contact,:specialty,:avatar_path)";
        //         //prepare the sql statement for execution
        //         $stmt = $this->db->prepare($sql);
        //         // bind all placeholders to the actual values
        //         $stmt->bindparam(':fname',$fname);
        //         $stmt->bindparam(':lname',$lname);
        //         $stmt->bindparam(':dob',$dob);
        //         $stmt->bindparam(':email',$email);
        //         $stmt->bindparam(':contact',$contact);
        //         $stmt->bindparam(':specialty',$specialty);
        //         $stmt->bindparam(':avatar_path',$avatar_path);

        //         // execute statement
        //         $stmt->execute();
        //         return true;
        
        //     } catch (PDOException $e) {
        //         echo $e->getMessage();
        //         return false;
        //     }
        // }

        // Insert untuk menjadikan volunteer di sebuah acara (statusnya auto 'menunggu')
        public function insertStatus ($id_pengguna, $id_acara){
            try {
                // define sql statement to be executed
                $sql = "INSERT INTO status(id_pengguna,id_acara) VALUES (:id_pengguna, :id_acara);";
                //prepare the sql statement for execution
                $stmt = $this->db->prepare($sql);
                // bind all placeholders to the actual values
                $stmt->bindparam(':id_pengguna',$id_pengguna);
                $stmt->bindparam(':id_acara',$id_acara);

                // execute statement
                $stmt->execute();
                return true;
        
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // public function editAttendee($id,$fname, $lname, $dob, $email,$contact,$specialty){
        //    try{ 
        //         $sql = "UPDATE `attendee` SET `firstname`=:fname,`lastname`=:lname,`dateofbirth`=:dob,`emailaddress`=:email,`contactnumber`=:contact,`specialty_id`=:specialty WHERE attendee_id = :id ";
        //         $stmt = $this->db->prepare($sql);
        //         // bind all placeholders to the actual values
        //         $stmt->bindparam(':id',$id);
        //         $stmt->bindparam(':fname',$fname);
        //         $stmt->bindparam(':lname',$lname);
        //         $stmt->bindparam(':dob',$dob);
        //         $stmt->bindparam(':email',$email);
        //         $stmt->bindparam(':contact',$contact);
        //         $stmt->bindparam(':specialty',$specialty);

        //         // execute statement
        //         $stmt->execute();
        //         return true;
        //    }catch (PDOException $e) {
        //     echo $e->getMessage();
        //     return false;
        //    }
        // }

        // digunakan di bagian admin : list Organisasi
        public function getOrganisasi($awalData, $menampilkanDataPerHalaman){
            try{
                $sql = "SELECT * FROM organisasi LIMIT $awalData, $menampilkanDataPerHalaman";
                $result = $this->db->query($sql);
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
           }
        }
        
        // digunakan di bagian admin : List Acara
        public function getAcara($awalData, $menampilkanDataPerHalaman){
            try{
                $sql = "SELECT * FROM acara LEFT JOIN organisasi USING(id_organisasi) LEFT JOIN jenis_acara USING(id_jenis_acara) LIMIT $awalData, $menampilkanDataPerHalaman";
                $result = $this->db->query($sql);
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
           }
        }
        
        public function getAcaraFiltered($awalData, $menampilkanDataPerHalaman, $judul_acara, $lokasi, $nama_jenis_acara){
            try{
                $sql = "SELECT * FROM acara 
                LEFT JOIN organisasi 
                    USING (id_organisasi) 
                LEFT JOIN jenis_acara 
                    USING(id_jenis_acara) 
                WHERE 
                    judul_acara LIKE '%$judul_acara%' OR
                    lokasi LIKE '%$lokasi%'OR
                    nama_jenis_acara LIKE '%$nama_jenis_acara%'
                LIMIT $awalData, $menampilkanDataPerHalaman";
                $result = $this->db->query($sql);
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
           }
        }

        // digunakan untuk melihat acara dengan id.
        // sekaligus mengambil data apakah terdapat 
        public function getAcaraById($id){
            try{
                $sql = "SELECT * FROM acara 
                    LEFT JOIN organisasi 
                        USING(id_organisasi) 
                    LEFT JOIN jenis_acara 
                        USING(id_jenis_acara)
                    WHERE id_acara = $id";
                $result = $this->db->query($sql);
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
           }
        }
        
        // digunakan di bagian admin : list Jenis Acara
        public function getJenisAcara($awalData, $menampilkanDataPerHalaman){
            try{
                $sql = "CALL getJenisAcara($awalData, $menampilkanDataPerHalaman)";
                $result = $this->db->query($sql);
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
           }
        }

        // digunakan di bagian admin : list User
        public function getUsers($awalData, $menampilkanDataPerHalaman){
            try{
                $sql = "SELECT * FROM pengguna WHERE role != 'admin' LIMIT $awalData, $menampilkanDataPerHalaman";
                $result = $this->db->query($sql);
                return $result;
            }catch(PDOException $e){
                echo $e->getMessage();
                return false;
            }
        }

        public function getAttendeeDetails($id){
           try{
                $sql = "select * from attendee a inner join specialties s on a.specialty_id = s.specialty_id 
                where attendee_id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
           }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function deleteJenisAcara($id){
           try{
                $sql = "DELETE FROM jenis_acara where id_jenis_acara = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':id', $id);
                $stmt->execute();
                return true;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }
        
        public function deleteUser($id){
           try{
                $sql = "DELETE FROM Pengguna where id_pengguna = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':id', $id);
                $stmt->execute();
                return true;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function deleteOrganisasi($id){
           try{
                $sql = "DELETE FROM organisasi where id_organisasi = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':id', $id);
                $stmt->execute();
                return true;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function deleteAcara($id){
           try{
                $sql = "CALL deleteAcara(:id)";
                // 
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':id', $id);
                $stmt->execute();
                return true;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function getSpecialties(){
            try{
                $sql = "SELECT * FROM `specialties`";
                $result = $this->db->query($sql);
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function getSpecialtyById($id){
            try{
                $sql = "SELECT * FROM `specialties` where specialty_id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
            
        }


        

    }
?>