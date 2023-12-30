<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // Check if data is not empty
    if (!empty($data->productId) && !empty($data->color) && isset($data->quantity) && isset($data->sold)) {
        // Set product quantity properties
        $productQuantity->setPRODUCT_ID($data->productId);
        $productQuantity->setCOLOR($data->color);
        $productQuantity->setQUANTITY($data->quantity);
        $productQuantity->setSOLD($data->sold);

        // Add the product quantity
        if ($productQuantity->addProductQuantity($data)) {
            echo json_encode(['status' => 201, 'message' => 'Product quantity created successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to create product quantity.']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => 'Incomplete data. Please provide all required fields.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
