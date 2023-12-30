<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/ParameterCable.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterCable = new ParameterCable($db);

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
    if (!empty($data->PRODUCT_ID) && !empty($data->TECH) && !empty($data->FUNCTION) /* Add other required fields here */) {
        // Set parameterCable properties
        $parameterCable->setPRODUCT_ID($data->PRODUCT_ID);
        $parameterCable->setTECH($data->TECH);
        $parameterCable->setFUNCTION($data->FUNCTION);
        $parameterCable->setINPUT($data->INPUT);
        $parameterCable->setOUTPUT($data->OUTPUT);
        $parameterCable->setLENGTH($data->LENGTH);
        $parameterCable->setMAXIMUM($data->MAXIMUM);
        $parameterCable->setMADEIN($data->MADEIN);
        $parameterCable->setBRANDOF($data->BRANDOF);
        $parameterCable->setBRAND($data->BRAND);

        // Create the parameterCable
        if ($parameterCable->addParameterCable($data)) {
            echo json_encode(['status' => 200, 'message' => 'ParameterCable created successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to create ParameterCable.']);
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
