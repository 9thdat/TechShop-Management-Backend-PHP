<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8

include_once '../../config/db_azure.php'; // Điều chỉnh đường dẫn khi cần thiết
include_once '../../model/OrderDetail.php';
include_once '../../model/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$database = new db();
$db = $database->connect();

$user = new User($db);
$orderDetail = new OrderDetail($db);

try {
    // Lấy token từ headers
    $allHeaders = getallheaders();
    $token = $allHeaders['Authorization'];

    // Validate token
    if (!$token || !$user->validateToken($token)) {
        // Token không hợp lệ hoặc thiếu
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
        exit();
    }

    // Lấy orderId từ URL
    $orderId = isset($_GET['orderId']) ? $_GET['orderId'] : die();

    // Kiểm tra nếu dữ liệu không rỗng
    if (!empty($orderId)) {
        // Lấy chi tiết đơn hàng dựa trên orderId
        $orderDetails = $orderDetail->getOrderDetailsByOrderId($orderId);

        // Kiểm tra xem có chi tiết đơn hàng hay không
        if ($orderDetails->rowCount() > 0) {
            $array = array();

            // Lặp qua các chi tiết đơn hàng và thêm vào mảng
            foreach ($orderDetails as $row) {
                extract($row);

                $orderDetailItem = array(
                    'id' => $ID,
                    'orderId' => $ORDER_ID,
                    'productId' => $PRODUCT_ID,
                    'color' => $COLOR,
                    'quantity' => $QUANTITY,
                    'price' => $PRICE
                );

                array_push($array, $orderDetailItem);
            }

            // Trả về một JSON response với chi tiết đơn hàng
            echo json_encode(['status' => 200, 'data' => $array], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            // Không có chi tiết đơn hàng nào được tìm thấy
            echo json_encode(['status' => 404, 'data' => []]);
        }
    } else {
        // Dữ liệu không đầy đủ
        echo json_encode(['status' => 400, 'message' => 'Incomplete data. Please provide all required fields.']);
    }
} catch (Exception $e) {
    // Xử lý các ngoại lệ, bạn có thể ghi log hoặc xử lý khác
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
