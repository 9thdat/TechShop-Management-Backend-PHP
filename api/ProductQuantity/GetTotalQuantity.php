<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php';
include_once '../../model/ProductQuantity.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$productQuantity = new ProductQuantity($db);

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

    // Get parameters from the request
    $productId = isset($_GET['productId']) ? $_GET['productId'] : die();
    $color = isset($_GET['color']) ? $_GET['color'] : die();

    // Get total quantity
    $totalQuantity = $productQuantity->getTotalQuantity($productId, $color);

    $num = $totalQuantity->rowCount();

    if ($num === 0) {
        // Product not found
        http_response_code(404);
        echo json_encode(['status' => 404, 'message' => 'Product not found']);
    } else {
        $row = $totalQuantity->fetch(PDO::FETCH_ASSOC);
        extract($row);

        // Return total quantity
        http_response_code(200);
        echo json_encode(['status' => 200, 'data' => $totalQuantity]);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
