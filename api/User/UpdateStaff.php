<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

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
    if (!empty($data->email)
    ) {
        // Set user properties
        $user->setEMAIL($data->email);
        $user->setNAME($data->name);
        $user->setPHONE($data->phone);
        $user->setADDRESS($data->address);
        $user->setGENDER($data->gender);
        $user->setBIRTHDAY($data->birthday);
        $user->setWARD($data->ward);
        $user->setDISTRICT($data->district);
        $user->setCITY($data->city);
        $user->setIMAGE(base64_decode($data->image));
        $user->setSTATUS($data->status);

        // Update the user
        if ($user->updateStaff()) {
            echo json_encode(['status' => 200, 'message' => 'Staff updated successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to update staff.']);
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
