<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/OrderDetail.php';

$database = new db();
$db = $database->connect();

$orderDetail = new OrderDetail($db);

try {
    // Get the last order detail ID
    $lastId = $orderDetail->getLastId();

    if ($lastId) {
        echo json_encode(['status' => 200, 'data' => $lastId], JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['status' => 404, 'message' => 'No order detail found']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
