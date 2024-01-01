<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/ParameterAdapter.php';
include_once '../../model/User.php'; // Assuming you have a User class for token validation

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterAdapter = new ParameterAdapter($db);

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
        !empty($data->productId)
    ) {
        // Set parameter adapter properties
        $parameterAdapter->setPRODUCT_ID($data->productId);
        $parameterAdapter->setModel($data->model);
        $parameterAdapter->setFunction($data->function);
        $parameterAdapter->setInput($data->input);
        $parameterAdapter->setOutput($data->output);
        $parameterAdapter->setMaximum($data->maximum);
        $parameterAdapter->setSize($data->size);
        $parameterAdapter->setTech($data->tech);
        $parameterAdapter->setMadeIn($data->madein);
        $parameterAdapter->setBrandOf($data->brandof);
        $parameterAdapter->setBrand($data->brand);

        // Create the parameter adapter
        if ($parameterAdapter->addParameterAdapter($parameterAdapter)) {
            echo json_encode(['status' => 204, 'message' => 'Parameter adapter created successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to create parameter adapter.']);
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
