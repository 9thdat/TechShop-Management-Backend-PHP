<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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

    // Lấy dữ liệu được gửi
    $data = json_decode(file_get_contents("php://input"));

    // Kiểm tra xem dữ liệu có trống không
    if (!empty($data->orderId)) {
        // Gọi hàm CancelOrderDetail
        if ($orderDetail->cancelOrderDetail($data->orderId)) {
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
