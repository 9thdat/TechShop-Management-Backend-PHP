<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php';
include_once '../../model/OrderDetail.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$orderDetail = new OrderDetail($db);

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
    if (!empty($data->OrderId) && !empty($data->ProductId) && !empty($data->Color) && isset($data->Quantity) && isset($data->Price)) {
        // Set order detail properties and create order detail
        $result = $orderDetail->addOrderDetail($data);
        if ($result) {
            // Order detail created
            http_response_code(201);
            echo json_encode(['status' => 201, 'message' => 'Order detail created successfully']);
        } else {
            // Failed to create order detail
            http_response_code(500);
            echo json_encode(['status' => 500, 'message' => 'Failed to create order detail']);
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
