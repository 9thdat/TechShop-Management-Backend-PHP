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
include_once '../../model/ImageDetail.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$imageDetail = new ImageDetail($db);

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

    // Check if the product ID is provided in the URL
    $productId = isset($_GET['ProductId']) ? intval($_GET['ProductId']) : null;

    if (!$productId) {
        // Product ID is missing
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Product ID is required']);
        exit();
    }

    // Proceed to fetch image details by product ID
    $imageDetails = $imageDetail->getImageDetailByProductId($productId);

    $num = $imageDetails->rowCount();

    if ($num > 0) {
        $imageDetailsArray = array();

        while ($row = $imageDetails->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $imageDetailItem = array(
                'id' => $ID,
                'productId' => $PRODUCT_ID,
                'color' => $COLOR,
                'ordinal' => $ORDINAL,
                'image' => $IMAGE ? base64_encode($IMAGE) : null,
            );

            array_push($imageDetailsArray, $imageDetailItem);
        }

        // Return a JSON response with the image details
        echo json_encode(['status' => 200, 'data' => $imageDetailsArray], JSON_PRETTY_PRINT);
    } else {
        // No image details found for the given product ID
        http_response_code(404);
        echo json_encode(['status' => 404, 'message' => 'Image details not found for the given Product ID']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
