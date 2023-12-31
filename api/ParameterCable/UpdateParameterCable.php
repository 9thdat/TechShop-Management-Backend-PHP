<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Điều chỉnh đường dẫn nếu cần thiết
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

    // Validate token
    if (!$token || !$user->validateToken($token)) {
        // Token không hợp lệ hoặc thiếu
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
        exit();
    }

    // Lấy dữ liệu được gửi
    $data = json_decode(file_get_contents("php://input"));

    // Kiểm tra nếu dữ liệu không rỗng
    if (!empty($data->id) && !empty($data->productId)) {
        $parameterCable->setID($data->id);
        $parameterCable->setPRODUCT_ID($data->productId);
        $parameterCable->setTECH($data->tech);
        $parameterCable->setFUNCTION($data->function);
        $parameterCable->setINPUT($data->input);
        $parameterCable->setOUTPUT($data->output);
        $parameterCable->setLENGTH($data->length);
        $parameterCable->setMAXIMUM($data->maximum);
        $parameterCable->setMADEIN($data->madein);
        $parameterCable->setBRANDOF($data->brandof);
        $parameterCable->setBRAND($data->brand);

        // Gọi hàm cập nhật ParameterCable
        if ($parameterCable->updateParameterCable($data)) {
            echo json_encode(['status' => 204, 'message' => 'ParameterCable updated successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to update ParameterCable.']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => 'Incomplete data. Please provide all required fields.']);
    }
} catch (Exception $e) {
    // Xử lý các ngoại lệ, bạn có thể muốn ghi log hoặc xử lý khác
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
