<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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
    if (!empty($data->ID) && !empty($data->PRODUCT_ID) && !empty($data->TECH) && !empty($data->FUNCTION) && !empty($data->INPUT) && !empty($data->OUTPUT) && !empty($data->LENGTH) && !empty($data->MAXIMUM) && !empty($data->MADEIN) && !empty($data->BRANDOF) && !empty($data->BRAND)) {
        $parameterCable->setID($data->ID);
        $parameterCable->setPRODUCT_ID($data->PRODUCT_ID);
        $parameterCable->setTECH($data->TECH);
        $parameterCable->setFUNCTION($data->FUNCTION);
        $parameterCable->setINPUT($data->INPUT);
        $parameterCable->setOUTPUT($data->OUTPUT);
        $parameterCable->setLENGTH($data->LENGTH);
        $parameterCable->setMAXIMUM($data->MAXIMUM);
        $parameterCable->setMADEIN($data->MADEIN);
        $parameterCable->setBRANDOF($data->BRANDOF);
        $parameterCable->setBRAND($data->BRAND);

        // Gọi hàm cập nhật ParameterCable
        if ($parameterCable->updateParameterCable($data)) {
            echo json_encode(['status' => 200, 'message' => 'ParameterCable updated successfully.']);
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
