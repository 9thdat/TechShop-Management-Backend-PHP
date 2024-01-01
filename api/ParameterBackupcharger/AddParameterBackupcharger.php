<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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
    if (!empty($data->productId) /* Add other required fields here */) {
        // Set ParameterBackupcharger properties
        $parameterBackupcharger->setPRODUCT_ID($data->productId);
        $parameterBackupcharger->setEFFICIENCY($data->efficiency);
        $parameterBackupcharger->setCAPACITY($data->capacity);
        $parameterBackupcharger->setTIMEFULLCHARGE($data->timefullcharge);
        $parameterBackupcharger->setINPUT($data->input);
        $parameterBackupcharger->setOUTPUT($data->output);
        $parameterBackupcharger->setCORE($data->core);
        $parameterBackupcharger->setTECH($data->tech);
        $parameterBackupcharger->setSIZE($data->size);
        $parameterBackupcharger->setWEIGHT($data->weight);
        $parameterBackupcharger->setMADEIN($data->madein);
        $parameterBackupcharger->setBRANDOF($data->brandof);
        $parameterBackupcharger->setBRAND($data->brand);

        // Create the ParameterBackupcharger
        if ($parameterBackupcharger->addParameterBackupcharger($parameterBackupcharger)) {
            echo json_encode(['status' => 204, 'message' => 'ParameterBackupcharger created successfully.']);
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
