<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Respond to preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/Customer.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$customer = new Customer($db);

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

    // Get email from the URL parameters
    $email = isset($_GET['Email']) ? $_GET['Email'] : null;

    if ($email) {
        // Proceed to change the status
        if ($customer->changeStatus($email)) {
            echo json_encode(['status' => 200, 'message' => 'Status changed successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to change status.']);
        }
    } else {
        // Missing email parameter
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Email parameter is missing.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>
