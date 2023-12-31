<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: PUT   ');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Điều chỉnh đường dẫn khi cần thiết
include_once '../../model/OrderDetail.php'; // Điều chỉnh đường dẫn khi cần thiết
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$orderDetail = new OrderDetail($db);

try {
    // Lấy mã thông báo từ tiêu đề
    $allHeaders = getallheaders();
    $token = $allHeaders['Authorization'];

    // Xác thực mã thông báo
    if (!$token || !$user->validateToken($token)) {
        // Mã thông báo không hợp lệ hoặc thiếu
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
        exit();
    }

    // Lấy orderId từ URL
    $orderId = isset($_GET['orderId']) ? $_GET['orderId'] : die();

    // Kiểm tra xem dữ liệu có trống không
    if (!empty($orderId)) {
        // Gọi hàm CancelOrderDetail
        if ($orderDetail->cancelOrderDetail($orderId)) {
            echo json_encode(['status' => 200, 'message' => 'Order detail canceled successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to cancel order detail.']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => 'Incomplete data. Please provide all required fields.']);
    }
} catch (Exception $e) {
    // Xử lý các ngoại lệ, có thể bạn muốn ghi log hoặc xử lý khác
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>
