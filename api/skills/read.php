<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/Skills.php';
session_start();

$database = new Database();
$db = $database->getConnection();

if (isset($_GET['id'])) {

    $skills = new Skills($db);
    $skills->id = isset($_GET['id']) ? $_GET['id'] : die();
    $skills->getSingleSkill();

    if ($skills->skillName != null) {
        $arrSkil = array(
            "id"           => $skills->id,
            "user_id"      => $skills->userId,
            "user_name"    => $skills->userName,
            "skill_name"   => $skills->skillName,
            "rating"       => $skills->rating,
            "description"  => $skills->description,
        );
        http_response_code(200);
        echo json_encode($emp_arr);
    } else {
        http_response_code(404);
        echo json_encode("User not found.");
    }
} else {
    
    $skills     = new Skills($db);
    $stmt       = $skills->getSkills();
    $skillCount = $stmt->rowCount();

    if ($skillCount > 0) {

        $skillsArr              = array();
        $skillsArr["body"]      = array();
        $skillsArr["itemCount"] = $skillCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "id"           => $id,
                "user_id"      => $user_id,
                "user_name"    => $user_name,
                "skill_name"   => $skill_name,
                "rating"       => $rating,
                "description"  => $description,
            );

            array_push($skillsArr["body"], $e);
        }

        echo json_encode($skillsArr);
    } else {
        http_response_code(404);
        echo json_encode(array("messstock" => "No record found."));
    }
}
