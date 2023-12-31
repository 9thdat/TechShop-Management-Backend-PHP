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
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
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

    if (!isset($_GET['email']) || empty($_GET['email'])) {
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Missing email']);
        exit();
    }
    // Proceed to fetch staff
    $staff = $user->getStaff($_GET['email']);

    $num = $staff->rowCount();

    if ($num > 0) {
        foreach ($staff as $row) {
            extract($row);

            $staff_item = array(
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
                'role' => $ROLE,
                'status' => $STATUS
            );
        }

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => 'OK', 'data' => $staff_item]);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 404, 'message' => 'No staffs found']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
