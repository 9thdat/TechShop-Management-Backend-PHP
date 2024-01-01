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

    $num = $result->rowCount();

    if ($num === 0) {
        // Discount not found
        http_response_code(404);
        echo json_encode(['status' => 404, 'message' => 'Discount not found']);
    } else {
        foreach ($result as $row) {
            extract($row);

            $result = array(
                'id' => $ID,
                'code' => $CODE,
                'type' => $TYPE,
                'value' => $VALUE,
                'description' => $DESCRIPTION,
                'startDate' => $START_DATE,
                'endDate' => $END_DATE,
                'minApply' => $MIN_APPLY,
                'maxSpeed' => $MAX_SPEED,
                'quantity' => $QUANTITY,
                'status' => $STATUS,
                'createdAt' => $CREATED_AT,
                'updatedAt' => $UPDATED_AT,
                'disabledAt' => $DISABLED_AT,
            );
        }

        // Return a JSON response with the Discount data
        echo json_encode(['status' => 200, 'data' => $result], JSON_PRETTY_PRINT);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>
