<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/ProductQuantity.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$productQuantity = new ProductQuantity($db);

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

    // Get data from the request
    $data = json_decode(file_get_contents("php://input"));

    // Check if data is not empty
    if (!empty($data->id) && !empty($data->color) && isset($data->quantity)) {
        // Update product quantity
        $result = $productQuantity->updateProductQuantity($data->id, $data);

        // Return JSON response
        echo json_encode($result, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Incomplete data. Please provide all required fields.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
