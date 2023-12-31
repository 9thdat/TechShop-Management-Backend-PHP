<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php';
include_once '../../model/User.php';
include_once '../../model/Customer.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$customer = new Customer($db);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        // Get the token from the headers\
        $allHeaders = getallheaders();
        $token = $allHeaders['Authorization'];

        // Validate the token
        if (!$token) {
            // Missing token
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'Missing token']);
            return;
        }

        $data = $user->validateToken($token);

        if (!$data) {
            // Invalid token
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => 'Invalid token']);
            return;
        }

        $read = $customer->GetAllCustomers();
        $num = $read->rowCount();

        if ($num > 0) {
            $customers_arr = array();

            foreach ($read as $row) {
                extract($row);
                $customer_item = array(
                    'email' => $EMAIL,
                    'name' => $NAME,
                    'phone' => $PHONE,
                    'gender' => $GENDER,
                    'birthday' => $BIRTHDAY,
                    'address' => $ADDRESS,
                    'ward' => $WARD,
                    'district' => $DISTRICT,
                    'city' => $CITY,
                    'image' => $IMAGE ? base64_encode($IMAGE) : null,
                    'status' => $STATUS
                );

                array_push($customers_arr, $customer_item);
            }

            // Return a JSON response with the list of customers
            echo json_encode(['status' => 200, 'data' => $customers_arr], JSON_PRETTY_PRINT);
        } else {
            // Return an empty array if there are no customers
            echo json_encode(['status' => 200, 'data' => []], JSON_PRETTY_PRINT);
        }
    } catch (Exception $e) {
        // Handle exceptions, you may want to log or handle differently
        http_response_code(500);
        echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
    }
} else {
    // Return an error for non-GET requests
    http_response_code(405);
    echo json_encode(['status' => 405, 'message' => 'Method Not Allowed']);
}
?>
