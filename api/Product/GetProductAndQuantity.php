<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/Product.php';
include_once '../../model/User.php';

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

    // Proceed to fetch products and quantities
    $result = $product->getProductsAndQuantity();
    $num = $result->rowCount();

    if ($num > 0) {
        $products = array();

        foreach ($result as $row) {
            extract($row);
            $product_item = array(
                'id' => $Id,
                'name' => $Name,
                'price' => $Price,
                'description' => $Description,
                'image' => $Image ? base64_encode($Image) : null,
                'category' => $Category,
                'brand' => $Brand,
                'pre_discount' => $PRE_DISCOUNT,
                'discount_percent' => $DISCOUNT_PERCENT,
                'quantity' => $Quantity,
            );

            array_push($products, $product_item);
        }

        // Return a JSON response with products and quantities
        echo json_encode(['status' => 200, 'data' => $products], JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['status' => 404, 'message' => 'No products found']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
