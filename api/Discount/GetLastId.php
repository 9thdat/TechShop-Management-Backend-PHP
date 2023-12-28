<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php';
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

    // Proceed to fetch the last ID
    $lastId = $discount->getLastId();

    if ($lastId !== null) {
        // Return a JSON response with the last ID
        echo json_encode(['status' => 200, 'data' => [
            'id' => $lastId
        ]], JSON_PRETTY_PRINT);
    } else {
        // Handle the case when there are no rows
        echo json_encode(['status' => 404, 'message' => 'No Discount found'], JSON_PRETTY_PRINT);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>
