<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php';
include_once '../../model/Category.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$category = new Category($db);

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

$result = $category->getAllCategory();
$num = $result->rowCount();

if ($num > 0) {
    $categories_arr = array();
    $categories_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $ID,
            'name' => $NAME,
        );

        array_push($categories_arr['data'], $category_item);
    }

    echo json_encode($categories_arr);
} else {
    echo json_encode(
        array('message' => 'Không tìm thấy danh mục.')
    );
}

?>
