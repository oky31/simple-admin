<?php

class Skills
{

    private $conn;

    public $id;
    public $userId;
    public $userName;
    public $skillName;
    public $rating;
    public $description;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getSkills()
    {
        $query = "
            SELECT 
                skills.id,
                skills.user_id as user_id,
                users.nama_lengkap as user_name,
                skills.skill_name,
                skills.rating,
                skills.description
            FROM skills
                JOIN users ON skills.user_id = users.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getSingleSkill()
    {
        $query = "
            SELECT 
                skills.id,
                skills.user_id as user_id,
                users.nama_lengkap as user_name,
                skills.skill_name,
                skills.rating,
                skills.description
            FROM skills
                JOIN users ON skills.user_id = users.id
            WHERE skills.id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->userId      = $dataRow['user_id'];
        $this->userName    = $dataRow['user_name'];
        $this->skillName   = $dataRow['skills_name'];
        $this->rating      = $dataRow['rating'];
        $this->description = $dataRow['description'];
    }
}
