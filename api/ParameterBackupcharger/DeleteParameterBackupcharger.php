<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once '../../config/db_azure.php'; // Điều chỉnh đường dẫn theo cần thiết
include_once '../../model/ParameterBackupcharger.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterBackupcharger = new ParameterBackupcharger($db);

try {
    // Lấy token từ tiêu đề
    $allHeaders = getallheaders();
    $token = $allHeaders['Authorization'];

    // Xác minh token
    if (!$token || !$user->validateToken($token)) {
        // Token không hợp lệ hoặc thiếu
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
        exit();
    }

    // Lấy ID từ URL
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    // Xóa parameter_backupcharger
    if ($parameterBackupcharger->deleteParameterBackupcharger($id)) {
        echo json_encode(['status' => 200, 'message' => 'ParameterBackupcharger deleted successfully.']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Unable to delete ParameterBackupcharger.']);
    }
} catch (Exception $e) {
    // Xử lý các ngoại lệ, bạn có thể ghi log hoặc xử lý khác
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>
