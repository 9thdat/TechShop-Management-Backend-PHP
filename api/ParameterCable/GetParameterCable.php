<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/ParameterCable.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterCable = new ParameterCable($db);

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

    // Get the product ID from the query parameters
    $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : null;

    // Check if the product ID is provided
    if ($productId === null) {
        echo json_encode(['status' => 400, 'message' => 'Product ID is required']);
        exit();
    }

    // Proceed to fetch parameter cables by product ID
    $parameterCables = $parameterCable->getParameterCableByProductId($productId);

    // Check if any parameter cables were found
    if ($parameterCables->rowCount() > 0) {
        foreach ($parameterCables as $row) {
            extract($row);
            $parameterCablesArray = array(
                'id' => $ID,
                'productId' => $PRODUCT_ID,
                'tech' => $TECH,
                'function' => $FUNCTION,
                'input' => $INPUT,
                'output' => $OUTPUT,
                'length' => $LENGTH,
                'maximum' => $MAXIMUM,
                'madein' => $MADEIN,
                'brandof' => $BRANDOF,
                'brand' => $BRAND,
            );
        }
        echo json_encode(['status' => 200, 'data' => $parameterCablesArray], JSON_PRETTY_PRINT);
    } else {
        // No parameter cables found for the given product ID
        echo json_encode(['status' => 404, 'message' => 'No parameter cables found for the given product ID']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
