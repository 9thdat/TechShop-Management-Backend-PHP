<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php'; // Điều chỉnh đường dẫn theo cần thiết
include_once '../../model/ParameterAdapter.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterAdapter = new ParameterAdapter($db);

try {
    // Lấy token từ tiêu đề
    $allHeaders = getallheaders();
    $token = $allHeaders['Authorization'];

    // Xác thực token
    if (!$token || !$user->validateToken($token)) {
        // Token không hợp lệ hoặc thiếu
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
        exit();
    }

    // Lấy tham số từ URL
    $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : null;

    if ($productId !== null) {
        // Lấy danh sách parameter adapter dựa trên productId
        $result = $parameterAdapter->getParameterAdapterByProductId($productId);

        // Kiểm tra xem có parameter adapter nào hay không
        $num = $result->rowCount();

        if ($num > 0) {
            // Lấy dữ liệu và trả về JSON
            $parameterAdapters = $result->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['status' => 200, 'data' => $parameterAdapters], JSON_PRETTY_PRINT);
        } else {
            // Không tìm thấy parameter adapter nào
            echo json_encode(['status' => 404, 'message' => 'No parameter adapters found for the specified product ID.']);
        }
    } else {
        // Thiếu tham số productId trong URL
        echo json_encode(['status' => 400, 'message' => 'Product ID is required in the URL.']);
    }
} catch (Exception $e) {
    // Xử lý ngoại lệ, có thể ghi log hoặc xử lý khác tùy thuộc vào yêu cầu
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
