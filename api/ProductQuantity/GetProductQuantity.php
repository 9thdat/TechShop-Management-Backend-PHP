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

    if (!isset($_GET['productId'])) {
        // No product ID specified
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Bad Request: No product ID specified']);
        exit();
    }

    // Get the product ID from the URL
    $productId = $_GET['productId'];

    // Get product quantity data
    $quantity_stmt = $productQuantity->getProductQuantity($productId);
    $num = $quantity_stmt->rowCount();

    if ($num > 0) {
        $quantity_rows = $quantity_stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $quantity_rows = [];
    }

    if ($num > 0) {
        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => 'OK', 'data' => $quantity_rows]);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 404, 'message' => 'Not Found']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
