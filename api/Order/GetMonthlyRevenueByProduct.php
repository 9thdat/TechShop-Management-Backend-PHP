<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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

    // Get parameters from the request
    $startMonth = $_GET['startMonth'];
    $startYear = $_GET['startYear'];
    $endMonth = $_GET['endMonth'];
    $endYear = $_GET['endYear'];
    $productId = isset($_GET['productId']) ? $_GET['productId'] : null;

    // Proceed to fetch monthly revenue by product
    $result = $order->getMonthlyRevenueByProduct($startMonth, $startYear, $endMonth, $endYear, $productId);

    // Return a JSON response with the result
    echo json_encode(['status' => 200, 'data' => $result], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>