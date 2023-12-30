<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once '../../config/db_azure.php'; // Điều chỉnh đường dẫn nếu cần
include_once '../../model/ParameterCable.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterCable = new ParameterCable($db);

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

    // Lấy ID từ URL
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    // Xóa parameterCable
    $result = $parameterCable->deleteParameterCable($id);

    // Trả về JSON response
    echo json_encode($result, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Xử lý exception, bạn có thể ghi log hoặc xử lý khác tùy ý
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
