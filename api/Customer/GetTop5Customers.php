<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/Customer.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$customer = new Customer($db);

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

    // Proceed to fetch top 5 customers
    $top5Customers = $customer->getTop5Customers();

    // Check if there are rows
    if ($top5Customers) {
        $array = array();

        foreach ($top5Customers as $row) {
            extract($row);

            $customerData = array(
                'name' => $name,
                'image' => $image ? base64_encode($image) : null,
                'phone' => $phone,
                'revenue' => $revenue
            );

            array_push($array, $customerData);
        }

        // Return a JSON response with the top 5 customers
        echo json_encode(['status' => 200, 'data' => $array], JSON_PRETTY_PRINT);
    } else {
        // Handle the case when there are no rows
        echo json_encode(['status' => 200, 'data' => []], JSON_PRETTY_PRINT);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>
