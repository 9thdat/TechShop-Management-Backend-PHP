<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php'; // Adjust the path as needed
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
