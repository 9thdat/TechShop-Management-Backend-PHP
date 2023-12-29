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

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    // Check if data is not empty
    if (!empty($data->customerEmail) && !empty($data->name) /* Add other required fields here */) {
        // Set order properties
        $order->setID($data->id);
        $order->setCUSTOMER_EMAIL($data->customerEmail);
        $order->setNAME($data->name);
        $order->setAddress($data->address);
        $order->setWard($data->ward);
        $order->setDistrict($data->district);
        $order->setCity($data->city);
        $order->setPhone($data->phone);
        $order->setDISCOUNT_ID($data->discountId);
        $order->setSHIPPING_FEE($data->shippingFee);
        $order->setTOTAL_PRICE($data->totalPrice);
        $order->setNote($data->note);
        $order->setORDER_DATE($data->orderDate);
        $order->setCANCELED_DATE($data->canceledDate);
        $order->setCOMPLETED_DATE($data->completedDate);
        $order->setDELIVERY_TYPE($data->deliveryType);
        $order->setPAYMENT_TYPE($data->paymentType);
        $order->setStatus($data->status);

        // Create the order
        if ($order->addOrder($data)) {
            echo json_encode(['status' => 200, 'message' => 'Order created successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to create order.']);
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
