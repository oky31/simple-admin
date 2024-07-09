<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/Users.php';

$database = new Database();
$db = $database->getConnection();
$data = json_decode(file_get_contents("php://input"));

session_start();

$user = new Users($db);
$user->email = $data->email;
$user->password = $data->password;

if ($user->prosesLogin()) {
    $data = $user->prosesLogin();
    $_SESSION['user'] = $data;
    http_response_code(200);
    echo json_encode($_SESSION['user']);

} else {
    http_response_code(422);
    echo json_encode("Incorrect Email and Password!");
}
