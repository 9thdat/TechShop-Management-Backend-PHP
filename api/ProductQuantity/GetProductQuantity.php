<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
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

    if (!isset($_GET['productId'])) {
        // No product ID specified
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Bad Request: No product ID specified']);
        exit();
    }

    // Get the product ID from the URL
    $productId = $_GET['productId'];

    // Get product quantity data
    $quantity_stmt = $productQuantity->getProductQuantity($productId);
    $num = $quantity_stmt->rowCount();

    if ($num > 0) {
        $result = array();

        foreach ($quantity_stmt as $row) {
            extract($row);
            $quantity_item = array(
                'id' => $ID,
                'productId' => $PRODUCT_ID,
                'color' => $COLOR,
                'quantity' => $QUANTITY,
                'sold' => $SOLD,
            );

            array_push($result, $quantity_item);
        }

        // Return a JSON response with product quantity
        echo json_encode(['status' => 200, 'data' => $result], JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['status' => 404, 'message' => 'No product quantity found']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
