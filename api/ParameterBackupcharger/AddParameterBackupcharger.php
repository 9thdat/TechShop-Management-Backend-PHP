<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/ParameterBackupcharger.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterBackupcharger = new ParameterBackupcharger($db);

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
    if (!empty($data->PRODUCT_ID) /* Add other required fields here */) {
        // Set ParameterBackupcharger properties
        $parameterBackupcharger->setPRODUCT_ID($data->PRODUCT_ID);
        $parameterBackupcharger->setEFFICIENCY($data->EFFICIENCY);
        $parameterBackupcharger->setCAPACITY($data->CAPACITY);
        $parameterBackupcharger->setTIMEFULLCHARGE($data->TIMEFULLCHARGE);
        $parameterBackupcharger->setINPUT($data->INPUT);
        $parameterBackupcharger->setOUTPUT($data->OUTPUT);
        $parameterBackupcharger->setCORE($data->CORE);
        $parameterBackupcharger->setTECH($data->TECH);
        $parameterBackupcharger->setSIZE($data->SIZE);
        $parameterBackupcharger->setWEIGHT($data->WEIGHT);
        $parameterBackupcharger->setMADEIN($data->MADEIN);
        $parameterBackupcharger->setBRANDOF($data->BRANDOF);
        $parameterBackupcharger->setBRAND($data->BRAND);

        // Create the ParameterBackupcharger
        if ($parameterBackupcharger->addParameterBackupcharger($data)) {
            echo json_encode(['status' => 200, 'message' => 'ParameterBackupcharger created successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to create ParameterBackupcharger.']);
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
