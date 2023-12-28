<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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

    // Check if the required data is provided
    $data = json_decode(file_get_contents("php://input"), true);

    // Assuming that 'email' is a required field
    if (!empty($data['email'])) {
        $email = $data['email'];

        // Proceed to get Customer by email
        $customerData = $customer->GetCustomerByEmail($email);

        // Return a JSON response with the Customer data
        echo json_encode($customerData, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Email is required.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
