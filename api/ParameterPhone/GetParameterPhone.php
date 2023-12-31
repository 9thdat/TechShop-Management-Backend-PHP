<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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

    // Get the product ID from the URL
    $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : null;

    if ($productId !== null) {
        // Fetch parameter phones by product ID
        $result = $parameterPhone->GetParameterPhone($productId);

        $num = $result->rowCount();

        if ($num > 0) {
            foreach ($result as $row) {
                extract($row);
                $parameterPhone_item = array(
                    'id' => $ID,
                    'productId' => $PRODUCT_ID,
                    'screen' => $SCREEN,
                    'operatingSystem' => $OPERATING_SYSTEM,
                    'backCamera' => $BACK_CAMERA,
                    'frontCamera' => $FRONT_CAMERA,
                    'chip' => $CHIP,
                    'ram' => $RAM,
                    'rom' => $ROM,
                    'sim' => $SIM,
                    'batteryCharger' => $BATTERY_CHARGER,
                );
                // Push to "data"}

                // Turn to JSON & output
                echo json_encode(['status' => 200, 'data' => $parameterPhone_item], JSON_PRETTY_PRINT);
            }
        } else {
            // No parameter phones found for the given product ID
            echo json_encode(['status' => 404, 'message' => 'No parameter phones found for the given product ID']);
        }
    } else {
        // Product ID is missing
        echo json_encode(['status' => 400, 'message' => 'Product ID is required']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
