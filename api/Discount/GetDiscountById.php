<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
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

    // Get the Discount ID from the URL
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    // Proceed to fetch the Discount by ID
    $result = $discount->getDiscountById($id);

    if ($result['status'] == 200) {
        // Return a JSON response with the Discount data
        echo json_encode(['status' => 200, 'data' => $result['data']], JSON_PRETTY_PRINT);
    } else {
        // Return a JSON response indicating the Discount was not found
        http_response_code(404);
        echo json_encode(['status' => 404, 'message' => 'Discount not found']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>
