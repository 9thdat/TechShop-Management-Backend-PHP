<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

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
    if (!$token || !$user->validateToken($token)) {
        // Invalid or missing token
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
        exit();
    }

    // Get email from the URL parameter
    $email = $_GET['email'] ?? null;
    $data = json_decode(file_get_contents("php://input"));

    if (!$email) {
        echo json_encode(['status' => 400, 'message' => 'Email parameter is required']);
        exit();
    }

    // Set email and password properties
    $user->setEMAIL($email);
    $user->setPASSWORD($data->password);

    // Check if password is provided
    if (!$user->getPASSWORD()) {
        echo json_encode(['status' => 400, 'message' => 'Password is required']);
        exit();
    }

    // Change the password
    if ($user->changePassword()) {
        echo json_encode(['status' => 200, 'message' => 'Password changed successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Unable to change password']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
