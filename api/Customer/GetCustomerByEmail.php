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

    if (isset($_GET['email'])) {
        // Get the email from the URL
        $email = $_GET['email'];

        // Proceed to get Customer by email
        $customerData = $customer->GetCustomerByEmail($email);
        $num = $customerData->rowCount();

        if ($num > 0) {
            $result = array();

            foreach ($customerData as $row) {
                extract($row);

                $customer_item = array(
                    'email' => $EMAIL,
                    'name' => $NAME,
                    'password' => "",
                    'phone' => $PHONE,
                    'gender' => $GENDER,
                    'birthday' => $BIRTHDAY,
                    'address' => $ADDRESS,
                    'ward' => $WARD,
                    'district' => $DISTRICT,
                    'city' => $CITY,
                    'image' => base64_encode($IMAGE),
                    'status' => $STATUS
                );
            }

            http_response_code(200);
            echo json_encode(['status' => 200, 'data' => $customer_item], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 404, 'message' => 'Customer not found']);
        }


    } else {
        echo json_encode(['status' => 400, 'message' => 'Email is required.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
