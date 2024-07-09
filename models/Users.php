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

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
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
