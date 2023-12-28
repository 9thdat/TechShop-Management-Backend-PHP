<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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
