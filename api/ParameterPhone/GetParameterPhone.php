<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/ParameterPhone.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterPhone = new ParameterPhone($db);

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

    // Get the product ID from the URL
    $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : null;

    if ($productId !== null) {
        // Fetch parameter phones by product ID
        $result = $parameterPhone->GetParameterPhone($productId);

        // Return the result as JSON
        echo json_encode($result, JSON_PRETTY_PRINT);
    } else {
        // Product ID is missing
        echo json_encode(['status' => 400, 'message' => 'Product ID is required']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
