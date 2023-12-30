<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
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
    if (
        !empty($data->EMAIL) &&
        !empty($data->NAME) &&
        !empty($data->PASSWORD) &&
        !empty($data->PHONE) &&
        !empty($data->GENDER) &&
        !empty($data->BIRTHDAY) &&
        !empty($data->ADDRESS) &&
        !empty($data->WARD) &&
        !empty($data->DISTRICT) &&
        !empty($data->CITY) &&
        !empty($data->ROLE) &&
        !empty($data->STATUS)
    ) {
        // Set user properties
        $user->setEMAIL($data->EMAIL);
        $user->setNAME($data->NAME);
        $user->setPASSWORD($data->PASSWORD);
        $user->setPHONE($data->PHONE);
        $user->setGENDER($data->GENDER);
        $user->setBIRTHDAY($data->BIRTHDAY);
        $user->setADDRESS($data->ADDRESS);
        $user->setWARD($data->WARD);
        $user->setDISTRICT($data->DISTRICT);
        $user->setCITY($data->CITY);
        $user->setROLE($data->ROLE);
        $user->setSTATUS($data->STATUS);

        // Create the staff
        if ($user->createStaff()) {
            echo json_encode(['status' => 201, 'message' => 'Staff created successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to create staff.']);
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