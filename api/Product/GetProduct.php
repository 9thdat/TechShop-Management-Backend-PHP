<?php // Error with product have many rows of quantity

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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

    if ($num > 0) {
        $productData = $productData->fetch(PDO::FETCH_ASSOC);
    } else {
        $productData = [];
    }

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

        $productData['QUANTITY'] = $quantities;
    }


    if ($num > 0) {
        echo json_encode(['status' => 200, 'data' => $productData], JSON_PRETTY_PRINT);
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
