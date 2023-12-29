<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/ImageDetail.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$imageDetail = new ImageDetail($db);

try {
    // Get the token from the headers
    $allHeaders = getallheaders();
    $token = $allHeaders['Authorization'];

    // Validate the token
    if (!$token || !$user->validateToken($token)) {
        // Invalid or missing token
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
        exit();
    }

    // Get posted data
    $data = json_decode(file_get_contents("php://input"), true);

    // Add image detail
    if ($imageDetail->addImageDetail($data)) {
        echo json_encode(['status' => 204, 'message' => 'Image detail added successfully.']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Unable to add image detail.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
