<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php'; // Điều chỉnh đường dẫn nếu cần thiết
include_once '../../model/ParameterAdapter.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$parameterAdapter = new ParameterAdapter($db);

try {
    // Lấy mã thông báo từ tiêu đề
    $allHeaders = getallheaders();
    $token = $allHeaders['Authorization'];

    // Xác minh mã thông báo
    if (!$token || !$user->validateToken($token)) {
        // Mã thông báo không hợp lệ hoặc bị thiếu
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
        exit();
    }

    // Lấy dữ liệu được gửi
    $data = json_decode(file_get_contents("php://input"));

    // Kiểm tra xem dữ liệu có trống không
    if (!empty($data->id) &&
        !empty($data->productId) &&
        !empty($data->model) &&
        !empty($data->function) &&
        !empty($data->input) &&
        !empty($data->output) &&
        !empty($data->maximum) &&
        !empty($data->size) &&
        !empty($data->tech) &&
        !empty($data->madein) &&
        !empty($data->brandof) &&
        !empty($data->brand)
    ) {
        // Set các thuộc tính của ParameterAdapter
        $parameterAdapter->setID($data->id);
        $parameterAdapter->setPRODUCT_ID($data->productId);
        $parameterAdapter->setMODEL($data->model);
        $parameterAdapter->setFUNCTION($data->function);
        $parameterAdapter->setINPUT($data->input);
        $parameterAdapter->setOUTPUT($data->output);
        $parameterAdapter->setMAXIMUM($data->maximum);
        $parameterAdapter->setSIZE($data->size);
        $parameterAdapter->setTECH($data->tech);
        $parameterAdapter->setMADEIN($data->madein);
        $parameterAdapter->setBRANDOF($data->brandof);
        $parameterAdapter->setBRAND($data->brand);

        // Thực hiện cập nhật thông tin ParameterAdapter
        if ($parameterAdapter->updateParameterAdapter()) {
            echo json_encode(['status' => 200, 'message' => 'ParameterAdapter updated successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to update ParameterAdapter.']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => 'Incomplete data. Please provide all required fields.']);
    }
} catch (Exception $e) {
    // Xử lý ngoại lệ, bạn có thể muốn ghi log hoặc xử lý khác
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
