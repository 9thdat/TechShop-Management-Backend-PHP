<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/Order.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$order = new Order($db);

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

    // Get the order ID from the URL
    $orderId = isset($_GET['id']) ? $_GET['id'] : die();

    // Proceed to fetch the order by ID
    $orderData = $order->getOrderById($orderId);

    // Return a JSON response with the order data
    echo json_encode($orderData, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
