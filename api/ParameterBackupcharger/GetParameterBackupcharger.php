<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once '../../config/db_azure.php'; // Điều chỉnh đường dẫn nếu cần
include_once '../../model/ParameterBackupcharger.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterBackupcharger = new ParameterBackupcharger($db);

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

    // Lấy dữ liệu từ URL
    $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : die();

    // Lấy thông số của backup charger theo product ID
    $result = $parameterBackupcharger->getParameterBackupchargerByProductId($productId);

    if (!empty($result)) {
        echo json_encode(['status' => 200, 'data' => $result], JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['status' => 404, 'message' => 'Parameter Backupcharger not found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
