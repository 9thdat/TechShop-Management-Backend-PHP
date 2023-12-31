<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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
    $num = $result->rowCount();

    if (!empty($result)) {
        foreach ($result as $row) {
            extract($row);
            $parameterBackupchargerItem = array(
                'id' => $ID,
                'productId' => $PRODUCT_ID,
                'efficiency' => $EFFICIENCY,
                'capacity' => $CAPACITY,
                'timefullcharge' => $TIMEFULLCHARGE,
                'input' => $INPUT,
                'output' => $OUTPUT,
                'core' => $CORE,
                'tech' => $TECH,
                'size' => $SIZE,
                'weight' => $WEIGHT,
                'madein' => $MADEIN,
                'brandof' => $BRANDOF,
                'brand' => $BRAND,
            );
        }

        echo json_encode(['status' => 200, 'data' => $parameterBackupchargerItem]);

    } else {
        echo json_encode(['status' => 404, 'message' => 'Parameter Backupcharger not found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
