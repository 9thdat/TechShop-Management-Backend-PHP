<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST');
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
    $decodedToken = $user->validateToken($token);

    if ($decodedToken !== false) {
        // Token is valid, return the decoded claims
        http_response_code(200);

        echo json_encode(['status' => 200, 'data' => $decodedToken]);
    } else {
        // Invalid token
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>
