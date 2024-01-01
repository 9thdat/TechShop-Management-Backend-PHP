<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: DELETE');
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

    // Get the image detail ID from the URL parameters
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    // Proceed to delete the image detail
    $result = $imageDetail->deleteImageDetail($id);

    // Return a JSON response based on the result
    http_response_code($result['status']);
    echo json_encode(['status' => $result['status'], 'message' => $result['message']]);
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
