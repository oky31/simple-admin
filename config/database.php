<?php
class Database
{
    private $host = "127.0.0.1"; //domain
    private $database_name = "portofolio"; //nama database
    private $username = "oky31";
    private $password = "susilo123";
    public  $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $dsn = "mysql:host=$this->host;port=33060;dbname=$this->database_name";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->exec("set names utf8");

        } catch (PDOException $exception) {
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
