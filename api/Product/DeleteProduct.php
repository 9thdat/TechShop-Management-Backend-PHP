<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/Product.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$product = new Product($db);

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

    // Get product ID from the URL
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    // Delete the product
    if ($product->deleteProduct($id)) {
        echo json_encode(['status' => 200, 'message' => 'Product deleted successfully.']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Unable to delete product.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
