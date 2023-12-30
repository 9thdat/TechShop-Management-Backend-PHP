<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php'; // Điều chỉnh đường dẫn nếu cần thiết
include_once '../../model/Product.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$product = new Product($db);

try {
    // Lấy token từ headers
    $allHeaders = getallheaders();
    $token = $allHeaders['Authorization'];

    // Xác thực token
    if (!$token || !$user->validateToken($token)) {
        // Token không hợp lệ hoặc thiếu
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
        exit();
    }

    // Lấy dữ liệu gửi lên
    $data = json_decode(file_get_contents("php://input"));

    // Kiểm tra xem dữ liệu có đầy đủ không
    if (!empty($data->name) && !empty($data->price) && !empty($data->description) && !empty($data->image) && !empty($data->category) && !empty($data->brand) && !empty($data->preDiscount) && !empty($data->discountPercent)) {
        // Gọi hàm thêm sản phẩm
        if ($product->addProduct($data)) {
            echo json_encode(['status' => 200, 'message' => 'Product created successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to create product.']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => 'Incomplete data. Please provide all required fields.']);
    }
} catch (Exception $e) {
    // Xử lý ngoại lệ, bạn có thể ghi log hoặc xử lý khác nếu cần
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
