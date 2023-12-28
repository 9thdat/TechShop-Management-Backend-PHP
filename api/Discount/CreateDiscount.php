<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php';  // Adjust the path as needed
include_once '../../model/Discount.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$discount = new Discount($db);

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
    $data = json_decode(file_get_contents("php://input"), true);

    // Set Discount properties
    $discount->setID($data['id']);
    $discount->setCode($data['code']);
    $discount->setTYPE($data['type']);
    $discount->setValue($data['value']);
    $discount->setDESCRIPTION($data['description']);
    $discount->setSTART_DATE($data['startDate']);
    $discount->setEND_DATE($data['endDate']);
    $discount->setMIN_APPLY($data['minApply']);
    $discount->setMAX_SPEED($data['maxSpeed']);
    $discount->setQUANTITY($data['quantity']);
    $discount->setSTATUS($data['status']);
    $discount->setCREATED_AT($data['createdAt']);
    $discount->setDISABLED_AT($data['updatedAt']);
    $discount->setDISABLED_AT($data['disabledAt']);


    // Get current date
    $currentDate = date('Y-m-d H:i:s');
    if ($discount->getSTATUS() !== 'inactive') {
        if ($discount->getEND_DATE() < $currentDate) {
            $discount->setStatus('expired');
        } else {
            $discount->setStatus('active');
        }
    } else {
        $discount->setDISABLED_AT($discount->getEND_DATE());
    }

    // Create the Discount
    if ($discount->createDiscount($data)) {
        echo json_encode(['status' => 201, 'message' => 'Discount created successfully.']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Unable to create Discount.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
