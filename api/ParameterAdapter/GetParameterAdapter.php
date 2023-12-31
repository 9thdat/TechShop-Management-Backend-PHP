<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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
            foreach ($result as $row) {
                extract($row);
                $parameterAdapterItem = array(
                    'id' => $ID,
                    'productId' => $PRODUCT_ID,
                    'model' => $MODEL,
                    'function' => $FUNCTION,
                    'input' => $INPUT,
                    'output' => $OUTPUT,
                    'maximum' => $MAXIMUM,
                    'size' => $SIZE,
                    'tech' => $TECH,
                    'madein' => $MADEIN,
                    'brandof' => $BRANDOF,
                    'brand' => $BRAND,
                );
            }

// Trả về một JSON response với danh sách parameter adapter
            echo json_encode(['status' => 200, 'data' => $parameterAdapterItem]);
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
