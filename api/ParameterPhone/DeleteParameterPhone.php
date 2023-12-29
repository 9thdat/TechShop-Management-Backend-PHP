<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/ParameterPhone.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterPhone = new ParameterPhone($db);

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

    // Get the parameter phone ID from the URL
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    // Attempt to delete the parameter phone
    if ($parameterPhone->deleteParameterPhone($id)) {
        echo json_encode(['status' => 200, 'message' => 'Parameter phone deleted successfully.']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Unable to delete parameter phone.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
