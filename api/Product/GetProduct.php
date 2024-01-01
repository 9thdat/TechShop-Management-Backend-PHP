<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/Product.php';
include_once '../../model/User.php';
include_once '../../model/ProductQuantity.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$product = new Product($db);

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

    if (!isset($_GET['id'])) {
        // No product ID specified
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Bad Request: No product ID specified']);
        exit();
    }

    // Get the product ID from the URL
    $productId = $_GET['id'];

    // Get product data
    $productData = $product->getProduct($productId);
    $num = $productData->rowCount();

    // Get product quantity data
    $productQuantity = new ProductQuantity($db);
    $quantity_stmt = $productQuantity->getProductQuantity($productId);
    $num2 = $quantity_stmt->rowCount();

    $quantities = 0;

    if ($num > 0) {
        $quantity_rows = $quantity_stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($quantity_rows as $row) {
            extract($row);
            $quantities += $QUANTITY;
        }

    }

    if ($num > 0) {
        $productArray = [];

        while ($row = $productData->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $product_item = [
                'id' => $ID,
                'name' => $NAME,
                'price' => $PRICE,
                'description' => $DESCRIPTION,
                'category' => $CATEGORY,
                'brand' => $BRAND,
                'preDiscount' => $PRE_DISCOUNT,
                'discountPercent' => $DISCOUNT_PERCENT,
                'image' => $IMAGE ? base64_encode($IMAGE) : null,
                'quantity' => $quantities
            ];
            $productArray[] = $product_item;
        }

    }


    if ($num > 0) {
        echo json_encode(['status' => 200, 'data' => $productArray[0]], JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 404, 'message' => 'Product not found']);
    }

} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>