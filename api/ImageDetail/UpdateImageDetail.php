<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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

    // Get the ID from the URL
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get the posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set image detail properties
    $imageDetail->setPRODUCT_ID($data->PRODUCT_ID);
    $imageDetail->setColor($data->COLOR);
    $imageDetail->setOrdinal($data->ORDINAL);
    $imageDetail->setImage($data->IMAGE);

    // Update the image detail
    if ($imageDetail->updateImageDetail($id, $imageDetail)) {
        echo json_encode(['status' => 200, 'message' => 'Image detail updated successfully.']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Unable to update image detail.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
