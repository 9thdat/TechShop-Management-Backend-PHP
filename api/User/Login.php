<?php

header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        $response = $user->validateUser($data);

        echo $response;
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
