<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Respond to preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);

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

    // Get the email parameter from the URL
    $email = isset($_GET['email']) ? $_GET['email'] : null;

    if (!$email) {
        // Email parameter is missing
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Email parameter is missing']);
        exit();
    }

    // Proceed to check if the staff email is valid
    $result = $user->IsEmailStaffExist($email);

    // Return the result as JSON
    echo json_encode($result, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>
