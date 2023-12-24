<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php';  // Đảm bảo đường dẫn đến file db_azure.php là chính xác
include_once '../../model/Category.php';

$database = new db();
$db = $database->connect();

$category = new Category($db);

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

    // Hiển thị dữ liệu dưới dạng JSON
    echo json_encode($categories_arr);
} else {
    // Nếu không có danh mục nào
    echo json_encode(
        array('message' => 'Không tìm thấy danh mục.')
    );
}

?>
