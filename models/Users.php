<?php
class Users
{
    // Connection
    private $conn;

    // Table
    private $db_table = "users";

    // Columns
    public $id;
    public $nama_lengkap;
    public $email;
    public $password;
    public $foto;
    public $pekerjaan;
    public $posisi;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getUsers()
    {
        $sqlQuery = "SELECT id, nama_lengkap, email, password, foto, pekerjaan, posisi FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);         
        $stmt->execute();
        return $stmt;
    }

    public function getSingleUser()
    {
        $sqlQuery = "
        SELECT id, nama_lengkap, email, password, foto, pekerjaan,posisi        
        FROM " . $this->db_table . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nama_lengkap = $dataRow['nama_lengkap'];
        $this->email        = $dataRow['email'];
        $this->password     = $dataRow['password'];
        $this->foto         = $dataRow['foto'];
        $this->pekerjaan    = $dataRow['pekerjaan'];
        $this->posisi       = $dataRow['posisi'];
    }

    public function prosesLogin()
    {
        $sqlQuery = "
        SELECT 
            id, nama_lengkap, email,
            password, foto, pekerjaan, 
            posisi 
        FROM " . $this->db_table . " 
        WHERE email = :email AND password = :password
        LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($dataRow)) {
            return $dataRow;
        } else {
            return false;
        }
    }

    public function prosesLogout()
    {
        session_start();
        session_unset();
        session_destroy();
        return true;
    }
}
